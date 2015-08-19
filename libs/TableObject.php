<?php
class TableObject{
    /**
     * @var array
     * These classes are read only. Records can be deleted only by the developer.
     */
    static $readOnlyClasses = array('Default_valu','Pag','Campus','Sub_campus','Config_asset_category','Config_class','Config_employee_department','Config_employee_designation','Config_expense_category','Config_fee_category','Config_receipt_category','Config_user_rol','Crud_pag','Degre','Exam','External_exam','User_rol.php');
    protected static $tablename;
    protected static $dbColumns = array();
    /**
     * @var array
     * pattern: array('tablename' => array('lf', 'ff'))
     * e.g. array('persons' => array('person_id', 'id')
     * lf: local field
     * ff: foreign field
     */
    static $joinedTables = array();
    static $childClasses = array();
    /**
     * @var string
     * which field to match when finding child Recs
     * - e.g. when getChildRecs() is called for a Clas object (with $childRefField = 'class_id'),
     * child recs will be found using condition: "class_id = ".$this->id
     * - If not defined, the default $childRefField is: strtolower(singularize($thisClass))."_id"
     * - See getChildRecs() for usage example
     */
    static $childRefField = '';
    static $displayFields = array();
    private $hasErrors;
    /**
     * @var CalculatedColumn[]
     * You only need to specify the calculated column name and the field after which it comes.
     * e.g. array(name => after, name => after, .....)
     * The rest is taken care of in TableObject and CalculatedColumn classes
     * For every column, the class must have a method that returns its value.
     * This method must be named after the column name
     */
    static $calcColumns = array();
    static $orderBy = ""; // for ordering in sql query
    /**
     * @param null $id
     * @return TableObject
     */
    function __construct( $id = null ){
        if( $id && $obj = static::findById($id) ){
            foreach ( $obj as $key => $value ){ $this->$key = $value; }
            unset($obj);
        }else{
            if(!empty(static::$joinedTables)){
                foreach ( static::$joinedTables as $tbl => $joinCriterion ){
                    $jClass = tbl2cls($tbl);
                    $jObj = new $jClass;
                    foreach ( $jObj as $key => $value ){
                        if($key != 'id'){ $this->$key = $value; }
                    }
                }
            }
        }
        // calculated columns:
        if(!empty(static::$calcColumns)){
            foreach ( static::$calcColumns as $column => $after ){
                $this->$column = new CalculatedColumn($column,$this,$after);
            }
        }
    }
// CREATE / UPDATE methods
    function dbSave(){
        // 1. validate before saving
        // 2. convert to an array
        // 3. call $db->save()
        global $db, $validator;
        $this->validate();
        if( $this->hasErrors ){
            //$this->pr("Error at dbSave() -> hasError");
            return false;
        }
        if(!$db->startTransaction()){ return false; }
        if( !$db->save( $this->todbArray(), $this->tablename() ) ){
            $db->rollback();
            //pr("error at dbsave - save");
            return false;
        }
        $newObject = !isset($this->id->val);
        if($newObject){ $this->id->val = $db->getLastInsId(); }
        // if autoIsert is set for child recs
        if($childClasses = static::childClasses()){
            foreach ( $childClasses as $chClass ){
                if($chClass->autoInsert){
                    $methodName = "autoInsert".$chClass->name;
                    if(!call_user_func( array($this,$methodName) )){
                        $db->rollback();
                        // $this->pr("error at dbsave - autoInsert");
                        return false;
                    }
                }
            }
        }
        $db->endTransaction();
        // save log
        $className = get_called_class();
        if($className != "Log_messag"){
            $msg = $newObject ? "New ".static::classTitle()." Created." : static::classTitle()." Edited.";
            $href = "recordDetail.php?classname=".get_called_class()."&recordId=".$this->id->val;
            $msg .= " Record Id: {$this->id->val} (<a href='{$href}' target='_blank'>{$this->title()}</a>)";
            Log_messag::saveLog($msg);
        }
        return true;
    }
// DELETE methods
    static function dbDelete($id){
        if($obj = static::findById($id)){
            return $obj->dbRemove();
        }
        return new DeleteResponse("Could not delete ".static::classTitle().". Try again later. Code x04");
    }

    /**
     * @return bool
     * checks whether the class record can be edited and deleted.
     * e.g. The Default_value class and the Page class are read only.
     * They are only editable by the developer
     */
    static function isReadOnly(){
        global $user;
        return in_array(get_called_class(),static::$readOnlyClasses) && !$user->isDevlepor();
    }

// READ methods
    /**
     * @param $id
     * @return TableObject
     */
    static function findById($id){ return static::findOneByCondition(static::tablename().".id=".$id); }
    public function dbRemove(){
        // don't go further if the class is read only
        if(static::isReadOnly()){ return new DeleteResponse("This record is read only. Only developer can delete it.", false); }
        // let's begin:
        global $db;
        $response = new DeleteResponse("Successfully deleted ".static::classTitle().".");
        // handle child classes
        foreach ( static::childClasses() as $chClass ){
            $chClassName = $chClass->name;
            if( $chRecs = $this->getChildRecs($chClass->name) ){ // i.e. there are child recs in the db
                // check constraints
                switch ($chClass->onDelete) {
                    case 'restrict':
                        $response->detail = "Can not delete ".static::classTitle().". Please delete ".uc_words($chClassName::tablename())." associated with it first.";
                        $response->succeeded = false;
                        return $response;
                        break;
                    case 'no action':
                        break;
                    case 'cascade':
                        $db->startTransaction();
                        foreach ( $chRecs as $chRec ){
                            if(!$db->deleteById( $chRec->id->val, $chClassName::tablename())){
                                $response->succeeded = false;
                                $response->detail = "Could not delete ".uc_words($chClassName::tablename())." associated with the ".static::classTitle().". Try again later. Code x03";
                                $db->rollback();
                                return $response;
                            }
                        }
                        $response->detail .= "<br>Also deleted all ".uc_words($chClassName::tablename())." associated with it.";
                        break;
                    case 'set null':
                        $db->startTransaction();
                        foreach ( $chRecs as $chRec ){
                            $refField = static::$childRefField;
                            $chRec->$refField->val = null;
                            if( !$chRec->dbSave() ){
                                $response->succeeded = false;
                                $response->detail = "Could not delete ".static::classTitle().". There are ".uc_words($chClassName::tablename())." that are dependent on this ".static::classTitle()." and can not be modified. Try again later. Code x02";
                                $db->rollback();
                                return $response;
                            }
                        }
                        break;
                }
            }
        }
        // we've gotten this far, means everything's ok:
        // try to delete the record
        if( !$db->deleteById( $this->id->val, static::$tablename) ){
            $response->succeeded = false;
            $response->detail = "Could not delete ".static::classTitle().". Try again later. Code x04";
            $db->rollback();
            return $response;
        }
        $db->endTransaction();
        // save log
        $className = get_called_class();
        if($className != "Log_messag"){
            $msg = static::classTitle()." Deleted.";
            $msg .= " Record Id: {$this->id->val} ({$this->title()})";
            Log_messag::saveLog($msg);
        }
        return $response;
    }

    /**
     * @return TableObject[]|Student[]
     */
    static function findAll(){ return static::findByCondition("1"); }

    /**
     * @param $conditionStr
     * @param bool $findOne
     * @param bool $tryPagination
     * @return TableObject[] | Fee_voucher[] | Student_attendance_record[]
     */
    static function findByCondition( $conditionStr, $findOne = false, $tryPagination = true ){
        $sql = "SELECT *,".static::$tablename.".id as id FROM ".static::$tablename;
        // we exclusively include ",static::$tablename.id as id" because join statements cause confusion on the id field
        if(!empty(static::$joinedTables)){
            foreach ( static::$joinedTables as $fTable => $info ){
                $joinCriterion = static::tablename().".".$info[0]."=".$fTable.".".$info[1];
                $sql .= " JOIN $fTable ON $joinCriterion";
            }
        }
        $sql .= " WHERE ".$conditionStr;

        // the following is used for pagination
        global $pagination, $curPage;
        if($tryPagination)
        {
            if($curPage && $curPage->isPaginated()){
                $sql = $pagination->prepSql($sql);
                $curPage->saveConfig('pagination',false);
            }
        }

        if(static::$orderBy){ $sql .= " ORDER BY ".static::$orderBy; }

        // find data
        if($objs = static::findBySql($sql)){
            if($findOne){ return array_shift($objs); }
        }
        return $objs;
    }

    /**
     * @param $str String
     * @return TableObject[]
     * accepts any string value ($str) and returns the result by matching each column with $str
     */
    static function findByString($str){
        $cond = static::getConditionStr($str);
        return static::findByCondition($cond, false, false);
    }

    /**
     * @param $sql
     * @return TableObject[]
     */
    static function findBySql($sql){
        global $db;
        if($records=$db->findBySql($sql)){
            $objArray = array();
            foreach ($records as $key => $record){
                // if the record has an id field, the objects key should be that id value so that it may be accessed easily
                if(isset($record['id'])){ $objArray[$record['id']] = static::instantiate($record); }
                else{ $objArray[] = static::instantiate($record); }
            }
            return $objArray;
        }else{ return false; }
    }

    /**
     * @param $conditionStr
     * @return TableObject | Fine_record
     */
    static function findOneByCondition($conditionStr){return static::findByCondition($conditionStr,true);}

    /**
     * @param $arr
     * @return mixed
     */
    static function instantiate($arr){
        if( !empty($arr) ){
            $classname = get_called_class();
            $obj = new $classname;
            // if there are join tables
            $joindObjs = array();
            if(!empty(static::$joinedTables)){
                foreach ( static::$joinedTables as $fTable => $joinCriterion ){
                    $joinClass = tbl2cls($fTable);
                    $joindObjs[] = new $joinClass;
                }
            }
            foreach( $arr as $key => $value ){
                if( in_array($key,static::$dbColumns) ){
                    $obj->$key->val = $value;
                    if(isset($arr['id'])){ $obj->$key->recordId = $arr['id']; }
                }
                elseif(!empty($joindObjs)){ // check joined objs
                    foreach ( $joindObjs as $jObj ){
                        $joinClass = get_class($jObj);
                        if( in_array($key,$joinClass::$dbColumns) ){
                            $jObj->$key->val = $value;
                            $obj->$key = $jObj->$key;
                            // recordId for editable:
                            $localField = static::$joinedTables[$joinClass::tablename()][0];
                            $obj->$key->recordId = $arr[$localField];
                        }
                    }
                }
            }
            return $obj;
        }
        return static::emptyObject();
    }

    protected static function emptyObject(){
        $classname = get_called_class();
        return new $classname;
    }

// UTILITY METHODS
    /**
     * @return bool
     * Returns true if all the fields of the respective db table are empty.
     * attributes other than table fields are ignored
     */
    function isEmpty(){
        $columns = static::getColumns();
        $empty = true;
        foreach ( $columns as $column => $info ){
            if( !empty($this->$column->val) ){ $empty = false; }
        }
        return $empty;
    }

    static function tablename(){ return static::$tablename; }

    static function classTitle(){ return uc_words(get_called_class()); }

    static function getColumns(){
        $columnList = static::$dbColumns;
        $class = get_called_class();
        $obj = new $class;
        foreach ( $obj as $key => $value ){
            if(!in_array($key,$columnList)){ unset($obj->$key); }
        }
        return $obj;
    }

    /**
     * @return array
     * Returns the columns list, including db columns and calculated columns
     * Automatically adjusts the calc. column position
     */
    static function getColumnsC(){
        $columnList = static::$dbColumns; // array('id','student_id','month','received_amount','comments');
        $cCols = static::$calcColumns; //array('total_amount' => 'student_id','arrears' => 'received_amount')
        foreach ( $cCols as $calCol => $col ){
            // array_search returns the key of the $col
            $position = array_search($col,$columnList)+1;
            $columnList = insert_in_array($columnList,$calCol,$position);
        }
        return $columnList;
    }

    protected static function getConditionStr($query){
        $query = urldecode($query); // query will normally come through the url
        //pr($query);
        $cond = array();
        //$columns = static::getColumns();
        $columns = static::$displayFields;
        $columns[] = 'id';
//        pr($columns);exit;
        foreach ( $columns as $column ){
            if($column != 'id'){ $cond[] = "{$column} LIKE '%{$query}%'";}
            else $cond[] = "{$column} = '{$query}'";
        }
        return join(" OR ", $cond);
    }

    /**
     * @return array
     * returns the field names that are to be displayed when a report is generated for the current class
     * should be overriden if necessary
     */
    static function reportHeads(){
        $result = array();
        $classname = get_called_class();
        $sampleObject = new $classname; // used to: get filter and search options
        foreach ( $sampleObject as $key => $value ){
            if($value instanceof TableColumn){ $result[] = $key; }
        }
        return $result;
    }

    /**
     * @return array
     */
    static function visibleReportHeads(){
        return static::reportHeads();
    }

    static function filterFields(){
        $filterFields = array();
        $classname = get_called_class();
        $sampleObject = new $classname;
//        $sampleObject->pr();pr($sampleObject);
        foreach ( $sampleObject as $key => $value ){
            // filter options:
            // check if:
            // - the field is TableColumn
            // - It is either enum OR it is a select type fkey
            // - It is a date | month | year
            if($value instanceof TableColumn){
                if($value->type == 'enum' || ($value->isFkey() && $value->fkeyInfo->type != "hint") || $value->name == "month" || $value->name == "year"){
                    $value->fkeyInfo->type = "select";
                    $filterFields[$key] = new FilterField($value);
                }elseif($value->name == "date"){
                    $ff = new FilterField($value);
                    $ff->filterType = 'bw';
                    $filterFields[$key] = $ff;
                }
            }
        }
        return $filterFields;
    }

    /**
     * @return array
     * converts the object to an array containing only the fields and their values
     * of the respective database table
     */
    function todbArray(){
        $arr = array();
        $columns = static::getColumns();
        foreach ( $columns as $column => $info ){
            $arr[$column] = isset($this->$column->val)? $this->$column->val : "";
        }
        return $arr;
    }

    static function linkedClasses(){
        global $db;
        $tables =  find_in_array($db->getTablesList(), "^".static::$tablename."__");
        // $tables: all tables with static::$tablename__ at the start (^)
        // pr($tables);
        $output = array();
        if($tables){
            foreach ( $tables as $key => $tablename ){
                $output[] = tbl2cls(str_replace(static::$tablename."__", "", $tablename));
            }
        }
        return $output;
    }

    /**
     * @param $linkedClassName
     * @return array
     * returns the ids of the linked recs
     * e.g. for a particular class config, if you wanna find the subj. combinations,
     * call this function for that class config object
     * it will return an array like array(1,3,4)
     * where 1,3,4 are the ids of the subj. combs. associated with $this class config object
     */
    function getLinkedRecs($linkedClassName){
        global $db;
        $ltable = static::tablename()."__".$linkedClassName::tablename();
        $data = $linkedClassName::tablename()."_id";
        $condition = static::tablename()."_id = ".$this->id;
        $output = array();
        $recs = $db->findBySql("SELECT $data FROM $ltable WHERE $condition");
        if($recs){
            foreach ( $recs as $key => $rec ){ $output[] = $rec[$data]; }
        }
        return $output;
    }

    /**
     * @return mixed|string
     * returns the page_id associated with the class
     * You can use it to find the crud page of the class:
     * href='records.php?page_id='.crudPageId() as done in crudUrl()
     */
    static function crudPageId(){
        global $db;
        return $db->gfv('page_id','crud_pages',"table_name='".static::$tablename."'");
    }

    static function crudUrl(){
        return "records.php?page_id=".static::crudPageId();
    }

    static function childClasses(){
        return array();
    }

    /**
     * @param $childClass
     * @param array $config
     * @return TableObject[] | Fee_voucher_datail[] | Fee_voucher[]
     * possible $config keys: array('condition' => ###)
     */
    function getChildRecs($childClass,$config=array()){
        $thisClass = get_called_class();
        if($this->id->val){
            $chRefColumn = static::$childRefField ? static::$childRefField : strtolower(singularize($thisClass))."_id";
            $condition = $chRefColumn."=".$this->id;
            if( isset($config['condition']) ){ $condition .= " AND ".$config['condition']; }
            return $childClass::findByCondition($condition);
        }
        return false;
    }

    function getAllChildren($config=array()){
        $result = array();
        foreach ( static::childClasses() as $chClass ){
            if( $objs = $this->getChildRecs($chClass->name,$config) ){
                $result[$chClass->name] = $objs;
            }
        }
        return $result;
    }

// VALIDATION
    function validate(){
        global $validator;
        $rules = $this->getValidationRules();
        $arrayToValidate = $this->todbArray();
        foreach ( $rules as $rule => $fields ){
            if($rule == 'MaxLength'){
                foreach ( $fields as $length => $fieldsArray ){
                    $params = array($fieldsArray,$arrayToValidate,$length);
                    $validator->validate($rule, $params );
                }
            }else{
                $params = array($fields,$arrayToValidate);
                $validator->validate($rule, $params );
            }
        }
        // assign errors
        // pr($this);
        foreach ( static::$dbColumns as $column ){
            $field = $this->$column;
            $field->errors = $validator->extractError($column);
            // examine fkeys
            if($field->isFkey() && !empty($field->val)){
                // check value
                $fclass = $field->fkeyInfo->fClass;
                $fField = $fclass::tablename().".".$field->fkeyInfo->fField;
                $condition = $fField."='".$field->val."'";
                $error = "Invalid ".$field->name." provided. Please enter a value that exists in the database.";
                if( $field->fkeyInfo->type == 'live' ){
                    // pr($field);
                    $fieldToMatch = $field->fkeyInfo->fieldToMatch;
                    $condition .= " AND ".$fieldToMatch." = '".$this->$fieldToMatch->val."'";
                    $error = "This ".$field->name." does not exist for the current ".$fieldToMatch;
                }
                if( !$fclass::findOneByCondition($condition) ){
                    $field->errors[] = $error;
                }
            }
            if(!empty($field->errors)){ $this->hasErrors = true; }
        }
    }

    protected function getValidationRules(){
        $columns = static::getColumns();
        $rules = array();
        foreach ( $columns as $field => $col_obj ){
            $field = $this->$field;
            //pr($field);
            // validate only if the value is required or a value is provided and exclude id
            if( $field->required
                && $field->name != 'id'
                || !empty($field->val) ){
                //examine type
                switch ($field->type) {
                    case "int": $rules['NumFields'][] = $field->name; break;
                    case "date":
                        // following line of code is a fix for a problem:
                        // if date is not required and is left empty, a default "0000-00-00" is inserted into the db
                        // it gives an error while validating
                        if(!$field->required){ break; }
                        $rules['Dates'][] = $field->name;
                        break;
                    case "enum": $rules['SelectFields'][$field->name] = $field->enumValues; break;
                }
                // examine length
                if($field->maxLength){ $rules['MaxLength'][$field->maxLength][] = $field->name; }
                // examine required
                if($field->required){ $rules['Required'][] = $field->name; }
                // examine name
                if( preg_match("/phone/", $field->name) ){ $rules['Phones'][] = $field->name; }
                elseif( preg_match("/cnic/", $field->name) ){ $rules['CNICs'][] = $field->name; }
                elseif( preg_match("/year/", $field->name) || $field->type == 'year' ){ $rules['Years'][] = $field->name; }
            }
        }
        return $rules;
    }

    function getErrors(){
        $errors = array();
        foreach ( static::$dbColumns as $column ){
            $field = $this->$column;
            if(!empty($field->errors)){ $errors[$field->name] = join("; ",$field->errors); }
        }
        return $errors;
    }

// DISPLAY METHODS
    function title(){
        $fields = array_flip(static::$displayFields);
        foreach ( $fields as $key => $value ){ $fields[$key] = $this->$key->displayVal(); }
        return join(" ", $fields);
    }

    function get_a_tag($text){
        $class = get_called_class();
        $filename = "recordDetail.php";
        return "<a target='_blank' href='{$filename}?classname={$class}&recordId={$this->id->val}'>{$text}</a>";
    }

    /**
     * @return string
     * returns the markup for the current table
     */
    static function getFormMarkup(){
        // form start
        $output = "<form id='".static::tablename()."Form' class='form-horizontal' role='form' method='POST'>";
        // form controls
        $output .= static::getFormGroups();
        // submit button
        $output .= "<div class='form-group'>";
        $output .= "<div class='col-sm-7 col-sm-offset-3'>";
        $output .= "<input class='form-control btn btn-primary' type='submit' id='submit' name='submit' value='Save to Database'>";
        $output .= "<input type='hidden' id='classname' name='classname' value='".get_called_class()."'>";
        $output .= "</div>";
        $output .= "</div>";
        // form end
        $output .= "</form>";
        return $output;
    }

    /**
     * @return string
     * returns the html form row for each column
     * i.e. divs containing labels and inputs
     */
    static function getFormGroups(){
        $fields = static::getColumns();
        $output = "";
        foreach ($fields as $field){ $output .= $field->getFormGroupMarkup(); }
        return $output;
    }

    function photoMarkup(){
        $photosDir = "photos/";
        $pic = "default.jpg";
        $person_id = $this instanceof Person ? $this->id->val : $this->person_id->val;
        if(file_exists($photosDir.$person_id.".jpg")){ $pic = $person_id.".jpg"; };
        $src = $photosDir.$pic;

        $output = "<div id='photoContainer'>";
        $output .= "<form id='photoUploader' method='POST' enctype='multipart/form-data'>";
        $output .= "<div id='photo'>";
        $output .= "<a href='' class='photoThumb' id='photoThumb'><img src='{$src}'></a>";
        $output .= "<input type='hidden' id='maxFileSize' name='MAX_FILE_SIZE' value='2000000'>";
        $output .= "<input type='hidden' id='person_id' name='person_id' value='{$person_id}'>";
        $output .= "<p class='hidden-print'><input type='file' id='photoInput' name='photoInput' accept='image/*'></p>";
        $output .= "<p class='hidden-print' id='response'></p>";
        $output .= "</form>";
        $output .= "</div>";
        $output .= "</div>";
        return $output;
    }

// DEUGGING METHODS ********************************
    /**
     * @param string $label
     * Used for debugging
     */
    public function pr($label='', $horizontal = true){
        if(!$label){ $label = $this->title(); }
        $output = "<pre class='hidden-print'>";
        $output .= "<h4>$label:</h4>";
        $output .= "<table border='1px solid black'>";
        if($horizontal){
            foreach ( $this as $fieldName => $columnObject ){
                $names[] = $columnObject instanceof TableColumn? $columnObject->name : $fieldName;
                $values[] = $columnObject instanceof TableColumn? $columnObject->val : $columnObject;
                $dispVals[] = $columnObject instanceof TableColumn? $columnObject->displayVal() : $columnObject;
                if($this->hasErrors){ $errors[] = $columnObject instanceof TableColumn? join("; ", $columnObject->errors) : $columnObject;}
            }
            $output .= "<thead><tr><th></th><th>".join("</th><th>", $names)."</th></tr></thead>";
            $output .= "<tr><td>Values</td><td>".join("</td><td>", $values)."</td></tr>";
            $output .= "<tr><td>Display Values</td><td>".join("</td><td>", $dispVals)."</td></tr>";
            if($this->hasErrors){ $output .= "<tr><td>Errors</td><td>".join("</td><td>", $errors)."</td></tr>";}
        }else{
            $output .= "<thead><tr><th>Field</th><th>Value</th><th>Disp. Value</th></tr></thead>";
            foreach ( $this as $fieldName => $columnObject ){
                $output .= "<tr><td>".$fieldName."</td><td>".$columnObject."</td><td>";
                $output .= get_class((object)$columnObject) == "TableColumn"? $columnObject->displayVal() : "";
                $output .="</td></tr>";
            }
        }
        $output .= "</table>";
        $output .= "</pre>";
        echo $output;
    }

    function prv($label=''){ $this->pr($label,false); }

    function prChildRecs(){
        $children = $this->getAllChildren();
        echo "<pre><div style='border: 2px solid #666; padding: 5px;'>";
        echo "<h3>Children of ".$this->title().":</h3>";
        foreach ( $children as $chClass => $value ){
            echo "<h4>".plural($chClass).":</h4>";
            foreach ( $value as $k => $v ){
                $v->pr();
            }
        }
        echo "</div></pre>";
    }


}







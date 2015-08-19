<?php
/**
 * Created by EngrNaveed.
 * Date: 01-Jan-15
 * Time: 11:48 AM
 */

class TableColumn {
    public $name;
    public $val;
    public $displayVal;
    public $table;
    /**
     * @var int
     * stores the record id to which this column belongs
     * intialized automatically in TableObject class
     */
    public $recordId;
    public $defValue;
    public $required;
    public $key;
    public $maxLength;
    public $type;
    public $enumValues;
    public $fkeyInfo;
    public $dependantFields = array();
    public $errors;

    function __construct( $type, $mxlnth, $req=false, $def='', $key='', $enumVals = array() ){
        // ALTER TABLE `config_asset_categories` ADD `test` INT( 23 ) NOT NULL DEFAULT '23', ADD UNIQUE
        $this->defValue = $def;
        $this->required = $req;
        $this->key = $key;
        $this->maxLength = $mxlnth;
        $this->type = $type;
        $this->enumValues = $enumVals;
        $this->fkeyInfo = new FKeyInfo(null, null,null);
    }

    private function getDependantFieldsAttribs(){
        $dependantFields = !empty($this->dependantFields) ? join(",",$this->dependantFields) : "";
        $depFieldsAttribs = $dependantFields? "data-dependantFields='{$dependantFields}'" : "";
        return $depFieldsAttribs;
    }

    public function getFormGroupMarkup(){
        $output = "";
        if( $this->name != 'id' ){ // don't show input for id field, it is supposed to be auto incremented
            $errorClass = isFormSubmitted() ? " has-success": "";
            $error = $this->getError();
            if(!empty($error)){ $errorClass = " has-error"; }
            $output .= "<div class='form-group".$errorClass."'>";
            $output .= "<label for='".$this->name."' class='col-sm-3 control-label'>".uc_words($this->name)."</label>";
            $output .= "<div class='col-sm-7'>";
            $output .= $this->getInputMarkup();
            $output .= $error;
            $output .= "</div>";
            $output .= "</div>";
        }
        return $output;
    }

    /**
     * @return string
     * returns the input markup for a specific table column
     */
    public function getInputMarkup($config=array()){
        //if($this->name == 'exam_id'){ pr($this); }
        // following is used in auto insertForm:
        if(isset($config['name'])){ $this->name = $config['name']; }
        // the rest is core functionality
        $required = $this->required ? "required" : "";
        $maxLength = $this->maxLength ? "maxlength = '".$this->maxLength."'" : "";
        $id_name = "id='".$this->name."' name='".$this->name."'";
        $classes = "class='form-control'";
        $dataType = "data-type='input'";
        $depFieldsAttribs = $this->getDependantFieldsAttribs($this);
        if($depFieldsAttribs){ $classes = "class='form-control liveFKeyParent'"; }
        // decide value
        if( $form = isFormSubmitted() ){ $this->val = $form[$this->name]; }
        else{ if(!$this->val && get_called_class() != 'FilterField'){ $this->val = $this->defValue ? $this->defValue : ""; } }
        $value = "value='".$this->val."'";

        $inputFinalPart = $classes." ".$id_name." $dataType $depFieldsAttribs $value  ".$maxLength." ".$required.">";

        $output = "<input ".$inputFinalPart;
        // fkey info is treated specially:
        if( !empty($this->fkeyInfo->fClass) ){ $this->type = 'fkey'; }

        if( preg_match('/month$/',$this->name ) ){
            global $html;
            $output = "<select $id_name $classes data-type='select'>";
            $output .= $html->monthsOptions($this->val);
            $output .= "</select>";
        }
        elseif( $this->type == 'int' ){
            $output = "<input type='number' ".$inputFinalPart;
        }
        elseif( $this->type == 'date' ){
            $output = "<input type='date' ".$inputFinalPart;
        }
        elseif( $this->type == 'text' ){
            $value = $this->val ? $value : "";
            $output = "<textarea $id_name $classes data-type='textarea' $required>{$this->val}</textarea>";
        }
        elseif( $this->type == 'fkey' ){
            $output = $this->getFkeyInputMarkup($config);
        }
        elseif( $this->type == 'enum' ){
            $output = "<select $id_name $classes data-type='select'>";
            global $html;
            $output .= $html->getHtmlOptionsForArray($this->enumValues, $this->val, $config);
            $output .= "</select>";
        }
        elseif( preg_match("/phone/", $this->name)){
            $output = "<input type='tel' ".$inputFinalPart;
        }
        elseif( preg_match("/email/", $this->name)){
            $output = "<input type='email' ".$inputFinalPart;
        }
        elseif( preg_match("/password/", $this->name)){
            $output = "<input type='password' ".$inputFinalPart;
        }
        return $output;
    }

    public function getInputForEditable(){
        if( $this->name != 'id' ){
            $output = "<div id='".$this->table."-".$this->name."-input' class='inputForEditable'>";
            $output .= $this->getInputMarkup();
            $output .= "</div>";
            return $output;
        }
        return "";
    }

    /**
     * @param $fClass
     * @param $fField
     * @return string
     * used by getFkeyInputMarkup()
     */
    private function getOptions($fClass,$fField){
        $output = "";
        $records = $fClass::findAll();
        if($records){
            foreach ( $records as $key => $fObj ){
                $selected = $fObj->$fField == $this->val ? "selected" : "";
                $output .= "<option $selected value='{$fObj->$fField}'>{$fObj->title()}</option>";
            }
        }
        return $output;
    }

    private function getFkeyInputMarkup($config=array()){
        $type = $this->fkeyInfo->type;
        $fClass = $this->fkeyInfo->fClass;
        $fField = $this->fkeyInfo->fField;
        $output = "";
        $classes = "class='form-control'";
        $depFieldsAttribs = $this->getDependantFieldsAttribs();
        if($depFieldsAttribs){ $classes = "class='form-control liveFKeyParent'"; }
        $id_name = "id='".$this->name."' name='".$this->name."' $depFieldsAttribs";
        $value = "value='".$this->val."'";
        switch ($type) {
            case 'select':
                $output = "<select $id_name $classes>";
                if(isset($config['addEmptyOption']) && $config['addEmptyOption'] == true ){ $output .=  "<option></option>"; }
                $output .= $this->getOptions($fClass,$fField);
                $output .= "</select>";
                break;
            case 'hint':
                $classes = "class='form-control fkeyInput'";
                $dataAttribs = "data-classname='{$fClass}'";
                $dataAttribs .= " data-fieldname='{$fField}'";
                $displayCols = join(" | ", $fClass::$displayFields);
                $placeHolder = "placeholder='Enter ".$this->name." or Type $displayCols for Hints.'";
                $output .= "<input $id_name $classes $dataAttribs $placeHolder $value>";
                $href = $fClass::crudUrl()."#".$fClass::tablename()."Form";
                $output .= "<a href='{$href}' target='_blank'>".icon("plus")." Add a New ".$fClass."</a>";
                break;
            case 'live':
                $output .= "<select $id_name $classes data-classname='".tbl2cls($this->table)."'>";
                if(isset($config['addEmptyOption']) && $config['addEmptyOption'] == true ){ $output .=  "<option></option>"; }
                $output .= $this->getOptions($fClass,$fField);
                $output .= "</select>";
                break;
        }
        return $output;
    }

    public function getError(){
        global $formErrors;
        $errorStr = "";
        if(is_array($formErrors) && array_key_exists($this->name,$formErrors)){
//            pr($formErrors,'exists...');
            $errorStr = "<div class='has-error'><p>";
            $errorStr .= join("</p><p>",$formErrors[$this->name]);
            $errorStr .= "</p></div>";
        }
        return $errorStr;
    }

    public function __toString(){
        return (string)$this->val;
    }

    public function a_tag($text=""){
        // show displayVal() bt default
        if(!$text){ $text = $this->displayVal(); }
        // a tag will be different for fkeys
        if($this->isFkey()){
            $class = $this->fkeyInfo->fClass;
            $recordId = $this->val;
        }else{
            $class = tbl2cls($this->table);
            $recordId = $this->recordId;
        }
        // file to direct to:
        $filename = "recordDetail.php";
        // return tag
        return "<a target='_blank' href='{$filename}?classname={$class}&recordId={$recordId}'>{$text}</a>";
    }

    public function getEditableValue(){
        if($this->name == 'id'){ return $this->val; }
        //recordId
        $recordId = $this->recordId;
        if($this->isFkey()){  }
        // attributes
        $id = "id='".$this->table."-".$this->name."'";
        $value = "data-value='".$this->val."'";
        $class = "class='editable'";
        $cellId = "data-cell-id='".encrypt($this->table."-".$this->name."-".$recordId)."'";
//        $cellId = "data-cell-id='".$this->table."-".$this->name."-".$recordId."'";
        $attributes = $id." ".$value." ".$class." ".$cellId;
        return "<span $attributes>".$this->displayVal()."</span>";
    }

    public function displayVal(){
        if( $this->type == 'date' ){ return formatDate($this->val, "%d-%b-%y"); }
        if( $this->type == 'timestamp' ){ return date("D, d-M-Y h:i:s A",strtotime($this->val)); }
        if(preg_match('/month$/',$this->name ) || $this->name == 'starting_month' || $this->name == 'ending_month'){ return formatDate("1970-".$this->val."-01", "%B"); }
        // default display value for each column is its value itself
        // e.g. fkeys have different val and displayVal
        if( !empty($this->fkeyInfo->fClass) && !empty($this->val) ){
            // echo "<p>checking: ".$this->name.": ".$this->val." ...... ";
            $fClass = $this->fkeyInfo->fClass;
            if($fObj = $fClass::findOneByCondition($fClass::tablename().".".$this->fkeyInfo->fField."='".$this->val."'")){
                // echo $fObj->isEmpty() ? "No result" : "Got: '".$fObj->title()."'</p>";
                return $fObj->title();
            }
        }
        if( !$this->displayVal ){ return $this->val; }
        return $this->displayVal;
    }

    public function isFkey(){
        return !empty($this->fkeyInfo) && !empty($this->fkeyInfo->fClass);
    }
}
<?php

/**
 * Class MySQLDatabase
 */
class MySQLDatabase{
	private $connection;	//handle to the database connection
	private $magic_quotes_active;
	private $new_enough_php; // i.e. PHP >= v4.3.0
	public $lastQuery;	// stores the last query made by the user. (used in query() & checkQuery()..)
    /**
     * @var string
     * if not empty, implies that a transaction is being performed
     */
//    private $transQuery;

    function __construct($db_name=DB_NAME){
		// Calls openConnection() so a connection is established as soon as an object is created.
        // Initializes the variables as well
		$this->openConnection($db_name);
		$this->magic_quotes_active = get_magic_quotes_gpc();
		$this->new_enough_php = function_exists( "mysqli_real_escape_string" ); // i.e. PHP >= v4.3.0
	}

    /**
     * @param $table_name
     * @return array of field objects
     * e.g.
     * [name] => religion
     * [table] => persons
     * [def] =>
     * [max_length] => 0
     * [not_null] => 0
     * [primary_key] => 0
     * [multiple_key] => 0
     * [unique_key] => 0
     * [numeric] => 0
     * [blob] => 0
     * [type] => string
     * [unsigned] => 0
     * [zerofill] => 0
     */
    public function getTableColumns($table_name){
        $tableFields = array(); // return value
        $result = $this->query("SHOW COLUMNS FROM " . $table_name);
        while ($res = $this->getRow($result)) {
            $field = new stdClass();
            // name
            $field->name = $res['Field'];
            // table name
            $field->table = $table_name;
            // default value
            $field->defValue = $res['Default'];
              // check for default value in configuration table
            // NOTE: The following line is commented out bcz I have changed mmy mind. default values will not be stored in the db
//            $field->def = $this->getDefaultValue($field);
            // required attribute
            $field->required = $res['Null'] == 'NO' ? true : false;
            // key type
            $field->key = $res['Key'];
            // type and length
            $field->max_length = 0;
             // if there is a foriegn key relationship of this column:
            // NOTE: The following line is commented out bcz I have changed mmy mind. $fkey_relations will not be stored in the db
//            $fkey_relation = $this->getFKeyRelation( $field->table, $field->name );
            $fkey_relation = null;
            if( $fkey_relation ){
                $field->type = 'fkey';
                $field->fkey_info = $fkey_relation;
            }
            else{ // get field and type from $res['Type']
                $type_length = explode( "(", $res['Type'] );
                $field->type = $type_length[0];
                if( count($type_length) > 1 ){ // some times there is no "("
                    $field->max_length = (int)$type_length[1];
                    if( $field->type == 'enum' ){ // enum has some values  'Male','Female')
//                    preg_match( "/'.*(',)|('\))/", $type_length[1], $matches );
                        $matches = explode( "'", $type_length[1] );
                        foreach($matches as $match){
                            if( $match && $match != "," && $match != ")" ){ $field->enumValues[] = $match; }
                        }
                    }
                }
            }
            // everything decided for the field, add it to the array
            $tableFields[] = $field;
        }
        return $tableFields;
    }

    public function getHtmlTable( $sql, $config = array() ) {
        // find the mySQL data
        $resource = $this->query($sql);
        // number of columns
        $output['numFields'] = $numfields = mysqli_num_fields($resource);
        // table start
        $output['markup'] = "<table class='table table-primary table-striped table-hover'><thead><tr>";
        // headings in header row
        for ($i = 0; $i<$numfields; $i += 1) {
            $output['fields'][] = $field = mysqli_fetch_field_direct($resource, $i);
            $output['markup'] .= "<th>".uc_words($field->name)."</th>";
        }
        // empty header cell for edit & delete button
        if( isset($config['page_id']) ){
            $output['markup'] .= "<th></th>";
        }
        // end of thead
        $output['markup'] .= "</tr></thead><tbody>";
        // flag to indicate if data was found
        $dataFound = false;
        // start of tbody, table rows
        while ($row = mysqli_fetch_assoc($resource)) {
            $dataFound = true;
            $output['markup'] .= "<tr>";
            for ($i = 0; $i<$numfields; $i += 1) {
                $field = mysqli_fetch_field_direct($resource, $i);
                $output['markup'] .= "<td><span ".$this->getHtmlAttributes($field,$row).">".$row[$field->name]."</span></td>";
            }
            if( isset($config['page_id']) ){
                // delete button
                $href = appendToCurrentUri(array('record_id'=>$row['id'], 'delete'=>'true'));
                $delete_link = "<a href='".$href."' class='danger_link' data-recId='".encrypt( $field->table."-".$row['id'] )."'>".icon("remove")."</a>";
                // open link
                $href = "recordDetail.php?classname=".tbl2cls($field->table)."&recordId=".$row['id'];
                $openLink = "<a href='".$href."' target='blank'>".icon("folder-open")."</a>";
                $output['markup'] .= "<td>$openLink&nbsp;&nbsp;&nbsp;&nbsp;$delete_link</td>";
            }
            $output['markup'] .= "</tr>";
        }
        // Show error if no data was found
        if(!$dataFound){
            $colspan = isset($config['page_id']) ? ($numfields+1) : $numfields;
            $output['markup'] .= "<tr><td class='warning' colspan='".$colspan."'>No Data Found.</td></td></tr>";
        }
        // end of table
        $output['markup'] .= "</tbody></table>";
        return $output;
    }

    public function showTable($sql){
        $output = $this->getHtmlTable($sql);
        echo $output['markup'];
    }

    private function getHtmlAttributes($field, $row){
        if( isset($row['id']) ){
            $attributes = "";
            if( $field->table && $field->name && $field->name !='id' && $row['id'] ){
                $cellId = encrypt( $field->table."-".$field->name."-".$row['id'] );
                $idAttr = "data-cell-id='".$cellId."'";
                $idAttr .=  " data-input-id='".$field->name."'";
                $classAttr = "class='editable'";
                $attributes = $idAttr." ".$classAttr;
            }
            return $attributes;
        }
        return null;
    }

    /**
     * @param $tblName
     * @return array
     * returns an array that contains all the column names for a table
     * e.g. getTableFields('user'); returns:
     * Array
     * (
     *     [0] => id
     *     [1] => username
     *     [2] => password
     *     [3] => firstName
     *     [4] => lastName
     * )
     */
    public function getTableFieldsList($tblName){
        $tableFields = array();
        $result = $this->query("SHOW COLUMNS FROM " . $tblName);
        while ($res = $this->getRow($result)) {
            $tableFields[] = $res['Field'];
        }
        return $tableFields;
    }

    public function getTablesList($db_name=DB_NAME){
        $result = $this->findBySql("SHOW tables FROM " . $db_name);
        $tables_list = array();
        foreach ($result as $key => $arr) {
            $tables_list[] = $arr['Tables_in_' . $db_name];
        }
        return $tables_list;
    }

    function tableExists($tablename,$db_name=DB_NAME){
        $tablesList = $this->getTablesList($db_name);
        if(in_array($tablename,$tablesList)){ return true; }
        return false;
    }

    public function getRow($tblObject){
	// returns a row from a table objet resulting from a query
		return mysqli_fetch_assoc($tblObject);
	}

    public function affectedRowsCount(){
		return mysqli_affected_rows($this->connection);
	}

    public function getLastInsId(){
		return mysqli_insert_id($this->connection);
	}

	public function getNumRows($tblObject){
		return mysqli_num_rows($tblObject);
	}

    public function findBySql($sql){
        $resourse = $this->query($sql);
        // fetch rows
        while ($row = $this->getRow($resourse)) {
            $recArray[] = $row;
        }
        return !empty($recArray)? $recArray : "";
    }

    public function findById($id,$tblName){
        $sql = "select * from " . $tblName . " where id=" . $this->dbEscape($id);
        $recArray = $this->findBySql($sql);
        return !empty($recArray)? array_shift($recArray) : false;
    }

    public function findAll($tblName){
        $sql = "select * from " . $tblName;
        $recArray = $this->findBySql($sql);
        return !empty($recArray)? $recArray : false;
    }

    /**
     * @param $array
     * @param $tblName
     * @return bool
     * Saves an array $array to a table $tblName
     * The $array could contain enteries that may not belong to $tblName so we find tableFields first so that only related fields are saved to the db
     */
    public function save( $array, $tblName ){
//        $tblFields = array_flip( $db->getTableFieldsList($tblName) );
        $classname = tbl2cls($tblName);
        $arrayToSave = obj2arr( $classname::getColumns());
        $dataFound = false;
        foreach ($arrayToSave as $field => $value) {
            if( array_key_exists( $field , $array) ){
                $arrayToSave[$field] = $array[$field];
                $dataFound = true;
            }else{
                unset( $arrayToSave[$field] );
            }
        }
        if($dataFound){
            if(isset($arrayToSave['id']) && !empty($arrayToSave['id'])){
//                pr("updating...");
                // i.e. the record already exists, update it
                return $this->update($arrayToSave,$tblName);
            }else{
//                pr("creating...");
                // i.e. the record does not already exist, create it
                return $this->create($arrayToSave,$tblName);
            }
        }
        return false;
    }

    public function create($row,$tblName){
        // escape values before inserting
        foreach ($row as $key => $value) {
            $row[$key] = $this->dbEscape( $value );
        }
        // sql format:
        // $sql = "insert into tblUsers (username, password, firstName, lastName) values ('a','b','c','d')";
        $sql = "insert into " .  $tblName;
        $sql.= " (" . join("," , array_keys($row));
        $sql.= ") values ('";
        $sql.= join( "' , '" , array_values($row) ) . "')";

        $this->query($sql);
        if( $this->affectedRowsCount() == 1 ) { return true; }
        else { return false; }
    }

    private function geAttributePairs($row){
        // returns an array that contains the table attributes and their values as pairs in a string for the current object.
        // used by update() to update a record into a database.
        // e.g. geAttributePairs(); returns:
        // Array
        // (
        //     [0] => username='naveed'
        //     [1] => password='123456'
        //     [2] => firstName='Engr.'
        //     [3] => lastName='Naveed'
        // )
        $kvpairs = array();
        foreach ($row as $key => $value) {
            $kvpairs[] = $key . "='" . $value . "'";
        }
        return $kvpairs;
    }

    /**
     * @param $row
     * @param $tblName
     * @param null $condition
     * @return bool
     */
    public function update($row,$tblName,$condition=NULL){
        // escape values before inserting
        foreach ($row as $key => $value) {
            $row[$key] = $this->dbEscape( $value );
        }
        $kvpairs = $this->geAttributePairs($row);
        // sql format:
        // $sql = "update tblUsers set username='a' , password='b' where id=5 limit 1";
        $sql = "update " . $tblName;
        $sql .= " set ";
        $sql .= join("," , array_values($kvpairs));
        $sql .= " where ";
        $sql .= $condition? $condition : "id=" . $row['id'];
        // $sql .= " limit 1";

        if( $this->query($sql) ) { return true; }
        else { return false; }
    }

    public function delete($tblName , $condition){
        if($condition){
            $sql = "delete from " . $tblName;
            $sql .= " where ";
            $sql .= $condition;
            $this->query($sql);
            return true;
            // if( $this->affectedRowsCount() >= 1 ) { return true; }
        }
        return false;
    }

    public function deleteById($id, $tableName){
        return $this->delete($tableName, "id=".$id);
    }

    public function getPK($table){
        $data = $this->findBySql("SHOW KEYS FROM ".$table." WHERE Key_name = 'PRIMARY'");
        if($data){ return $data[0]['Column_name']; }
        return false;
    }

    public function gfv( $fields , $tbl , $condition ){	//get Field Values
        if(is_array($fields)){ $data = implode("," , $fields); }
        else{ $data = $fields; }
        $res = $this->findBySql("SELECT ".$data." FROM ".$tbl." WHERE ".$condition);
        // pr($res);
        if($res){
            if(is_array($fields)){ return array_shift($res); }
            else{ return $res[0][$fields]; }
        }
        return "";
    }

    private function openConnection($db_name){
        // connects to the database using the server, the user & the password defined in the config.php.
        // So it requires config.php.
        $this->connection = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,$db_name);
        if(!$this->connection){
            die("Database connection failed: " . mysqli_error($this->connection));
        }
//        else {
//            $this_selected = mysqli_select_db($db_name,$this->connection);
//            if(!$this_selected){
//                die("Database connection failed: " . mysqli_error($this->connection));
//            }
//        }
    }

    public function closeConnection(){
        // closes the connection
        if(isset($this->connection)) {
            mysqli_close($this->connection);
            unset($this->connection);
        }
    }

    public function dbEscape($value) {
        // prepares the $value in a format that mySQL understands
        if( $this->new_enough_php ) {
            // PHP v4.3.0 or higher
            // undo any magic quote effects so mysqli_real_escape_string can do the work
            if( $this->magic_quotes_active ) { $value = stripslashes( $value ); }
            $value = mysqli_real_escape_string($this->connection, $value );
        } else {
            // before PHP v4.3.0
            // if magic quotes aren't already on then add slashes manually
            if( !$this->magic_quotes_active ) { $value = addslashes( $value ); }
            // if magic quotes are active, then the slashes already exist
        }
        return $value;
    }

    private function checkQuery($queryResult){
        if(!$queryResult){
            $error = "Database query failed!<br>". mysqli_error($this->connection) . "<br>";
            $error .= "Last query made: " . $this->lastQuery;
            die($error);
        }
    }

//    private function isDMLCommand($queryString){
//        return preg_match("/insert|update|delete/i", $queryString);
//    }

    public function startTransaction(){
        if(mysqli_autocommit($this->connection, FALSE)){ return true; }
        return false;
    }

    public function endTransaction(){
        if(!mysqli_commit($this->connection)){ return false; }
        return true;
    }

    function rollback(){
        if( !mysqli_rollback($this->connection) ){ return false; }
        return true;
    }

    public function query($queryString){
//        if( !empty($this->transQuery) && $this->isDMLCommand($queryString) ){
//            $this->transQuery .= $queryString."; ";
//            return true;
//        }else{
            // performs a mySQL query & if the query succeeds, it returns a table object (in case of SELECT, DESCRIBE SHOW etc) or true (in case of INSERT, UPDATE, DELETE etc). Otherwise returns false.
            $this->lastQuery = $queryString;
            // echo "<span class='query'>". $this->lastQuery . "</span><br>";
            $result = mysqli_query($this->connection,$queryString);
            //$this->checkQuery($result);
            return $result;
//        }
    }
}

$db = new MySQLDatabase();

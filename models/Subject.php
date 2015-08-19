<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Sun 18-Jan-2015
 * Time: 08:18 PM PST
 */
class Subject extends SubjectAuto{
	static $joinedTables = array();
	static $childRefField = '';
	static $displayFields = array('title');

	function __construct($id = null){
		parent::__construct($id);
	}

    function subjectCombinations(){
        global $db;
        $ltable = Subject_combination::tablename()."__".static::tablename();
        $data = Subject_combination::tablename()."_id";
        $condition = static::tablename()."_id = ".$this->id;
        $output = array();
        $recs = $db->findBySql("SELECT $data FROM $ltable WHERE $condition");
        if($recs){
            foreach ( $recs as $key => $rec ){ $output[] = $rec[$data]; }
        }
        return $output;
    }


}
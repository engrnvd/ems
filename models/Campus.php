<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Sun 18-Jan-2015
 * Time: 08:18 PM PST
 */
class Campus extends CampusAuto{
	static $joinedTables = array();
	static $childRefField = 'campus_id';
    static $displayFields = array('title');

	function __construct($id = null){
		parent::__construct($id);
	}


    static function childClasses(){
        return array(
            new ChildClass('Clas', 'restrict'),
        );
    }


}
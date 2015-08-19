<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Sun 18-Jan-2015
 * Time: 08:18 PM PST
 */
class Guardian extends GuardianAuto{
    static $displayFields = array('first_name','last_name');
//    static $displayFields = array('person_id');
    static $joinedTables = array('persons' => array('person_id', 'id'));
	static $childRefField = 'guardian_id';

	function __construct($id = null){
		parent::__construct($id);
        $this->person_id->fkeyInfo = new FKeyInfo('Person','id','hint');
	}

    static function childClasses(){
        return array(
            new ChildClass('Student', 'restrict'),
        );
    }



}
<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Sun 18-Jan-2015
 * Time: 08:18 PM PST
 */
class Person extends PersonAuto{
	static $joinedTables = array();
	static $childRefField = 'person_id';
    static $displayFields = array('first_name','last_name');

	function __construct($id = null){
		parent::__construct($id);
        $this->father_id->fkeyInfo = new FKeyInfo('Person','id','hint');
	}

    static function childClasses(){
        return array(
            new ChildClass('Student', 'restrict'),
            new ChildClass('Employe', 'restrict'),
            new ChildClass('Guardian', 'restrict'),
        );
    }


}

<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Sun 18-Jan-2015
 * Time: 08:18 PM PST
 */
class Father extends FatherAuto{
	static $joinedTables = array('guardians' => array('guardian_id', 'id'));
	static $childRefField = 'father_id';
	static $displayFields = array('guardian_id');

	function __construct($id = null){
		parent::__construct($id);
        $this->guardian_id->fkeyInfo = new FKeyInfo('Guardian','id','hint');
	}

    static function childClasses(){
        return array(
            new ChildClass('Person', 'restrict'),
        );
    }



}
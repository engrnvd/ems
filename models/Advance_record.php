<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Sun 18-Jan-2015
 * Time: 08:18 PM PST
 */
class Advance_record extends Advance_recordAuto{
	static $joinedTables = array();
	static $childRefField = 'advance_record_id';
	static $displayFields = array('employee_id','amount');

	function __construct($id = null){
		parent::__construct($id);
        $this->employee_id->fkeyInfo = new FKeyInfo('Employe','employee_id','hint');
	}

    static function childClasses(){
        return array(
            new ChildClass('Advance_return_record', 'restrict'),
        );
    }


}

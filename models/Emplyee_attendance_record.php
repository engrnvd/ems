<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Sun 18-Jan-2015
 * Time: 08:18 PM PST
 */
class Emplyee_attendance_record extends Emplyee_attendance_recordAuto{
	static $joinedTables = array();
	static $childRefField = '';
	static $displayFields = array('employee_id','date');

	function __construct($id = null){
		parent::__construct($id);
        $this->employee_id->fkeyInfo = new FKeyInfo('Employe','id','hint');
	}




}
Emplyee_attendance_record::$childClasses = array(
    	//new ChildClass('ClassName', 'restrict'),
    );
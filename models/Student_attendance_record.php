<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Sun 18-Jan-2015
 * Time: 08:18 PM PST
 */
class Student_attendance_record extends Student_attendance_recordAuto{
	static $joinedTables = array();
	static $childRefField = '';
	static $displayFields = array('student_id','class_attendance_record_id');

	function __construct($id = null){
		parent::__construct($id);
        $this->class_attendance_record_id->fkeyInfo = new FKeyInfo('Class_attendance_record','id','hint');
        $this->student_id->fkeyInfo = new FKeyInfo('Student','id','hint');
	}




}

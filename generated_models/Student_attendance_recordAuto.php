<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Wed 11-Mar-2015
 * Time: 07:39 PM PST
 */
class Student_attendance_recordAuto extends TableObject{
	protected static $tablename = 'student_attendance_records';
	public $id;
	public $class_attendance_record_id;
	public $student_id;
	public $lectures_attended;
	static $dbColumns = array('id','class_attendance_record_id','student_id','lectures_attended');

	function __construct($id = null){
		$this->id = new TableColumn( 'int', '11', true, '', 'PRI' );
		$this->class_attendance_record_id = new TableColumn( 'int', '11', true, '', '' );
		$this->student_id = new TableColumn( 'int', '11', true, '', '' );
		$this->lectures_attended = new TableColumn( 'int', '1', false, '', '' );
		// get default value
		foreach ( $this as $field => $info ){
			if($info instanceof TableColumn){
				if( $def = getDefVal($field) ){ $this->$field->defValue = $def; }
				$this->$field->name = $field;
				$this->$field->table = 'student_attendance_records';
			}
		}
		parent::__construct($id);
	}




}
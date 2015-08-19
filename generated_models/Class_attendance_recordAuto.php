<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Wed 11-Mar-2015
 * Time: 07:39 PM PST
 */
class Class_attendance_recordAuto extends TableObject{
	protected static $tablename = 'class_attendance_records';
	public $id;
	public $date;
	public $class_id;
	public $total_lectures;
	static $dbColumns = array('id','date','class_id','total_lectures');

	function __construct($id = null){
		$this->id = new TableColumn( 'int', '11', true, '', 'PRI' );
		$this->date = new TableColumn( 'date', '0', true, '', '' );
		$this->class_id = new TableColumn( 'int', '11', true, '', '' );
		$this->total_lectures = new TableColumn( 'int', '11', true, '', '' );
		// get default value
		foreach ( $this as $field => $info ){
			if($info instanceof TableColumn){
				if( $def = getDefVal($field) ){ $this->$field->defValue = $def; }
				$this->$field->name = $field;
				$this->$field->table = 'class_attendance_records';
			}
		}
		parent::__construct($id);
	}




}
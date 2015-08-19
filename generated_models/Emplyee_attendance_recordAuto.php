<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Wed 11-Mar-2015
 * Time: 07:39 PM PST
 */
class Emplyee_attendance_recordAuto extends TableObject{
	protected static $tablename = 'emplyee_attendance_records';
	public $id;
	public $employee_id;
	public $date;
	public $status;
	static $dbColumns = array('id','employee_id','date','status');

	function __construct($id = null){
		$this->id = new TableColumn( 'int', '11', true, '', 'PRI' );
		$this->employee_id = new TableColumn( 'int', '11', true, '', '' );
		$this->date = new TableColumn( 'date', '0', true, '', '' );
		$this->status = new TableColumn( 'enum', '0', true, '', '', array('Present','Absent','Leave') );
		// get default value
		foreach ( $this as $field => $info ){
			if($info instanceof TableColumn){
				if( $def = getDefVal($field) ){ $this->$field->defValue = $def; }
				$this->$field->name = $field;
				$this->$field->table = 'emplyee_attendance_records';
			}
		}
		parent::__construct($id);
	}




}
<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Wed 11-Mar-2015
 * Time: 07:39 PM PST
 */
class Advance_recordAuto extends TableObject{
	protected static $tablename = 'advance_records';
	public $id;
	public $employee_id;
	public $month;
	public $year;
	public $amount;
	static $dbColumns = array('id','employee_id','month','year','amount');

	function __construct($id = null){
		$this->id = new TableColumn( 'int', '11', true, '', 'PRI' );
		$this->employee_id = new TableColumn( 'int', '11', true, '', '' );
		$this->month = new TableColumn( 'int', '2', true, '', '' );
		$this->year = new TableColumn( 'int', '4', true, '', '' );
		$this->amount = new TableColumn( 'int', '11', true, '', '' );
		// get default value
		foreach ( $this as $field => $info ){
			if($info instanceof TableColumn){
				if( $def = getDefVal($field) ){ $this->$field->defValue = $def; }
				$this->$field->name = $field;
				$this->$field->table = 'advance_records';
			}
		}
		parent::__construct($id);
	}




}
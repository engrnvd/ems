<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Wed 11-Mar-2015
 * Time: 07:39 PM PST
 */
class EmployeAuto extends TableObject{
	protected static $tablename = 'employees';
	public $id;
	public $person_id;
	public $department_id;
	public $designation_id;
	public $pay;
	public $joining_date;
	public $leaving_date;
	static $dbColumns = array('id','person_id','department_id','designation_id','pay','joining_date','leaving_date');

	function __construct($id = null){
		$this->id = new TableColumn( 'int', '11', true, '', 'PRI' );
		$this->person_id = new TableColumn( 'int', '11', true, '', '' );
		$this->department_id = new TableColumn( 'int', '11', true, '', '' );
		$this->designation_id = new TableColumn( 'int', '11', true, '', '' );
		$this->pay = new TableColumn( 'int', '11', true, '', '' );
		$this->joining_date = new TableColumn( 'date', '0', true, '', '' );
		$this->leaving_date = new TableColumn( 'date', '0', false, '', '' );
		// get default value
		foreach ( $this as $field => $info ){
			if($info instanceof TableColumn){
				if( $def = getDefVal($field) ){ $this->$field->defValue = $def; }
				$this->$field->name = $field;
				$this->$field->table = 'employees';
			}
		}
		parent::__construct($id);
	}




}
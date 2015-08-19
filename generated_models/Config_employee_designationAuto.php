<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Wed 11-Mar-2015
 * Time: 07:39 PM PST
 */
class Config_employee_designationAuto extends TableObject{
	protected static $tablename = 'config_employee_designations';
	public $id;
	public $title;
	public $department_id;
	static $dbColumns = array('id','title','department_id');

	function __construct($id = null){
		$this->id = new TableColumn( 'int', '11', true, '', 'PRI' );
		$this->title = new TableColumn( 'varchar', '30', true, '', '' );
		$this->department_id = new TableColumn( 'int', '11', true, '', '' );
		// get default value
		foreach ( $this as $field => $info ){
			if($info instanceof TableColumn){
				if( $def = getDefVal($field) ){ $this->$field->defValue = $def; }
				$this->$field->name = $field;
				$this->$field->table = 'config_employee_designations';
			}
		}
		parent::__construct($id);
	}




}
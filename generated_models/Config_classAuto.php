<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Wed 11-Mar-2015
 * Time: 07:39 PM PST
 */
class Config_classAuto extends TableObject{
	protected static $tablename = 'config_classes';
	public $id;
	public $class;
	public $degree_id;
	public $annual_dues;
	public $total_lectures_per_day;
	public $starting_month;
	public $ending_month;
	static $dbColumns = array('id','class','degree_id','annual_dues','total_lectures_per_day','starting_month','ending_month');

	function __construct($id = null){
		$this->id = new TableColumn( 'int', '11', true, '', 'PRI' );
		$this->class = new TableColumn( 'varchar', '30', true, '', '' );
		$this->degree_id = new TableColumn( 'int', '11', true, '', '' );
		$this->annual_dues = new TableColumn( 'int', '11', true, '', '' );
		$this->total_lectures_per_day = new TableColumn( 'int', '11', true, '', '' );
		$this->starting_month = new TableColumn( 'int', '2', true, '', '' );
		$this->ending_month = new TableColumn( 'int', '2', true, '', '' );
		// get default value
		foreach ( $this as $field => $info ){
			if($info instanceof TableColumn){
				if( $def = getDefVal($field) ){ $this->$field->defValue = $def; }
				$this->$field->name = $field;
				$this->$field->table = 'config_classes';
			}
		}
		parent::__construct($id);
	}




}
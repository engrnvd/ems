<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Wed 11-Mar-2015
 * Time: 07:39 PM PST
 */
class Advance_return_recordAuto extends TableObject{
	protected static $tablename = 'advance_return_records';
	public $id;
	public $advance_record_id;
	public $date;
	public $amount;
	static $dbColumns = array('id','advance_record_id','date','amount');

	function __construct($id = null){
		$this->id = new TableColumn( 'int', '11', true, '', 'PRI' );
		$this->advance_record_id = new TableColumn( 'int', '11', true, '', '' );
		$this->date = new TableColumn( 'date', '0', true, '', '' );
		$this->amount = new TableColumn( 'int', '11', true, '', '' );
		// get default value
		foreach ( $this as $field => $info ){
			if($info instanceof TableColumn){
				if( $def = getDefVal($field) ){ $this->$field->defValue = $def; }
				$this->$field->name = $field;
				$this->$field->table = 'advance_return_records';
			}
		}
		parent::__construct($id);
	}




}
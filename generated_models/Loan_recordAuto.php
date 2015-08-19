<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Wed 11-Mar-2015
 * Time: 07:39 PM PST
 */
class Loan_recordAuto extends TableObject{
	protected static $tablename = 'loan_records';
	public $id;
	public $person_id;
	public $amount;
	public $expected_return_date;
	public $to_from;
	public $comments;
	static $dbColumns = array('id','person_id','amount','expected_return_date','to_from','comments');

	function __construct($id = null){
		$this->id = new TableColumn( 'int', '11', true, '', 'PRI' );
		$this->person_id = new TableColumn( 'int', '11', true, '', '' );
		$this->amount = new TableColumn( 'int', '11', true, '', '' );
		$this->expected_return_date = new TableColumn( 'date', '0', true, '', '' );
		$this->to_from = new TableColumn( 'enum', '0', true, '', '', array('to','from') );
		$this->comments = new TableColumn( 'text', '0', false, '', '' );
		// get default value
		foreach ( $this as $field => $info ){
			if($info instanceof TableColumn){
				if( $def = getDefVal($field) ){ $this->$field->defValue = $def; }
				$this->$field->name = $field;
				$this->$field->table = 'loan_records';
			}
		}
		parent::__construct($id);
	}




}
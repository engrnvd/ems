<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Wed 11-Mar-2015
 * Time: 07:39 PM PST
 */
class Loan_return_recordAuto extends TableObject{
	protected static $tablename = 'loan_return_records';
	public $id;
	public $loan_id;
	public $return_date;
	public $return_amount;
	public $comments;
	static $dbColumns = array('id','loan_id','return_date','return_amount','comments');

	function __construct($id = null){
		$this->id = new TableColumn( 'int', '11', true, '', 'PRI' );
		$this->loan_id = new TableColumn( 'int', '11', true, '', '' );
		$this->return_date = new TableColumn( 'date', '0', true, '', '' );
		$this->return_amount = new TableColumn( 'int', '11', true, '', '' );
		$this->comments = new TableColumn( 'text', '0', false, '', '' );
		// get default value
		foreach ( $this as $field => $info ){
			if($info instanceof TableColumn){
				if( $def = getDefVal($field) ){ $this->$field->defValue = $def; }
				$this->$field->name = $field;
				$this->$field->table = 'loan_return_records';
			}
		}
		parent::__construct($id);
	}




}
<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Wed 11-Mar-2015
 * Time: 07:39 PM PST
 */
class Loan_interest_ratAuto extends TableObject{
	protected static $tablename = 'loan_interest_rates';
	public $id;
	public $loan_id;
	public $interest_rate;
	public $repayment_schedule;
	public $comments;
	static $dbColumns = array('id','loan_id','interest_rate','repayment_schedule','comments');

	function __construct($id = null){
		$this->id = new TableColumn( 'int', '11', true, '', 'PRI' );
		$this->loan_id = new TableColumn( 'int', '11', true, '', '' );
		$this->interest_rate = new TableColumn( 'int', '11', true, '', '' );
		$this->repayment_schedule = new TableColumn( 'int', '11', true, '', '' );
		$this->comments = new TableColumn( 'text', '0', false, '', '' );
		// get default value
		foreach ( $this as $field => $info ){
			if($info instanceof TableColumn){
				if( $def = getDefVal($field) ){ $this->$field->defValue = $def; }
				$this->$field->name = $field;
				$this->$field->table = 'loan_interest_rates';
			}
		}
		parent::__construct($id);
	}




}
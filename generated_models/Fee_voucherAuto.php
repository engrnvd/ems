<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Wed 11-Mar-2015
 * Time: 07:39 PM PST
 */
class Fee_voucherAuto extends TableObject{
	protected static $tablename = 'fee_vouchers';
	public $id;
	public $student_id;
	public $month;
	public $year;
	public $received_amount;
	public $issue_date;
	public $last_date;
	public $submission_date;
	public $comments;
	static $dbColumns = array('id','student_id','month','year','received_amount','issue_date','last_date','submission_date','comments');

	function __construct($id = null){
		$this->id = new TableColumn( 'int', '11', true, '', 'PRI' );
		$this->student_id = new TableColumn( 'int', '11', true, '', '' );
		$this->month = new TableColumn( 'int', '2', true, '', '' );
		$this->year = new TableColumn( 'year', '4', true, '', '' );
		$this->received_amount = new TableColumn( 'int', '11', false, '', '' );
		$this->issue_date = new TableColumn( 'date', '0', true, '', '' );
		$this->last_date = new TableColumn( 'date', '0', true, '', '' );
		$this->submission_date = new TableColumn( 'date', '0', false, '', '' );
		$this->comments = new TableColumn( 'text', '0', false, '', '' );
		// get default value
		foreach ( $this as $field => $info ){
			if($info instanceof TableColumn){
				if( $def = getDefVal($field) ){ $this->$field->defValue = $def; }
				$this->$field->name = $field;
				$this->$field->table = 'fee_vouchers';
			}
		}
		parent::__construct($id);
	}




}
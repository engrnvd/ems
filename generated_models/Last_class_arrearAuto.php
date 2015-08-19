<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Wed 11-Mar-2015
 * Time: 07:39 PM PST
 */
class Last_class_arrearAuto extends TableObject{
	protected static $tablename = 'last_class_arrears';
	public $id;
	public $student_id;
	public $fee_voucher_id;
	public $amount;
	public $received_amount;
	public $comments;
	static $dbColumns = array('id','student_id','fee_voucher_id','amount','received_amount','comments');

	function __construct($id = null){
		$this->id = new TableColumn( 'int', '11', true, '', 'PRI' );
		$this->student_id = new TableColumn( 'int', '11', true, '', '' );
		$this->fee_voucher_id = new TableColumn( 'int', '11', true, '', '' );
		$this->amount = new TableColumn( 'int', '5', true, '', '' );
		$this->received_amount = new TableColumn( 'int', '5', false, '', '' );
		$this->comments = new TableColumn( 'text', '0', false, '', '' );
		// get default value
		foreach ( $this as $field => $info ){
			if($info instanceof TableColumn){
				if( $def = getDefVal($field) ){ $this->$field->defValue = $def; }
				$this->$field->name = $field;
				$this->$field->table = 'last_class_arrears';
			}
		}
		parent::__construct($id);
	}




}
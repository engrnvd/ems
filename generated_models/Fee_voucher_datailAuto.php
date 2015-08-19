<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Wed 11-Mar-2015
 * Time: 07:39 PM PST
 */
class Fee_voucher_datailAuto extends TableObject{
	protected static $tablename = 'fee_voucher_datails';
	public $id;
	public $fee_voucher_id;
	public $fee_category_id;
	public $amount;
	public $comments;
	static $dbColumns = array('id','fee_voucher_id','fee_category_id','amount','comments');

	function __construct($id = null){
		$this->id = new TableColumn( 'int', '11', true, '', 'PRI' );
		$this->fee_voucher_id = new TableColumn( 'int', '11', true, '', '' );
		$this->fee_category_id = new TableColumn( 'int', '11', true, '', '' );
		$this->amount = new TableColumn( 'int', '11', true, '', '' );
		$this->comments = new TableColumn( 'text', '0', false, '', '' );
		// get default value
		foreach ( $this as $field => $info ){
			if($info instanceof TableColumn){
				if( $def = getDefVal($field) ){ $this->$field->defValue = $def; }
				$this->$field->name = $field;
				$this->$field->table = 'fee_voucher_datails';
			}
		}
		parent::__construct($id);
	}




}
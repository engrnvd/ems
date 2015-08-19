<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Wed 11-Mar-2015
 * Time: 07:39 PM PST
 */
class ReceiptAuto extends TableObject{
	protected static $tablename = 'receipts';
	public $id;
	public $date;
	public $category_id;
	public $amount;
	public $comments;
	static $dbColumns = array('id','date','category_id','amount','comments');

	function __construct($id = null){
		$this->id = new TableColumn( 'int', '11', true, '', 'PRI' );
		$this->date = new TableColumn( 'date', '0', true, '', '' );
		$this->category_id = new TableColumn( 'int', '11', true, '', '' );
		$this->amount = new TableColumn( 'int', '11', true, '', '' );
		$this->comments = new TableColumn( 'text', '0', false, '', '' );
		// get default value
		foreach ( $this as $field => $info ){
			if($info instanceof TableColumn){
				if( $def = getDefVal($field) ){ $this->$field->defValue = $def; }
				$this->$field->name = $field;
				$this->$field->table = 'receipts';
			}
		}
		parent::__construct($id);
	}




}
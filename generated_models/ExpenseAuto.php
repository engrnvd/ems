<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Wed 11-Mar-2015
 * Time: 07:39 PM PST
 */
class ExpenseAuto extends TableObject{
	protected static $tablename = 'expense';
	public $id;
	public $date;
	public $category_id;
	public $description;
	public $amount;
	public $bill_id;
	public $comments;
	static $dbColumns = array('id','date','category_id','description','amount','bill_id','comments');

	function __construct($id = null){
		$this->id = new TableColumn( 'int', '11', true, '', 'PRI' );
		$this->date = new TableColumn( 'date', '0', true, '', '' );
		$this->category_id = new TableColumn( 'int', '11', true, '', '' );
		$this->description = new TableColumn( 'text', '0', true, '', '' );
		$this->amount = new TableColumn( 'int', '11', true, '', '' );
		$this->bill_id = new TableColumn( 'int', '11', false, '', '' );
		$this->comments = new TableColumn( 'text', '0', false, '', '' );
		// get default value
		foreach ( $this as $field => $info ){
			if($info instanceof TableColumn){
				if( $def = getDefVal($field) ){ $this->$field->defValue = $def; }
				$this->$field->name = $field;
				$this->$field->table = 'expense';
			}
		}
		parent::__construct($id);
	}




}
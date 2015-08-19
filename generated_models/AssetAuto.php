<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Wed 11-Mar-2015
 * Time: 07:39 PM PST
 */
class AssetAuto extends TableObject{
	protected static $tablename = 'assets';
	public $id;
	public $category_id;
	public $description;
	public $purchase_date;
	public $amount;
	public $bill_id;
	public $comments;
	static $dbColumns = array('id','category_id','description','purchase_date','amount','bill_id','comments');

	function __construct($id = null){
		$this->id = new TableColumn( 'int', '11', true, '', 'PRI' );
		$this->category_id = new TableColumn( 'int', '11', true, '', '' );
		$this->description = new TableColumn( 'text', '0', true, '', '' );
		$this->purchase_date = new TableColumn( 'date', '0', true, '', '' );
		$this->amount = new TableColumn( 'int', '11', true, '', '' );
		$this->bill_id = new TableColumn( 'int', '11', false, '', '' );
		$this->comments = new TableColumn( 'text', '0', false, '', '' );
		// get default value
		foreach ( $this as $field => $info ){
			if($info instanceof TableColumn){
				if( $def = getDefVal($field) ){ $this->$field->defValue = $def; }
				$this->$field->name = $field;
				$this->$field->table = 'assets';
			}
		}
		parent::__construct($id);
	}




}
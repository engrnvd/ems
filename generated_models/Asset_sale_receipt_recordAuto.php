<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Wed 11-Mar-2015
 * Time: 07:39 PM PST
 */
class Asset_sale_receipt_recordAuto extends TableObject{
	protected static $tablename = 'asset_sale_receipt_records';
	public $id;
	public $asset_sale_record_id;
	public $date;
	public $amount;
	public $comments;
	static $dbColumns = array('id','asset_sale_record_id','date','amount','comments');

	function __construct($id = null){
		$this->id = new TableColumn( 'int', '11', true, '', 'PRI' );
		$this->asset_sale_record_id = new TableColumn( 'int', '11', true, '', '' );
		$this->date = new TableColumn( 'date', '0', true, '', '' );
		$this->amount = new TableColumn( 'int', '11', true, '', '' );
		$this->comments = new TableColumn( 'text', '0', false, '', '' );
		// get default value
		foreach ( $this as $field => $info ){
			if($info instanceof TableColumn){
				if( $def = getDefVal($field) ){ $this->$field->defValue = $def; }
				$this->$field->name = $field;
				$this->$field->table = 'asset_sale_receipt_records';
			}
		}
		parent::__construct($id);
	}




}
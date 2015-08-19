<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Wed 11-Mar-2015
 * Time: 07:39 PM PST
 */
class Asset_sale_recordAuto extends TableObject{
	protected static $tablename = 'asset_sale_records';
	public $id;
	public $date;
	public $asset_id;
	public $sold_to;
	public $amount;
	public $comments;
	static $dbColumns = array('id','date','asset_id','sold_to','amount','comments');

	function __construct($id = null){
		$this->id = new TableColumn( 'int', '11', true, '', 'PRI' );
		$this->date = new TableColumn( 'date', '0', true, '', '' );
		$this->asset_id = new TableColumn( 'int', '11', true, '', '' );
		$this->sold_to = new TableColumn( 'int', '11', false, '', '' );
		$this->amount = new TableColumn( 'int', '11', true, '', '' );
		$this->comments = new TableColumn( 'text', '0', false, '', '' );
		// get default value
		foreach ( $this as $field => $info ){
			if($info instanceof TableColumn){
				if( $def = getDefVal($field) ){ $this->$field->defValue = $def; }
				$this->$field->name = $field;
				$this->$field->table = 'asset_sale_records';
			}
		}
		parent::__construct($id);
	}




}
<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Wed 11-Mar-2015
 * Time: 07:39 PM PST
 */
class Config_asset_categoryAuto extends TableObject{
	protected static $tablename = 'config_asset_categories';
	public $id;
	public $category;
	public $depreciation;
	public $depreciation_schedule;
	static $dbColumns = array('id','category','depreciation','depreciation_schedule');

	function __construct($id = null){
		$this->id = new TableColumn( 'int', '11', true, '', 'PRI' );
		$this->category = new TableColumn( 'varchar', '40', true, '', '' );
		$this->depreciation = new TableColumn( 'int', '11', true, '', '' );
		$this->depreciation_schedule = new TableColumn( 'int', '11', true, '', '' );
		// get default value
		foreach ( $this as $field => $info ){
			if($info instanceof TableColumn){
				if( $def = getDefVal($field) ){ $this->$field->defValue = $def; }
				$this->$field->name = $field;
				$this->$field->table = 'config_asset_categories';
			}
		}
		parent::__construct($id);
	}




}
<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Wed 11-Mar-2015
 * Time: 07:39 PM PST
 */
class Config_fee_categoryAuto extends TableObject{
	protected static $tablename = 'config_fee_categories';
	public $id;
	public $category;
	static $dbColumns = array('id','category');

	function __construct($id = null){
		$this->id = new TableColumn( 'int', '11', true, '', 'PRI' );
		$this->category = new TableColumn( 'varchar', '40', true, '', '' );
		// get default value
		foreach ( $this as $field => $info ){
			if($info instanceof TableColumn){
				if( $def = getDefVal($field) ){ $this->$field->defValue = $def; }
				$this->$field->name = $field;
				$this->$field->table = 'config_fee_categories';
			}
		}
		parent::__construct($id);
	}




}
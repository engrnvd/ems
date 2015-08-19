<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Wed 11-Mar-2015
 * Time: 07:39 PM PST
 */
class Default_installmentAuto extends TableObject{
	protected static $tablename = 'default_installments';
	public $id;
	public $config_class_id;
	public $month;
	public $fee_category_id;
	public $amount;
	static $dbColumns = array('id','config_class_id','month','fee_category_id','amount');

	function __construct($id = null){
		$this->id = new TableColumn( 'int', '11', true, '', 'PRI' );
		$this->config_class_id = new TableColumn( 'int', '11', true, '', '' );
		$this->month = new TableColumn( 'int', '2', true, '', '' );
		$this->fee_category_id = new TableColumn( 'int', '11', true, '', '' );
		$this->amount = new TableColumn( 'int', '6', true, '', '' );
		// get default value
		foreach ( $this as $field => $info ){
			if($info instanceof TableColumn){
				if( $def = getDefVal($field) ){ $this->$field->defValue = $def; }
				$this->$field->name = $field;
				$this->$field->table = 'default_installments';
			}
		}
		parent::__construct($id);
	}




}
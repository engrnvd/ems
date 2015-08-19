<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Wed 11-Mar-2015
 * Time: 07:39 PM PST
 */
class Default_valuAuto extends TableObject{
	protected static $tablename = 'default_values';
	public $id;
	public $key_name;
	public $value;
	public $comments;
	static $dbColumns = array('id','key_name','value','comments');

	function __construct($id = null){
		$this->id = new TableColumn( 'int', '11', true, '', 'PRI' );
		$this->key_name = new TableColumn( 'varchar', '100', true, '', '' );
		$this->value = new TableColumn( 'text', '0', true, '', '' );
		$this->comments = new TableColumn( 'text', '0', false, '', '' );
		// get default value
		foreach ( $this as $field => $info ){
			if($info instanceof TableColumn){
				if( $def = getDefVal($field) ){ $this->$field->defValue = $def; }
				$this->$field->name = $field;
				$this->$field->table = 'default_values';
			}
		}
		parent::__construct($id);
	}




}
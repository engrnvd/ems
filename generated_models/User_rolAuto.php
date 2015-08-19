<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Wed 11-Mar-2015
 * Time: 07:39 PM PST
 */
class User_rolAuto extends TableObject{
	protected static $tablename = 'user_roles';
	public $id;
	public $role;
	static $dbColumns = array('id','role');

	function __construct($id = null){
		$this->id = new TableColumn( 'int', '11', true, '', 'PRI' );
		$this->role = new TableColumn( 'varchar', '40', true, '', '' );
		// get default value
		foreach ( $this as $field => $info ){
			if($info instanceof TableColumn){
				if( $def = getDefVal($field) ){ $this->$field->defValue = $def; }
				$this->$field->name = $field;
				$this->$field->table = 'user_roles';
			}
		}
		parent::__construct($id);
	}




}
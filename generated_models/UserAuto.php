<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Wed 11-Mar-2015
 * Time: 07:39 PM PST
 */
class UserAuto extends TableObject{
	protected static $tablename = 'users';
	public $id;
	public $username;
	public $password;
	public $person_id;
	public $role;
	static $dbColumns = array('id','username','password','person_id','role');

	function __construct($id = null){
		$this->id = new TableColumn( 'int', '11', true, '', 'PRI' );
		$this->username = new TableColumn( 'varchar', '30', true, '', '' );
		$this->password = new TableColumn( 'varchar', '40', true, '', '' );
		$this->person_id = new TableColumn( 'int', '11', true, '', '' );
		$this->role = new TableColumn( 'int', '11', true, '', '' );
		// get default value
		foreach ( $this as $field => $info ){
			if($info instanceof TableColumn){
				if( $def = getDefVal($field) ){ $this->$field->defValue = $def; }
				$this->$field->name = $field;
				$this->$field->table = 'users';
			}
		}
		parent::__construct($id);
	}




}
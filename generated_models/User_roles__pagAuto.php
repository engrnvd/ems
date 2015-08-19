<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Wed 11-Mar-2015
 * Time: 07:39 PM PST
 */
class User_roles__pagAuto extends TableObject{
	protected static $tablename = 'user_roles__pages';
	public $user_roles_id;
	public $pages_id;
	static $dbColumns = array('user_roles_id','pages_id');

	function __construct($id = null){
		$this->user_roles_id = new TableColumn( 'int', '11', true, '', '' );
		$this->pages_id = new TableColumn( 'int', '11', true, '', '' );
		// get default value
		foreach ( $this as $field => $info ){
			if($info instanceof TableColumn){
				if( $def = getDefVal($field) ){ $this->$field->defValue = $def; }
				$this->$field->name = $field;
				$this->$field->table = 'user_roles__pages';
			}
		}
		parent::__construct($id);
	}




}
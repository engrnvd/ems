<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Wed 11-Mar-2015
 * Time: 07:39 PM PST
 */
class GuardianAuto extends TableObject{
	protected static $tablename = 'guardians';
	public $id;
	public $person_id;
	public $profession;
	public $monthly_income;
	public $num_of_family_members;
	public $num_of_children;
	static $dbColumns = array('id','person_id','profession','monthly_income','num_of_family_members','num_of_children');

	function __construct($id = null){
		$this->id = new TableColumn( 'int', '11', true, '', 'PRI' );
		$this->person_id = new TableColumn( 'int', '11', true, '', '' );
		$this->profession = new TableColumn( 'varchar', '30', true, '', '' );
		$this->monthly_income = new TableColumn( 'int', '11', true, '', '' );
		$this->num_of_family_members = new TableColumn( 'int', '11', false, '', '' );
		$this->num_of_children = new TableColumn( 'int', '11', false, '', '' );
		// get default value
		foreach ( $this as $field => $info ){
			if($info instanceof TableColumn){
				if( $def = getDefVal($field) ){ $this->$field->defValue = $def; }
				$this->$field->name = $field;
				$this->$field->table = 'guardians';
			}
		}
		parent::__construct($id);
	}




}
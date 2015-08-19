<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Wed 11-Mar-2015
 * Time: 07:39 PM PST
 */
class PersonAuto extends TableObject{
	protected static $tablename = 'persons';
	public $id;
	public $first_name;
	public $last_name;
	public $dob;
	public $gender;
	public $religion;
	public $phone;
	public $cnic;
	public $city;
	public $tehsil;
	public $district;
	public $address;
	public $father_id;
	static $dbColumns = array('id','first_name','last_name','dob','gender','religion','phone','cnic','city','tehsil','district','address','father_id');

	function __construct($id = null){
		$this->id = new TableColumn( 'int', '11', true, '', 'PRI' );
		$this->first_name = new TableColumn( 'varchar', '30', true, '', 'MUL' );
		$this->last_name = new TableColumn( 'varchar', '30', true, '', '' );
		$this->dob = new TableColumn( 'date', '0', false, '', '' );
		$this->gender = new TableColumn( 'enum', '0', false, '', '', array('Male','Female') );
		$this->religion = new TableColumn( 'varchar', '30', false, '', '' );
		$this->phone = new TableColumn( 'varchar', '11', true, '', '' );
		$this->cnic = new TableColumn( 'varchar', '13', false, '', '' );
		$this->city = new TableColumn( 'varchar', '25', false, '', '' );
		$this->tehsil = new TableColumn( 'varchar', '25', false, '', '' );
		$this->district = new TableColumn( 'varchar', '25', false, '', '' );
		$this->address = new TableColumn( 'text', '0', false, '', '' );
		$this->father_id = new TableColumn( 'int', '11', false, '', '' );
		// get default value
		foreach ( $this as $field => $info ){
			if($info instanceof TableColumn){
				if( $def = getDefVal($field) ){ $this->$field->defValue = $def; }
				$this->$field->name = $field;
				$this->$field->table = 'persons';
			}
		}
		parent::__construct($id);
	}




}
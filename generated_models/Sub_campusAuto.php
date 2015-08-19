<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Wed 11-Mar-2015
 * Time: 07:39 PM PST
 */
class Sub_campusAuto extends TableObject{
	protected static $tablename = 'sub_campuses';
	public $id;
	public $campus_id;
	public $title;
	static $dbColumns = array('id','campus_id','title');

	function __construct($id = null){
		$this->id = new TableColumn( 'int', '11', true, '', 'PRI' );
		$this->campus_id = new TableColumn( 'int', '11', true, '', '' );
		$this->title = new TableColumn( 'varchar', '50', true, '', '' );
		// get default value
		foreach ( $this as $field => $info ){
			if($info instanceof TableColumn){
				if( $def = getDefVal($field) ){ $this->$field->defValue = $def; }
				$this->$field->name = $field;
				$this->$field->table = 'sub_campuses';
			}
		}
		parent::__construct($id);
	}




}
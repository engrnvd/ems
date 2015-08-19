<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Wed 11-Mar-2015
 * Time: 07:39 PM PST
 */
class Class_sectionAuto extends TableObject{
	protected static $tablename = 'class_sections';
	public $id;
	public $title;
	public $class_id;
	static $dbColumns = array('id','title','class_id');

	function __construct($id = null){
		$this->id = new TableColumn( 'int', '11', true, '', 'PRI' );
		$this->title = new TableColumn( 'varchar', '30', true, '', '' );
		$this->class_id = new TableColumn( 'int', '11', true, '', '' );
		// get default value
		foreach ( $this as $field => $info ){
			if($info instanceof TableColumn){
				if( $def = getDefVal($field) ){ $this->$field->defValue = $def; }
				$this->$field->name = $field;
				$this->$field->table = 'class_sections';
			}
		}
		parent::__construct($id);
	}




}
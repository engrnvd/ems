<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Wed 11-Mar-2015
 * Time: 07:39 PM PST
 */
class Subject_combinationAuto extends TableObject{
	protected static $tablename = 'subject_combinations';
	public $id;
	public $title;
	static $dbColumns = array('id','title');

	function __construct($id = null){
		$this->id = new TableColumn( 'int', '11', true, '', 'PRI' );
		$this->title = new TableColumn( 'varchar', '30', true, '', '' );
		// get default value
		foreach ( $this as $field => $info ){
			if($info instanceof TableColumn){
				if( $def = getDefVal($field) ){ $this->$field->defValue = $def; }
				$this->$field->name = $field;
				$this->$field->table = 'subject_combinations';
			}
		}
		parent::__construct($id);
	}




}
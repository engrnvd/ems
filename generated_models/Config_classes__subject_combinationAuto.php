<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Wed 11-Mar-2015
 * Time: 07:39 PM PST
 */
class Config_classes__subject_combinationAuto extends TableObject{
	protected static $tablename = 'config_classes__subject_combinations';
	public $id;
	public $config_classes_id;
	public $subject_combinations_id;
	static $dbColumns = array('id','config_classes_id','subject_combinations_id');

	function __construct($id = null){
		$this->id = new TableColumn( 'int', '11', true, '', 'PRI' );
		$this->config_classes_id = new TableColumn( 'int', '11', true, '', '' );
		$this->subject_combinations_id = new TableColumn( 'int', '11', true, '', '' );
		// get default value
		foreach ( $this as $field => $info ){
			if($info instanceof TableColumn){
				if( $def = getDefVal($field) ){ $this->$field->defValue = $def; }
				$this->$field->name = $field;
				$this->$field->table = 'config_classes__subject_combinations';
			}
		}
		parent::__construct($id);
	}




}
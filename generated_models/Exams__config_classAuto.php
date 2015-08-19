<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Wed 11-Mar-2015
 * Time: 07:39 PM PST
 */
class Exams__config_classAuto extends TableObject{
	protected static $tablename = 'exams__config_classes';
	public $config_classes_id;
	public $exams_id;
	static $dbColumns = array('config_classes_id','exams_id');

	function __construct($id = null){
		$this->config_classes_id = new TableColumn( 'int', '11', true, '', '' );
		$this->exams_id = new TableColumn( 'int', '11', true, '', '' );
		// get default value
		foreach ( $this as $field => $info ){
			if($info instanceof TableColumn){
				if( $def = getDefVal($field) ){ $this->$field->defValue = $def; }
				$this->$field->name = $field;
				$this->$field->table = 'exams__config_classes';
			}
		}
		parent::__construct($id);
	}




}
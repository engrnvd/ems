<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Wed 11-Mar-2015
 * Time: 07:39 PM PST
 */
class Subject_combinations__subjectAuto extends TableObject{
	protected static $tablename = 'subject_combinations__subjects';
	public $subjects_id;
	public $subject_combinations_id;
	static $dbColumns = array('subjects_id','subject_combinations_id');

	function __construct($id = null){
		$this->subjects_id = new TableColumn( 'int', '11', true, '', '' );
		$this->subject_combinations_id = new TableColumn( 'int', '11', true, '', '' );
		// get default value
		foreach ( $this as $field => $info ){
			if($info instanceof TableColumn){
				if( $def = getDefVal($field) ){ $this->$field->defValue = $def; }
				$this->$field->name = $field;
				$this->$field->table = 'subject_combinations__subjects';
			}
		}
		parent::__construct($id);
	}




}
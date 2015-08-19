<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Wed 11-Mar-2015
 * Time: 07:39 PM PST
 */
class External_examAuto extends TableObject{
	protected static $tablename = 'external_exams';
	public $id;
	public $exam_id;
	public $institute;
	static $dbColumns = array('id','exam_id','institute');

	function __construct($id = null){
		$this->id = new TableColumn( 'int', '11', true, '', 'PRI' );
		$this->exam_id = new TableColumn( 'int', '11', true, '', '' );
		$this->institute = new TableColumn( 'varchar', '30', true, '', '' );
		// get default value
		foreach ( $this as $field => $info ){
			if($info instanceof TableColumn){
				if( $def = getDefVal($field) ){ $this->$field->defValue = $def; }
				$this->$field->name = $field;
				$this->$field->table = 'external_exams';
			}
		}
		parent::__construct($id);
	}




}
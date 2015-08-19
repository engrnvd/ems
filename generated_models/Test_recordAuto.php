<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Wed 11-Mar-2015
 * Time: 07:39 PM PST
 */
class Test_recordAuto extends TableObject{
	protected static $tablename = 'test_records';
	public $id;
	public $test_id;
	public $student_id;
	public $obtained_marks;
	public $comments;
	static $dbColumns = array('id','test_id','student_id','obtained_marks','comments');

	function __construct($id = null){
		$this->id = new TableColumn( 'int', '11', true, '', 'PRI' );
		$this->test_id = new TableColumn( 'int', '11', true, '', '' );
		$this->student_id = new TableColumn( 'int', '11', true, '', '' );
		$this->obtained_marks = new TableColumn( 'varchar', '3', false, '0', '' );
		$this->comments = new TableColumn( 'text', '0', false, '', '' );
		// get default value
		foreach ( $this as $field => $info ){
			if($info instanceof TableColumn){
				if( $def = getDefVal($field) ){ $this->$field->defValue = $def; }
				$this->$field->name = $field;
				$this->$field->table = 'test_records';
			}
		}
		parent::__construct($id);
	}




}
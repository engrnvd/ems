<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Wed 11-Mar-2015
 * Time: 07:39 PM PST
 */
class TestAuto extends TableObject{
	protected static $tablename = 'tests';
	public $id;
	public $class_id;
	public $section;
	public $subject_id;
	public $syllabus;
	public $date;
	public $max_marks;
	public $min_marks;
	public $exam_id;
	static $dbColumns = array('id','class_id','section','subject_id','syllabus','date','max_marks','min_marks','exam_id');

	function __construct($id = null){
		$this->id = new TableColumn( 'int', '11', true, '', 'PRI' );
		$this->class_id = new TableColumn( 'int', '11', true, '', '' );
		$this->section = new TableColumn( 'int', '11', false, '', '' );
		$this->subject_id = new TableColumn( 'int', '11', true, '', '' );
		$this->syllabus = new TableColumn( 'varchar', '50', true, '', '' );
		$this->date = new TableColumn( 'date', '0', true, '', '' );
		$this->max_marks = new TableColumn( 'int', '11', true, '', '' );
		$this->min_marks = new TableColumn( 'int', '11', true, '', '' );
		$this->exam_id = new TableColumn( 'int', '11', true, '', '' );
		// get default value
		foreach ( $this as $field => $info ){
			if($info instanceof TableColumn){
				if( $def = getDefVal($field) ){ $this->$field->defValue = $def; }
				$this->$field->name = $field;
				$this->$field->table = 'tests';
			}
		}
		parent::__construct($id);
	}




}
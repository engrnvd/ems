<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Wed 11-Mar-2015
 * Time: 07:39 PM PST
 */
class StudentAuto extends TableObject{
	protected static $tablename = 'students';
	public $id;
	public $person_id;
	public $guardian_id;
	public $class_id;
	public $section;
	public $roll_num;
	public $subj_combination;
	public $status;
	public $annual_dues;
	public $last_class_arrears;
	public $start_date;
	public $end_date;
	public $admission_date;
	public $last_date_for_fee_submission;
	public $comments;
	static $dbColumns = array('id','person_id','guardian_id','class_id','section','roll_num','subj_combination','status','annual_dues','last_class_arrears','start_date','end_date','admission_date','last_date_for_fee_submission','comments');

	function __construct($id = null){
		$this->id = new TableColumn( 'int', '11', true, '', 'PRI' );
		$this->person_id = new TableColumn( 'int', '11', true, '', '' );
		$this->guardian_id = new TableColumn( 'int', '11', true, '', '' );
		$this->class_id = new TableColumn( 'int', '11', true, '', '' );
		$this->section = new TableColumn( 'int', '11', false, '', '' );
		$this->roll_num = new TableColumn( 'int', '11', true, '', '' );
		$this->subj_combination = new TableColumn( 'int', '11', true, '', '' );
		$this->status = new TableColumn( 'enum', '0', true, '', '', array('enrolled','expelled','left') );
		$this->annual_dues = new TableColumn( 'int', '11', true, '', '' );
		$this->last_class_arrears = new TableColumn( 'int', '11', false, '0', '' );
		$this->start_date = new TableColumn( 'date', '0', true, '', '' );
		$this->end_date = new TableColumn( 'date', '0', true, '', '' );
		$this->admission_date = new TableColumn( 'date', '0', true, '', '' );
		$this->last_date_for_fee_submission = new TableColumn( 'int', '2', true, '', '' );
		$this->comments = new TableColumn( 'text', '0', false, '', '' );
		// get default value
		foreach ( $this as $field => $info ){
			if($info instanceof TableColumn){
				if( $def = getDefVal($field) ){ $this->$field->defValue = $def; }
				$this->$field->name = $field;
				$this->$field->table = 'students';
			}
		}
		parent::__construct($id);
	}




}
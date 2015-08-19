<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Fri 09-Jan-2015
 * Time: 10:53 AM PST
 */
class StudentColumnsInfoAuto{
	public $id;
	public $person_id;
	public $guardian_id;
	public $class_id;
	public $section;
	public $roll_num;
	public $subj_combination;
	public $status;
	public $annual_dues;
	public $start_date;
	public $end_date;
	public $admission_date;
	public $last_date_for_fee_submission;
	public $comments;

	function __construct(){
		$this->id = new TableColumn( 'int', '11', true, '', 'PRI' );
		$this->person_id = new TableColumn( 'int', '11', true, '', '' );
		$this->guardian_id = new TableColumn( 'int', '11', true, '', '' );
		$this->class_id = new TableColumn( 'int', '11', true, '', '' );
		$this->section = new TableColumn( 'int', '11', false, '', '' );
		$this->roll_num = new TableColumn( 'int', '11', true, '', '' );
		$this->subj_combination = new TableColumn( 'int', '11', true, '', '' );
		$this->status = new TableColumn( 'enum', '0', true, '', '', array('enrolled','expelled','left') );
		$this->annual_dues = new TableColumn( 'int', '11', true, '', '' );
		$this->start_date = new TableColumn( 'date', '0', true, '', '' );
		$this->end_date = new TableColumn( 'date', '0', true, '', '' );
		$this->admission_date = new TableColumn( 'date', '0', true, '', '' );
		$this->last_date_for_fee_submission = new TableColumn( 'int', '2', true, '', '' );
		$this->comments = new TableColumn( 'text', '0', false, '', '' );
		// get default value
		foreach ( $this as $field => $info ){
			if( $def = getDefVal($field) ){ $this->$field->defValue = $def; }
			$this->$field->name = $field;
			$this->$field->table = 'Student';
		}
	}




}

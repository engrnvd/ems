<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Wed 11-Mar-2015
 * Time: 07:39 PM PST
 */
class ReminderAuto extends TableObject{
	protected static $tablename = 'reminders';
	public $id;
	public $text;
	public $date;
	public $user_id;
	public $status;
	public $user_id_for;
	static $dbColumns = array('id','text','date','user_id','status','user_id_for');

	function __construct($id = null){
		$this->id = new TableColumn( 'int', '11', true, '', 'PRI' );
		$this->text = new TableColumn( 'text', '0', true, '', '' );
		$this->date = new TableColumn( 'date', '0', true, '', '' );
		$this->user_id = new TableColumn( 'int', '11', true, '', '' );
		$this->status = new TableColumn( 'enum', '0', true, '', '', array('read','unread') );
		$this->user_id_for = new TableColumn( 'int', '11', true, '', '' );
		// get default value
		foreach ( $this as $field => $info ){
			if($info instanceof TableColumn){
				if( $def = getDefVal($field) ){ $this->$field->defValue = $def; }
				$this->$field->name = $field;
				$this->$field->table = 'reminders';
			}
		}
		parent::__construct($id);
	}




}
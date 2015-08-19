<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Wed 11-Mar-2015
 * Time: 07:39 PM PST
 */
class Log_messagAuto extends TableObject{
	protected static $tablename = 'log_messages';
	public $id;
	public $action;
	public $user_id;
	public $time;
	static $dbColumns = array('id','action','user_id','time');

	function __construct($id = null){
		$this->id = new TableColumn( 'int', '11', true, '', 'PRI' );
		$this->action = new TableColumn( 'text', '0', true, '', '' );
		$this->user_id = new TableColumn( 'int', '11', true, '', '' );
		$this->time = new TableColumn( 'timestamp', '0', false, 'CURRENT_TIMESTAMP', '' );
		// get default value
		foreach ( $this as $field => $info ){
			if($info instanceof TableColumn){
				if( $def = getDefVal($field) ){ $this->$field->defValue = $def; }
				$this->$field->name = $field;
				$this->$field->table = 'log_messages';
			}
		}
		parent::__construct($id);
	}




}
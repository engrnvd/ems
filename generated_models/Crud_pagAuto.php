<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Wed 11-Mar-2015
 * Time: 07:39 PM PST
 */
class Crud_pagAuto extends TableObject{
	protected static $tablename = 'crud_pages';
	public $id;
	public $page_id;
	public $table_name;
	static $dbColumns = array('id','page_id','table_name');

	function __construct($id = null){
		$this->id = new TableColumn( 'int', '11', true, '', 'PRI' );
		$this->page_id = new TableColumn( 'int', '11', true, '', '' );
		$this->table_name = new TableColumn( 'varchar', '50', true, '', 'UNI' );
		// get default value
		foreach ( $this as $field => $info ){
			if($info instanceof TableColumn){
				if( $def = getDefVal($field) ){ $this->$field->defValue = $def; }
				$this->$field->name = $field;
				$this->$field->table = 'crud_pages';
			}
		}
		parent::__construct($id);
	}




}
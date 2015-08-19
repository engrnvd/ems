<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Wed 11-Mar-2015
 * Time: 07:39 PM PST
 */
class PagAuto extends TableObject{
	protected static $tablename = 'pages';
	public $id;
	public $title;
	public $url;
	public $parent_id;
	public $position;
	public $show_in_nav;
	static $dbColumns = array('id','title','url','parent_id','position','show_in_nav');

	function __construct($id = null){
		$this->id = new TableColumn( 'int', '11', true, '', 'PRI' );
		$this->title = new TableColumn( 'varchar', '60', true, '', '' );
		$this->url = new TableColumn( 'text', '0', true, '', '' );
		$this->parent_id = new TableColumn( 'int', '11', false, '', '' );
		$this->position = new TableColumn( 'int', '11', false, '', '' );
		$this->show_in_nav = new TableColumn( 'enum', '0', true, '', '', array('Yes','No') );
		// get default value
		foreach ( $this as $field => $info ){
			if($info instanceof TableColumn){
				if( $def = getDefVal($field) ){ $this->$field->defValue = $def; }
				$this->$field->name = $field;
				$this->$field->table = 'pages';
			}
		}
		parent::__construct($id);
	}




}
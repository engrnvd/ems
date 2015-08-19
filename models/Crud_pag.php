<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Sun 18-Jan-2015
 * Time: 08:18 PM PST
 */
class Crud_pag extends Crud_pagAuto{
	static $joinedTables = array();
	static $childRefField = '';
	static $displayFields = array('page_id');

	function __construct($id = null){
		parent::__construct($id);
        $this->page_id->fkeyInfo = new FKeyInfo('Pag','id','hint');
	}




}
Crud_pag::$childClasses = array(
    	//new ChildClass('ClassName', 'restrict'),
    );
<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Sun 18-Jan-2015
 * Time: 08:18 PM PST
 */
class Sub_campus extends Sub_campusAuto{
	static $joinedTables = array();
	static $childRefField = '';
	static $displayFields = array('title');

	function __construct($id = null){
		parent::__construct($id);
        $this->campus_id->fkeyInfo = new FKeyInfo('Campus', 'id', 'select');
	}




}
<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Sun 18-Jan-2015
 * Time: 08:18 PM PST
 */
class Advance_return_record extends Advance_return_recordAuto{
	static $joinedTables = array();
	static $childRefField = '';
	static $displayFields = array('advance_record_id', 'date', 'amount');

	function __construct($id = null){
		parent::__construct($id);
        $this->advance_record_id->fkeyInfo = new FKeyInfo('Advance_record','id','hint');
	}




}
Advance_return_record::$childClasses = array(
    	//new ChildClass('ClassName', 'restrict'),
    );
<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Sun 18-Jan-2015
 * Time: 08:18 PM PST
 */
class Test_record extends Test_recordAuto{
	static $joinedTables = array();
//	static $joinedTables = array('tests' => array('test_id','id'));
	static $childRefField = '';
	static $displayFields = array('test_id','student_id');

	function __construct($id = null){
		parent::__construct($id);
        $this->student_id->fkeyInfo = new FKeyInfo('Student','id','hint');
        $this->test_id->fkeyInfo = new FKeyInfo('Test','id','hint');
	}




}
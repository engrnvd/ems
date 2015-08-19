<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Sun 18-Jan-2015
 * Time: 08:18 PM PST
 */
class External_exam extends External_examAuto{
	static $joinedTables = array();
	static $childRefField = '';
	static $displayFields = array('exam_id','institute');

	function __construct($id = null){
		parent::__construct($id);
        $this->exam_id->fkeyInfo = new FKeyInfo('Exam','id','select');
	}




}
External_exam::$childClasses = array(
    	//new ChildClass('ClassName', 'restrict'),
    );
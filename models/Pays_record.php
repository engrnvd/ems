<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Sun 18-Jan-2015
 * Time: 08:18 PM PST
 */
class Pays_record extends Pays_recordAuto{
	static $joinedTables = array();
	static $childRefField = '';
	static $displayFields = array('employee_id','month','year');

	function __construct($id = null){
		parent::__construct($id);
        $this->employee_id->fkeyInfo = new FKeyInfo('Employe','id','hint');
	}




}
Pays_record::$childClasses = array(
    	//new ChildClass('ClassName', 'restrict'),
    );
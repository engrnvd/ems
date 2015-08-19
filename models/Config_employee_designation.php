<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Sun 18-Jan-2015
 * Time: 08:18 PM PST
 */
class Config_employee_designation extends Config_employee_designationAuto{
	static $joinedTables = array();
	static $childRefField = '';
	static $displayFields = array('title');

	function __construct($id = null){
		parent::__construct($id);
        $this->department_id->fkeyInfo = new FKeyInfo('Config_employee_department','id','select');
	}




}
Config_employee_designation::$childClasses = array(
    	//new ChildClass('ClassName', 'restrict'),
    );
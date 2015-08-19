<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Sun 18-Jan-2015
 * Time: 08:18 PM PST
 */
class Reminder extends ReminderAuto{
	static $joinedTables = array();
	static $childRefField = '';
	static $displayFields = array('user_id');

	function __construct($id = null){
		parent::__construct($id);
        $this->user_id->fkeyInfo = new FKeyInfo('User','id','select');
        $this->user_id_for->fkeyInfo = new FKeyInfo('User','id','select');
    }




}
Reminder::$childClasses = array(
    	//new ChildClass('ClassName', 'restrict'),
    );
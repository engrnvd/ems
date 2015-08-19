<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Sun 18-Jan-2015
 * Time: 08:18 PM PST
 */
class Bill_payment extends Bill_paymentAuto{
	static $joinedTables = array();
	static $childRefField = '';
	static $displayFields = array('bill_id','date','amount');

	function __construct($id = null){
		parent::__construct($id);
        $this->bill_id->fkeyInfo = new FKeyInfo('Bill','id','hint');
	}




}
Bill_payment::$childClasses = array(
    	//new ChildClass('ClassName', 'restrict'),
    );
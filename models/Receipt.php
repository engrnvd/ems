<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Sun 18-Jan-2015
 * Time: 08:18 PM PST
 */
class Receipt extends ReceiptAuto{
	static $joinedTables = array();
	static $childRefField = '';
	static $displayFields = array('category_id','amount');

	function __construct($id = null){
		parent::__construct($id);
        $this->category_id->fkeyInfo = new FKeyInfo('Config_receipt_category','id','hint');
	}




}
Receipt::$childClasses = array(
    	//new ChildClass('ClassName', 'restrict'),
    );
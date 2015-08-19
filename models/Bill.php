<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Sun 18-Jan-2015
 * Time: 08:18 PM PST
 */
class Bill extends BillAuto{
	static $joinedTables = array();
	static $childRefField = 'bill_id';
	static $displayFields = array('vendor_id','date','amount');

	function __construct($id = null){
		parent::__construct($id);
        $this->vendor_id->fkeyInfo = new FKeyInfo('Vendor','id','hint');
	}


    static function childClasses(){
        return array(
            new ChildClass('Expense', 'restrict'),
            new ChildClass('Asset', 'restrict'),
            new ChildClass('Bill_payment', 'restrict'),
        );
    }


}
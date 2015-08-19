<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Sun 18-Jan-2015
 * Time: 08:18 PM PST
 */
class Fee_voucher_datail extends Fee_voucher_datailAuto{
	static $joinedTables = array();
	static $childRefField = '';
	static $displayFields = array('fee_voucher_id','fee_category_id');

	function __construct($id = null){
		parent::__construct($id);
        $this->fee_voucher_id->fkeyInfo = new FKeyInfo('Fee_voucher','id','hint');
        $this->fee_category_id->fkeyInfo = new FKeyInfo('Config_fee_category','id','select');
    }




}
Fee_voucher_datail::$childClasses = array(
    	//new ChildClass('ClassName', 'restrict'),
    );
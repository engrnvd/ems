<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Sun 18-Jan-2015
 * Time: 08:18 PM PST
 */
class Asset_sale_receipt_record extends Asset_sale_receipt_recordAuto{
	static $joinedTables = array();
	static $childRefField = '';
	static $displayFields = array('asset_sale_record_id','amount');

	function __construct($id = null){
		parent::__construct($id);
        $this->asset_sale_record_id->fkeyInfo = new FKeyInfo('Asset_sale_record','id','select');
	}




}
Asset_sale_receipt_record::$childClasses = array(
    	//new ChildClass('ClassName', 'restrict'),
    );
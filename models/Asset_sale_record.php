<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Sun 18-Jan-2015
 * Time: 08:18 PM PST
 */
class Asset_sale_record extends Asset_sale_recordAuto{
	static $joinedTables = array();
	static $childRefField = 'asset_sale_record_id';
	static $displayFields = array('asset_id','amount');

	function __construct($id = null){
		parent::__construct($id);
        $this->asset_id->fkeyInfo = new FKeyInfo('Asset','id','hint');
        $this->sold_to->fkeyInfo = new FKeyInfo('Person','id','hint');
	}


    static function childClasses(){
        return array(
            new ChildClass('Asset_sale_receipt_record', 'cascade'),
        );
    }


}
<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Sun 18-Jan-2015
 * Time: 08:18 PM PST
 */
class Asset extends AssetAuto{
	static $joinedTables = array();
	static $childRefField = 'asset_id';
	static $displayFields = array('description','category_id','amount');

	function __construct($id = null){
		parent::__construct($id);
        $this->category_id->fkeyInfo = new FKeyInfo('Config_asset_category','id','select');
        $this->bill_id->fkeyInfo = new FKeyInfo('Bill','id','hint');
	}


    static function childClasses(){
        return array(
            new ChildClass('Asset_sale_record', 'restrict'),
        );
    }


}
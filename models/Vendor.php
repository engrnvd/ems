<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Sun 18-Jan-2015
 * Time: 08:18 PM PST
 */
class Vendor extends VendorAuto{
	static $joinedTables = array();
	static $childRefField = '';
	static $displayFields = array('name');

	function __construct($id = null){
		parent::__construct($id);
	}

    static function childClasses(){
        return array(
            new ChildClass('Bill', 'restrict'),
        );
    }



}
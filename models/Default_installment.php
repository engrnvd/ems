<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Sun 18-Jan-2015
 * Time: 08:18 PM PST
 */
class Default_installment extends Default_installmentAuto{
	static $joinedTables = array();
	static $childRefField = '';
    static $displayFields = array('fee_category_id','amount','month');

	function __construct($id = null){
		parent::__construct($id);
        $this->config_class_id->fkeyInfo = new FKeyInfo('Config_Class','id','select');
        $this->fee_category_id->fkeyInfo = new FKeyInfo('Config_fee_category','id','select');
	}




}
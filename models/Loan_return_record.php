<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Sun 18-Jan-2015
 * Time: 08:18 PM PST
 */
class Loan_return_record extends Loan_return_recordAuto{
	static $joinedTables = array();
	static $childRefField = '';
	static $displayFields = array('loan_id','return_date','return_amount');

	function __construct($id = null){
		parent::__construct($id);
        $this->loan_id->fkeyInfo = new FKeyInfo('Loan_record','id','hint');
	}




}
Loan_return_record::$childClasses = array(
    	//new ChildClass('ClassName', 'restrict'),
    );
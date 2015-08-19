<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Sun 18-Jan-2015
 * Time: 08:18 PM PST
 */
class Loan_interest_rat extends Loan_interest_ratAuto{
	static $joinedTables = array();
	static $childRefField = '';
	static $displayFields = array('loan_id','interest_rate');

	function __construct($id = null){
		parent::__construct($id);
        $this->loan_id->fkeyInfo = new FKeyInfo('Loan_record','id','hint');
	}




}
Loan_interest_rat::$childClasses = array(
    	//new ChildClass('ClassName', 'restrict'),
    );
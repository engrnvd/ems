<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Sun 18-Jan-2015
 * Time: 08:18 PM PST
 */
class Loan_record extends Loan_recordAuto{
	static $joinedTables = array();
	static $childRefField = 'loan_id';
	static $displayFields = array('person_id','to_from','amount');

	function __construct($id = null){
		parent::__construct($id);
        $this->person_id->fkeyInfo = new FKeyInfo('Person','id','hint');
	}

    static function childClasses(){
        return array(
            new ChildClass('Loan_interest_rat', 'restrict'),
            new ChildClass('Loan_return_record', 'restrict'),
        );
    }



}
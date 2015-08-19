<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Sun 18-Jan-2015
 * Time: 08:18 PM PST
 */
class Expense extends ExpenseAuto{
	static $joinedTables = array();
	static $childRefField = '';
	static $displayFields = array('description','amount');

	function __construct($id = null){
		parent::__construct($id);
        $this->category_id->fkeyInfo = new FKeyInfo('Config_expense_category','id','select');
        $this->bill_id->fkeyInfo = new FKeyInfo('Bill','id','hint');
	}




}
Expense::$childClasses = array(
    	//new ChildClass('ClassName', 'restrict'),
    );
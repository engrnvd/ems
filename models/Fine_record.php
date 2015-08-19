<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Sun 18-Jan-2015
 * Time: 08:18 PM PST
 */
class Fine_record extends Fine_recordAuto{
	static $joinedTables = array();
	static $childRefField = '';
	static $displayFields = array('fee_voucher_id','amount');

	function __construct($id = null){
		parent::__construct($id);
        $this->fee_voucher_id->fkeyInfo = new FKeyInfo('Fee_voucher','id','hint');
        $this->student_id->fkeyInfo = new FKeyInfo('Student','id','hint');
	}

    static function childClasses(){
        return array(
        );
    }


}

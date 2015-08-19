<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Sun 18-Jan-2015
 * Time: 08:18 PM PST
 */
class Config_class extends Config_classAuto{
	static $joinedTables = array();
	static $childRefField = 'config_class_id';
    static $displayFields = array('class');

    function defInstallments(){
        return $this->getChildRecs('Default_installment');
    }

	function __construct($id = null){
		parent::__construct($id);
        $this->degree_id->fkeyInfo = new FKeyInfo('Degre','id','select');
	}

    static function childClasses(){
        return array(
            new ChildClass('Default_installment', 'restrict'),
        );
    }


}
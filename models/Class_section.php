<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Sun 18-Jan-2015
 * Time: 08:18 PM PST
 */
class Class_section extends Class_sectionAuto{
	static $joinedTables = array();
	static $childRefField = 'section';
	static $displayFields = array('title');

	function __construct($id = null){
		parent::__construct($id);
        $this->class_id->fkeyInfo = new FKeyInfo('Clas','id','select');
	}

    static function childClasses(){
        return array(
            new ChildClass('Student','restrict'),
            new ChildClass('Test','restrict')
        );
    }


}
<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Sun 18-Jan-2015
 * Time: 08:18 PM PST
 */
class Employe extends EmployeAuto{
	static $joinedTables = array('persons' => array('person_id', 'id'));
	static $childRefField = 'employee_id';
	static $displayFields = array('person_id','designation_id');

	function __construct($id = null){
		parent::__construct($id);
        $this->person_id->fkeyInfo = new FKeyInfo('Person','id','hint');
        $this->department_id->fkeyInfo = new FKeyInfo('Config_employee_department','id','select');
        $this->designation_id->fkeyInfo = new FKeyInfo('Config_employee_designation','id','select');
	}

    static function childClasses(){
        $attendance = new ChildClass('Emplyee_attendance_record', 'cascade');
        $attendance->showUnderRecDetail = false;
        return array(
            new ChildClass('Pays_record', 'restrict'),
            new ChildClass('Advance_record', 'restrict'),
            $attendance,
        );
    }



}
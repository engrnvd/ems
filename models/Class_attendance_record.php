<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Sun 18-Jan-2015
 * Time: 08:18 PM PST
 */
class Class_attendance_record extends Class_attendance_recordAuto{
	static $joinedTables = array();
	static $childRefField = 'class_attendance_record_id';
	static $displayFields = array('class_id','date');

	function __construct($id = null){
		parent::__construct($id);
        $this->class_id->fkeyInfo = new FKeyInfo('Clas','id','select');
	}

    static function childClasses(){
        $stdAttendence = new ChildClass('Student_attendance_record', 'cascade');
        $stdAttendence->autoInsert = true;
        $stdAttendence->fieldsWithDesc = array('student_id');
        $stdAttendence->fieldsWithInput = array('lectures_attended');
        return array(
            $stdAttendence,
        );
    }

    public function autoInsertStudent_attendance_record(){
        $class = new Clas($this->class_id);
        $students = $class->students();
        foreach ( $students as $stdnt ){
            // dont insert a test rec if it already exists:
            $condition = "class_attendance_record_id='".$this->id->val."' AND student_id='$stdnt->id->val'";
            if(!Student_attendance_record::findByCondition($condition)){
                // pr("Entering a new rec");
                // insert a new test rec
                $atRec = new Student_attendance_record();
                $atRec->class_attendance_record_id->val = $this->id->val;
                $atRec->student_id->val = $stdnt->id->val;
                $atRec->lectures_attended->val = $class->total_lectures_per_day->val;
                if(!$atRec->dbSave()){
                    // $atRec->pr();
                    // pr($atRec->getErrors());
                    return false;
                }
            }
            // pr("Outside the if");
        }
        return true;
    }


}
<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Sun 18-Jan-2015
 * Time: 08:18 PM PST
 */
class Test extends TestAuto{
	static $joinedTables = array();
	static $childRefField = 'test_id';
	static $displayFields = array('class_id','subject_id','syllabus');

	function __construct($id = null){
		parent::__construct($id);
        $this->class_id->fkeyInfo = new FKeyInfo('Clas','id','select');

        $this->section->fkeyInfo = new FKeyInfo('Class_section','id','live');
        $this->section->fkeyInfo->fieldToMatch = 'class_id';
        $this->class_id->dependantFields = array('section');

        $this->subject_id->fkeyInfo = new FKeyInfo('Subject','id','select');
        $this->exam_id->fkeyInfo = new FKeyInfo('Exam','id','select');
	}

    static function childClasses(){
        $testRecs = new ChildClass('Test_record', 'cascade');
        $testRecs->autoInsert = true;
        $testRecs->fieldsWithDesc = array('student_id');
        $testRecs->fieldsWithInput = array('obtained_marks','comments');
        return array(
            $testRecs,
        );
    }

    public function relStudents(){
        $condition = "class_id = ".$this->class_id;
        $condition .= !empty($this->section->val) ? " AND section='".$this->section."'":"";
        $condition .= " AND subj_combination IN (".join(",",$this->relSubjCombs()).")";
        $condition .= " ORDER BY roll_num";
        $students = Student::findByCondition($condition);
        return $students;
    }

    public function relSubjCombs(){
        $subject = new Subject($this->subject_id);
        return $subject->subjectCombinations();
    }

    public function autoInsertTest_record(){
        $students = $this->relStudents();
        foreach ( $students as $stdnt ){
            // dont insert a test rec if it already exists:
            $condition = "test_id='".$this->id->val."' AND student_id='$stdnt->id->val'";
            if(!Test_record::findByCondition($condition)){
                // pr("Entering a new rec");
                // insert a new test rec
                $testRec = new Test_record();
                $testRec->test_id->val = $this->id->val;
                $testRec->student_id->val = $stdnt->id->val;
                if(!$testRec->dbSave()){ return false; }
            }
            // pr("Outside the if");
        }
        return true;
    }



}
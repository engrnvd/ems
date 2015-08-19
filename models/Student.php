<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Sun 18-Jan-2015
 * Time: 08:18 PM PST
 */
class Student extends StudentAuto{
	static $joinedTables = array('persons' => array('person_id', 'id'));
	static $childRefField = '';
	static $displayFields = array('first_name','last_name','class_id');

    function last_class_arrears(){
        global $db;
        $arrears = 0;
        // if there is a vlaue set by the user, return it
        if(!empty($this->last_class_arrears->val)){
            $arrears = $this->last_class_arrears->val;
        }else{
            // else, calculate from previous records (NOT IMPLEMENTED YET)
//        $query = "select sum(amount) AS total from fee_vouchers JOIN fee_voucher_datails ON fee_vouchers.id = fee_voucher_datails.fee_voucher_id WHERE student_id = {}";
        }

        // receved amount
        $received = $db->gfv("sum(received_amount)","last_class_arrears","student_id=".$this->id->val);
        return $arrears - $received;
    }

    /**
     * @return bool
     * returns an array of id's
     * used to get the other student records of a student
     * to calculate last_class_arrears for example
     */
    function other_student_ids(){
        global $db;
        $data = $db->findBySql("select id from students JOIN classes ON students.class_id = classes.id WHERE person_id = {$this->person_id->val} AND classes.session < {$this->clas()->session->val}");
        if($data){ return $data[0]['id']; }
        return false;
    }

    /**
     * @return Clas
     */
    function clas(){ return new Clas($this->class_id->val); }

	function __construct($id = null){
		parent::__construct($id);
        $this->class_id->fkeyInfo = new FKeyInfo('Clas', 'id', 'select');
        $this->person_id->fkeyInfo = new FKeyInfo('Person', 'id', 'hint');
        $this->guardian_id->fkeyInfo = new FKeyInfo('Guardian', 'id', 'hint');
        $this->section->fkeyInfo = new FKeyInfo('Class_section','id','live');
        $this->section->fkeyInfo->fieldToMatch = 'class_id';
        $this->subj_combination->fkeyInfo = new FKeyInfo('Subject_combination','id','select');

        $this->class_id->dependantFields = array('section');
	}

    /**
     * @param $testObjects Test[]
     * @return array
     */
    function testRecords($testObjects){
        $return = array();
        if( is_array($testObjects) ){
            $return['total'] = 0;
            $return['obtained'] = 0;
            $return['percentage'] = "0";
            foreach ( $testObjects as $key => $test ){
                $test_ids[] = $test->id->val;
                if($this->hasToTakeTest($test)){
                    //pEcho("Student ".$this->title()." has to take test: ".$test->title());
                    $return['total'] += $test->max_marks->val;
                }
                //else{ pEcho("Student ".$this->title()." does NOT have to take test: ".$test->title()); }
                // $this->pr('student'); $test->pr('test');
            }
            $cond = "student_id =".$this->id->val." AND test_id in (".join(",",$test_ids).")";
            $records = Test_record::findByCondition($cond);
            $return['tests'] = array_flip($test_ids);
            if($records){
                foreach ( $records as $key => $testRec ){
                    $return['tests'][$testRec->test_id->val] = $testRec;
                    $return['obtained'] += $testRec->obtained_marks->val;
                }
            }
            if($return['total'] > 0){ $return['percentage'] = round( $return['obtained'] / $return['total'] * 100, 2 ); }
        }
        return $return;
    }

    function getAbsences($startDate,$endDate){
        global $db;
        $query = "select count(*) AS absences from student_attendance_records JOIN class_attendance_records ON class_attendance_records.id = student_attendance_records.class_attendance_record_id WHERE student_id = {$this->id->val} AND class_attendance_records.date >= '{$startDate}' AND class_attendance_records.date < '{$endDate}' AND lectures_attended = 0";
        if($res = $db->findBySql($query)){
            //prlq();
            //pr($res);
            return $res[0]['absences'];
        }
        return 0;
    }

    function getAbsencesForMonth($month,$year){
        return $this->getAbsences("$year-$month-01","$year-".($month+1)."-01");
    }

    function attendanceRecords($classAttendanceRecs){
        $return = array();
        if( is_array($classAttendanceRecs) ){
            $return['total'] = 0;
            $return['attended'] = 0;
            $return['percentage'] = 0;
            foreach ( $classAttendanceRecs as $key => $atRec ){
                $atRec_ids[] = $atRec->id->val;
                $return['total'] += $atRec->total_lectures->val;
            }
            $cond = "student_id =".$this->id->val." AND class_attendance_record_id in (".join(",",$atRec_ids).")";
            $records = Student_attendance_record::findByCondition($cond);
            $return['atRecs'] = array_flip($atRec_ids);
            if($records){
                foreach ( $records as $key => $stAtRec ){
                    $return['atRecs'][$stAtRec->class_attendance_record_id->val] = $stAtRec;
                    $return['attended'] += $stAtRec->lectures_attended->val;
                }
            }
            if($return['total'] > 0){ $return['percentage'] = round( $return['attended'] / $return['total'] * 100, 2 ); }
        }
        return $return;
    }

    /**
     * @param $students Student[]
     * @param $tests Test
     * @return array
     */
    public static function testRecordsAll($students,$tests){
        $return = array();
        $percArray = array();
        if(is_array($students) && is_array($tests) ){
            foreach ( $students as $stdnt ){
                if(!$stdnt instanceof Student){ return $return; }
                $tRecs = $stdnt->testRecords($tests);
                if($tRecs && isset($tRecs['percentage'])){
                    $return[$stdnt->id->val] = $tRecs;
                    $percArray[$stdnt->id->val] = $tRecs['percentage'];
                }else{
                    $return[$stdnt->id->val] = "";
                    $percArray[$stdnt->id->val] = 0;
                }
            }
            // sort out positions:
            arsort($percArray);
            $ids = array_keys($percArray);
            $currentPos = 1;
            $currentPerc = $percArray[$ids[0]];
            foreach ( $percArray as $id => $perc ){
                if( $perc < $currentPerc ){
                    $currentPos ++;
                    $currentPerc = $perc;
                }
                $positions[$id] = $currentPos;
                //pEcho("\$currentPerc = $currentPerc");
                //pEcho("\$currentPos = $currentPos");
                //pEcho("\$id = $id");
                //pEcho("\$perc = $perc");
                //pr($positions,'$positions');

            }
            foreach ( $return as $stId => $recs ){ $return[$stId]['position'] = $positions[$stId]; }
        }
        return $return;
    }

    function name(){
        return $this->first_name." ".$this->last_name;
    }

    /**
     * @param $test Test
     * @return bool
     */
    function hasToTakeTest($test){
        $subCombTest = in_array($this->subj_combination->val,$test->relSubjCombs());
        $classTest = ($this->class_id->val == $test->class_id->val);
        $sectionTest = !empty($test->section->val) ? $this->section->val == $test->section->val : true;
        return $subCombTest && $classTest && $sectionTest;
    }

    static function reportHeads(){
        return array(
            'id',
            'roll_num',
            'first_name',
            'last_name',
            'father_id',
            'phone',
            'class_id',
            'section',
            'subj_combination',
            'annual_dues',
            'last_class_arrears',
            'start_date',
            'end_date',
            'admission_date',
            'last_date_for_fee_submission',
            'dob',
            'gender',
            'religion',
            'cnic',
            'city',
            'tehsil',
            'district',
            'address',
            'status',
            'comments',
        );
    }

    static function visibleReportHeads(){
        return array(
            'id',
            'roll_num',
            'first_name',
            'last_name',
            'father_id',
            'phone',
            'class_id',
            'section',
            'annual_dues',
            'last_class_arrears',
            'cnic',
            'address',
            'status',
        );
    }

    static function childClasses(){
        $feeVouchers = new ChildClass('Fee_voucher', 'cascade');
        $feeVouchers->autoInsert = true;
        $feeVouchers->showAutoInsertForm = false;
        return array(
            $feeVouchers,
        );
    }

    /**
     * @return Fee_voucher[]
     */
    function autoInsertFee_voucher(){
        if( $feeVouchers = $this->getChildRecs('Fee_voucher') ){ return $feeVouchers; }
        // get default installments
        $class = new Clas($this->class_id->val);
        $defInstallments = $this->defaultInstallments();
        if(!$defInstallments){ return false; }
        $months = array(); // to make sure only one voucher is generated for each single month
        foreach ( $defInstallments as $dInsId => $defIns ){
            $m = $defIns->month->val;
            if(!in_array($m,$months)){
                //$defIns->pr();
                $feeVoucher = new Fee_voucher();
                //$feeVoucher->pr();
                $feeVoucher->student_id->val = $this->id->val;
                $y = $m >= $class->starting_month->val ? $class->session->val : ($class->session->val+1);
                $d = $this->last_date_for_fee_submission->val;
                $feeVoucher->month->val = $m;
                $feeVoucher->year->val = $y;
                $feeVoucher->last_date->val = "$y-$m-$d";
                $feeVoucher->issue_date->val = "$y-$m-01";
                if( !$feeVoucher->dbSave() ){ return false; }
                $months[] = $m;
                $feeVouchers[] = $feeVoucher;
            }
        }
        return $feeVouchers;
    }

    /**
     * @return Default_installment[]
     */
    function defaultInstallments(){
        $class = new Clas($this->class_id->val);
        return Default_installment::findByCondition("config_class_id = ".$class->config()->id->val);
    }

    function pr($lable='', $horizontal = false){ parent::pr($lable,$horizontal); }

}
<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Sun 18-Jan-2015
 * Time: 08:18 PM PST
 *
 * Arrears are calculated based upon last_date
 */
class Fee_voucher extends Fee_voucherAuto{
	static $joinedTables = array();
	static $childRefField = 'fee_voucher_id';
	static $displayFields = array('id');
    /**
     * @var CalculatedColumn
     */
    public $total_amount;
    /**
     * @var CalculatedColumn
     */
    public $cur_arrears;
    /**
     * @var CalculatedColumn
     */
    public $prev_arrears;
//    static $orderBy = "`fee_vouchers`.`year`, `fee_vouchers`.`month`"; // for ordering in sql query

    /**
     * @param $id
     */
    function __construct($id = null){
		parent::__construct($id);
        $this->student_id->fkeyInfo = new FKeyInfo('Student','id','hint');
    }

    /**
     * @return array
     */
    static function childClasses(){
        $feeVoucherDetails = new ChildClass('Fee_voucher_datail', 'cascade');
        $feeVoucherDetails->autoInsert = true;
        $feeVoucherDetails->showAutoInsertForm = false;
        return array(
            $feeVoucherDetails,
        );
    }

    public function current_amount(){
        $total = 0;
        $feeDetails = $this->details();
        if(!$feeDetails){ return $total; }
        foreach ( $feeDetails as $id => $feeDetail ){
            if($feeDetail instanceof Fee_voucher_datail){
                $total += $feeDetail->amount->val;
            }
        }
        return $total;
    }

    /**
     * @return int
     * total = admission + tuition fee + .....
     * total += last class arrears (not implemented yet)
     * total += Fine
     */
    public function grand_total(){
        $total = $this->current_amount();
        $total += $this->prev_arrears();
        $total += $this->fine();
        return $total;
    }

    /**
     * @return int
     */
    public function fine(){
        $fine = Fine_record::findOneByCondition("fee_voucher_id=".$this->id->val);
        if($fine instanceof Fine_record){ return $fine->amount->val; }
        return 0;
    }

    /**
     * @return int
     */
    public function cur_arrears(){
        $value = $this->grand_total() - $this->received_amount->val;
        return $value;
    }

    /**
     * @return int
     */
    function prev_arrears(){
        $total = 0;
        $rcvd = 0;
        $preVouchers = static::findByCondition("last_date < '{$this->last_date}' AND student_id = '{$this->student_id}'");
        if( !$preVouchers ){ return 0; }
        foreach ( $preVouchers as $id => $vouchr ){
            $total += $vouchr->current_amount()+$vouchr->fine();
            $rcvd += $vouchr->received_amount->val;
        }
        return ($total - $rcvd);
    }

    /**
     * @return Fee_voucher_datail[]
     */
    function details(){ return $this->getChildRecs('Fee_voucher_datail'); }

    /**
     * @var CalculatedColumn[]
     * array(name => after)
     */
    static $calcColumns = array(
        'current_amount' => 'year',
        'prev_arrears' => 'current_amount',
        'fine' => 'prev_arrears',
        'grand_total' => 'fine',
        'cur_arrears' => 'received_amount',
    );

    /**
     * @return bool
     */
    public function autoInsertFee_voucher_datail(){
        if( $this->getChildRecs('Fee_voucher_datail') ){ return true; }
        // get default installments
        $student = new Student($this->student_id->val);
        $class = new Clas($student->class_id->val);
        $defInstallments = Default_installment::findByCondition("config_class_id = ".$class->config()->id->val." AND month = '".$this->month->val."'");
        if(!$defInstallments){ return true; }
        foreach ( $defInstallments as $dInsId => $defIns ){
            if( $defIns instanceof Default_installment){};
            $feeVoucherDetail = new Fee_voucher_datail();
            $feeVoucherDetail->fee_voucher_id->val = $this->id->val;
            // if the student has a special discount, default installments will not apply to them:
            if( $student->annual_dues->val < $class->config()->annual_dues->val ){
                global $db;
                $feeVoucherDetail->fee_category_id->val = $db->gfv("id","config_fee_categories","category = 'Tuition Fee'");
                $feeVoucherDetail->amount->val = ( $student->annual_dues->val / (count($class->config()->defInstallments())) );
                //$feeVoucherDetail->pr("this is being inserted");
            }else{
                $feeVoucherDetail->fee_category_id->val = $defIns->fee_category_id->val;
                $feeVoucherDetail->amount->val = $defIns->amount->val;
                //$feeVoucherDetail->pr("default being inserted");
            }
            if( !$feeVoucherDetail->dbSave() ){
                //$feeVoucherDetail->pr();
            }
        }
        return true;
    }

    /**
     * @return bool
     */
    function showMarkup(){
        global $app_info, $html, $vOptions;

        // records
        $voucher = $this;
        $std = new Student($this->student_id->val);
        $vdtls = $this->getChildRecs('Fee_voucher_datail');

        // voucher copies
        $copies = explode("--",getDefVal("voucher_copies"));

        // comments
        $vchComments = !empty($voucher->comments->val)? "Note: " : "";
        $vchComments = $voucher->comments->getEditableValue();

        // prev. arrears
        $preArrears = $vOptions->applyPrevArrears? $voucher->prev_arrears() : 0;

        // fine
            //get fineRec
            $fineRec = Fine_record::findOneByCondition("fee_voucher_id=".$voucher->id->val);
            // if there isn't any, make a new one:
            if(!$fineRec){
                $fineRec = new Fine_record();
                $fineRec->student_id->val = $std->id->val;
                $fineRec->fee_voucher_id->val = $voucher->id->val;
                $fineRec->amount->val = 0;
            }
            // calculate fine
            if(isset($_POST['updateOptions'])){// calculate fine
                $absences = $std->getAbsencesForMonth($voucher->month->val,$voucher->year->val);
                $fineRec->amount->val = $absences * $vOptions->finePerAbsence;
            }
            // add fine record
            if(!$fineRec->dbSave()){ $html->echoError("Could not save fine record. Please try later."); }

        // previous class arrears
            if($vOptions->applyLastClassArrears){
                // 1. get amount
                // 2. save amount
                $preClassArrears = $std->last_class_arrears();
                if( !$lca = Last_class_arrear::findOneByCondition("fee_voucher_id=".$voucher->id->val) ){
                    $lca = new Last_class_arrear();
                    $lca->student_id->val = $std->id->val;
                    $lca->fee_voucher_id->val = $voucher->id->val;
                    $lca->amount->val = $preClassArrears;
                    if(!$lca->dbSave()){ $html->echoError("Could not save Last Class Arrear record. Please try later."); }
                }
            }

        // total
            $total = $voucher->current_amount() + $preArrears + $fineRec->amount->val;
            $total += isset($lca) ? $lca->amount->val : 0;

//        $voucher->pr();
//        $std->pr();
        if( !$copies || empty($copies) || (is_array($copies) && empty($copies[0]) )){
            global $html;
            $err = "The Configuration for voucher copies is invalid.";
            $href = "records.php?page_id=58"; // link to the default values page
            $err .= " Please go to the ".$html->link_blank("Default Values",$href)." page";
            $err .= " and make sure there is a default value for 'voucher_copies.'";
            $err .= " There may be typos";
            $html->echoError($err);
            return false;
        }
        foreach ( $copies as $copyType ){
//            echo "<div class='voucherContainer'>";
            require __DIR__."/../html_components/VoucherHorizontal.php";
//            echo "</div>";
            echo "<br>";
            echo "<br>";
        }
        return true;
    }

}
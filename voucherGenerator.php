<?php require_once 'html_components/require_comps_start.php'; ?>

<?php
// handle post requests
require_once "html_components/records_post_handler.php";

// data and variables
$classname = 'Student';
// prepare filter fields
$ffst = Student::filterFields();
$ffvchr = Fee_voucher::filterFields();
$ffs = array_merge($ffst,$ffvchr);
// fields we don't need here:
unset($ffs['gender']);
unset($ffs['status']);
// additional fields
$tempStd = new Student();
$ffs['person_id'] = new FilterField($tempStd->person_id);
$ffs['roll_num'] = new FilterField( $tempStd->roll_num);
unset($tempStd);

$filterOptions = new FilterOptions( $ffs );
$students = $filterOptions->getRecords('Student');
//$feeVouchers = $filterOptions->getRecords('Fee_voucher');
?>

<h2 class="hidden-print"><?=$currentPageTitle?> <?=$html->helpLink("http://www.dailymotion.com/video/x2ibhvg_ems-voucher-generator_school")?></h2>

<?php echo $filterOptions->markup(); ?>

<?php require_once __DIR__."/html_components/voucherGeneratorOptions.php" ?>

<?php
if( $students ){
    $count = 1;
    foreach ( $students as $student ){
        if($student instanceof Student){}
        // auto insert
        $feeVouchers = $student->autoInsertFee_voucher();
        // show error in case
        $monthDis = $filterOptions->filterFields['month']->displayVal();
        $year = $filterOptions->filterFields['year']->val;
        $stName = $student->get_a_tag($student->name());
        if( !$feeVouchers ){ $html->echoError("No vouchers are saved for {$stName} for {$monthDis} {$year}"); }
        else{
            // hidden inputs for editable fields:
            $html->echoHiddenInputs(new Fee_voucher());
            $html->echoHiddenInputs(new Fee_voucher_datail());
            $html->echoHiddenInputs(new Fine_record());
            $html->echoHiddenInputs(new Last_class_arrear());
            // find voucher
            $stId = $student->id->val;
            $month = $filterOptions->filterFields['month']->val;
            $cond = "student_id = {$stId} AND month = '{$month}' AND year = {$year}";
            if($voucher = Fee_voucher::findByCondition($cond)){
                // there should be only one voucher for one month
                if( count($voucher) > 1 ){
                    $html->echoError("More than one vouchers are saved for {$stName} for {$monthDis} {$year}");
                }
                else{
                    $voucher = array_shift($voucher);
                    $voucher->showMarkup();
                }
            }
            else $html->echoError("No vouchers are saved for {$stName} for {$monthDis} {$year}");
        }
        if( ($count % $vOptions->numCopiesPerPage) == 0 ){ $html->pageBreak(); }  // two vouchers per page
        $count ++;
    }
}else{
    echo "<p class='has-error'>No records found. Please check out the filtering options.</p>";
}
?>

<?php require_once 'html_components/require_comps_end.php'; ?>
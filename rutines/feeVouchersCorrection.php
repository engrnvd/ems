<?php
require_once "../initialize.php";

/**
 * User: Engr. Naveed
 * Date: 26-Feb-15
 * Time: 5:33 PM
 *
 * This is written because there has been a mistake regarding the students that have a fee concession:
 * autoInsertVoucher() inserted vouchers according to the defInstallments as set in the config class,
 * when it was not supposed to happen.
 * e.g. there were 12 defInstallments for class6 each of amount 3000 (bcz annual_dues / 12 = 36000 / 12 = 3000)
 * there was a student whose annual dues were 18000, his installments should have been 1500 each.
 */

// find all students
// foreach student:
// check if they have less annual_dues
// find all vouchers
// foreach voucher:
// remove all fee_voucher_details
// autoInsertFee_voucher_datail();
?>

    <a href="<?=$_SERVER['REQUEST_URI']?>?correct=true" class="dangerLink">Auto Correct Vouchers</a>

<?php
if( isset($_GET['correct']) && $_GET['correct'] == 'true' ){
    $students = Student::findAll();
    $count = 1;
    foreach ( $students as $stId => $student ){
        $class = new Clas($student->class_id->val);
        //if( $student->annual_dues->val < $class->config()->annual_dues->val ){
//            $student->pr($count); $count ++;
            $vouchers = $student->getChildRecs('Fee_voucher');
            foreach ( $vouchers as $voucher ){
                //if( $db->delete("fee_voucher_datails","fee_voucher_id=".$voucher->id->val)){ prlq(); }
                $details = $voucher->getChildRecs('Fee_voucher_datail');
                if( empty($details) ){
                    if($voucher->autoInsertFee_voucher_datail()){ pEcho("Inserted..."); }
                }
            }
        //}
    }
    $session->setMessage("Vouchers Corrected.","success");
    redirect("../index.php");
}

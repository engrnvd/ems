<?php
/**
 * User: Engr. Naveed
 * Date: 09-Feb-15
 * Time: 12:25 AM
 */

require_once __DIR__."/"."../initialize.php";

$msg = "Successfully Saved to Database.";
$msgType = 'success';

if(isset($_POST['attendance'])){
//    prpost();
    foreach ( $_POST['attendance'] as $recArray ){
        $objToSave = Emplyee_attendance_record::instantiate($recArray);
        $objToSave->pr();
        if(!$objToSave->dbSave()){
            $msg = "Could not save some records. Please check your input values. Error Code: sa-err";
            $msgType = 'danger';
            $formErrors = $objToSave->getErrors();
        }
    }
    $session->setMessage($msg,$msgType);
    reloadCurrentPage();
}
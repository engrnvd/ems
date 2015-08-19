<?php
/**
 * Created by EngrNaveed
 * Date: 12/26/2014
 * Time: 8:42 PM
 */
require_once __DIR__ . "/" . "../initialize.php";

// we require $classname and an $objToSave in order to save data
$formErrors = array();
$objToSave = null;
if ($objToSave instanceof TableObject) {
}
$classname = "";
$arrayToSave = null;
$msg = "Successfully Saved to Database.";
$msgType = 'success';

$autoInsertFormIsSubmitted = areSet(array('autoInsertForm', 'classname'), $_POST);
$recordIsBeingEdited = isAjax() && isset($_POST['recordInfo']) && isset($_POST['valueToSave']);
$newRecFormIsSubmitted = isset($_POST['submit']);
$anyFormIsSubmitted = $autoInsertFormIsSubmitted || $recordIsBeingEdited || $newRecFormIsSubmitted;

if ($recordIsBeingEdited) {
    $info = explode('-', decrypt($_POST['recordInfo']));
    //    $info: Array
    //    (
    //        [0] => persons    // table
    //        [1] => cnic       // field
    //        [2] => 13         // id
    //    )
    $classname = tbl2cls($info[0]);
    $objToSave = $classname::findById($info[2]);
    $objToSave->$info[1]->val = $_POST['valueToSave'];
} elseif ($newRecFormIsSubmitted) {
    $classname = $_POST['classname'];
    $objToSave = $classname::instantiate($_POST);
}

if ($classname && $objToSave) {
    if ($objToSave->dbSave()) {
        $_POST = array();
        if (!isAjax()) {
            reloadCurrentPage();
        }
    } else {
        $formErrors = $objToSave->getErrors();
        $msg = !empty($formErrors) ? array_shift($formErrors) . ". " : "";
        $msg .= "Invalid Input Data. Could Not Save to Database. Error Code: rph-nrf";
        $msgType = 'danger';
//         $objToSave->pr();
//         pr($formErrors);
    }
}

if ($autoInsertFormIsSubmitted) {
    $classname = $_POST['classname'];
    foreach ($_POST[$classname] as $recArray) {
        $objToSave = $classname::findById($recArray['id']);
        foreach ($recArray as $key => $value) {
            $objToSave->$key->val = $value;
        }
        if (!$objToSave->dbSave()) {
            $msg = "Could not save some records. Please check your input values. Error Code: rph-aif";
            $msgType = 'danger';
            $formErrors = $objToSave->getErrors();
        }
    }
}
if ($anyFormIsSubmitted) {
    $session->setMessage($msg, $msgType);
    if (isAjax() || !empty($formErrors)) {
        $session->outputMessage();
    }
//    else{ reloadCurrentPage();}
}

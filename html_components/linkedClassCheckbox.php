<?php
/**
 * Created by EngrNaveed.
 * Date: 08-Jan-15
 * Time: 2:39 PM
 */
require_once __DIR__ . "/" . "../initialize.php";

// we expect post data like:
//Array
//(
//    [create] => 1
//    [subjects_id] => 1
//    [subject_combinations_id] => 1
//    [tablename] => subject_combinations__subjects
//)

$succeeded = false;
if (isset($_POST['create'])) { // insert a new record
    if (isset($_POST['tablename']) && $db->save($_POST, $_POST['tablename'])) {
        $succeeded = true;
    } else {
        $succeeded = false;
    }
} else { // delete existing record
    $tables = explode("__", $_POST['tablename']);
    if (count($tables) == 2) {
        // build condition-string
        $field1 = $tables[0] . "_id";
        $field2 = $tables[1] . "_id";
        $condition = "$field1 = {$_POST[$field1]} AND $field2 = {$_POST[$field2]}";
        if ($db->delete($_POST['tablename'], $condition)) {
            $succeeded = true;
        } else {
            $succeeded = false;
        }
    } else {
        $succeeded = false;
    }
}

if ($succeeded) {
    $msg = "Database Updated.";
    $msgType = 'success';
} else {
    $msg = "Could Not Update the Database. Contact Developer.";
    $msgType = 'danger';
}
$session->setMessage($msg, $msgType);
$session->outputMessage();



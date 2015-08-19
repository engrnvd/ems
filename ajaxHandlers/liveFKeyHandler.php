<?php
/**
 * Created by EngrNaveed.
 * Date: 10-01-15
 * Time: 2:05 PM
 */
require_once "../initialize.php";
// expected data: Array(
//    [parentField] => class_id
//    [targetField] => section
//    [parentFieldValue] => 1
//    [classname] => Student
//)
if( areSet(array('parentField', 'targetField','parentFieldValue','classname'),$_POST) ){
    $fields = $_POST['classname']::getColumns();
    $fClass = $fields->$_POST['targetField']->fkeyInfo->fClass;
    $fField = $fields->$_POST['targetField']->fkeyInfo->fField;
    // find records
    $condition = $_POST['parentField']."=".$_POST['parentFieldValue'];
    $records = $fClass::findByCondition($condition);
    if($records){ // show options
        foreach ( $records as $object ){
            echo "<option value='".$object->$fField."'>".$object->title()."</option>";
        }
    }else{
        echo "<option></option>";
    }
}
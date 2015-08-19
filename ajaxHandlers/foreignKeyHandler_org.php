<?php
/**
 * Created by EngrNaveed
 * Date: 28-Dec-14
 * Time: 5:20 PM
 */
require_once "../initialize.php";
// expected input pattern:
//Array
//(
//    [classname] => Person
//    [fieldname] => id
//    [currentValue] => n
//)
//prpost();
if( areSet(array('classname','fieldname','currentValue'), $_POST) ){
    // extract variables from the info
    $classname = $_POST['classname'];
    $tableName = $_POST['classname']::tablename();
    $columnName = $_POST['fieldname'];
    $displayColumnsArr = $_POST['classname']::$displayFields;
    $displayColumns = join(",",$displayColumnsArr);
    // find data
    $condition = "MATCH ($displayColumns) AGAINST ('".$_POST['currentValue']."*' IN BOOLEAN MODE) OR $tableName.$columnName = '".$_POST['currentValue']."'";
    $data = $classname::findByCondition($condition);
//    pr($data,"received data");
//    prlq();
    echo "<div class='list-group fkeyHints'>";
    if($data && !$data[0]->isEmpty()){
        foreach($data as $object){
            $href = "recordDetail.php?classname=".$_POST['classname']."&recordId=".$object->id;
            echo "<a href='{$href}' class='list-group-item' data-value='".$object->$columnName."'>";
                echo "<h4 class='list-group-item-heading'>";
                    $heading = array();
                    foreach($displayColumnsArr as $col){
                        $heading[] = $object->$col;
                    }
                    echo join( " ", $heading );
                echo "</h4>";
                echo "<p class='list-group-item-text'>";
                    $text = array();
                    foreach($object as $key => $value){
                        $text[] = $key.": ".$value;
                    }
                    echo join(" - ", $text);
                echo "</p>";
            echo "</a>";
        }
    }else{
        echo "<div class='list-group-item autoFadeOut'>";
        echo "<h4 class='list-group-item-heading'>No Record Found</h4>";
        echo "<p class='list-group-item-text'>No record in the database matched your search. Please review your entered value or add a new record and then access it.</p>";
        echo "</div>";
    }
    echo "</div>";
}
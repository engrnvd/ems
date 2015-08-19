<?php
/**
 * Created by EngrNaveed.
 * Date: 13-01-15
 * Time: 5:48 PM
 */
require_once __DIR__."/"."../initialize.php";
$output = (Object)"";
if(isset($_POST['classId'])){
    $class = new Clas($_POST['classId']);
    $output->roll_num = ($class->maxRollNum()+1);
    $output->start_date = formatDate($class->session->val."-".$class->starting_month->val."-01", "%Y-%m-%d");
    $output->end_date = formatDate( ($class->session->val+1)."-".$class->ending_month->val."-01", "%Y-%m-%d");
    $output->annual_dues = $class->config()->annual_dues->val;
    $output->total_lectures = $class->total_lectures_per_day->val;
    $output->subjCombs = $class->subjectCombinations();
}elseif(isset($_POST['class'])){
//    $class = Config_class::findOneByCondition("class='".$_POST['class']."'");
//    foreach ( Config_class::getColumns() as $col => $colObj ){
//        $output->$col = $class->$col->val;
//    }
}
echo json_encode($output);
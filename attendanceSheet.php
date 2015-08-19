<?php require_once 'html_components/require_comps_start.php'; ?>

<?php
// handle post requests
require_once "html_components/records_post_handler.php";

// data and variables
$classname = 'Class_attendance_record';
$filterOptions = new FilterOptions( Class_attendance_record::filterFields() );
$class = new Clas( $filterOptions->filterFields['class_id']->val );
$config = !empty($filterOptions->filterFields['section']->val) ? array('condition'=>"section = '".$filterOptions->filterFields['section']->val."'") : array();
$students = $class->students($config);
$classAttendanceRecs = $filterOptions->getRecords($classname);
?>

<h2><?=$currentPageTitle?></h2>

<?php echo $filterOptions->markup(); ?>

<?php
if($classAttendanceRecs && $students ){
    // prepare heads
    $heads = array('date','total_lectures');
    $headArrays = array();
    foreach ( $classAttendanceRecs as $key => $test ){
        foreach ( $heads as $head ){ $headArrays[$head][] = $test->get_a_tag($test->$head->displayVal()); }
    }
    // make atRecs editable:
    $html->echoHiddenInputs(new Student_attendance_record());
    // show table:
    echo "<div id='tableContainer' class='table-responsive'>";
    echo "<table class='table table-striped'>";
    echo "<thead>";
    foreach ( $headArrays as $head => $headArray ){
        echo "<tr><th colspan='3'>$head</th><th>".join("</th><th>",$headArray)."</th><th colspan='4'></th></tr>";
    }
    echo "<tr><th>Sr#</th><th>Roll#</th><th>Name</th><th colspan='".count($classAttendanceRecs)."'></th><th>Total</th><th>Attended</th><th>% Attendance</th></tr>";
    echo "</thead>";
    echo "<tbody>";
    $sr = 1;
    foreach ( $students as $student ){
        echo "<tr>";
        echo "<td>".$sr."</td>";
        echo "<td>".$student->roll_num."</td>";
        echo "<td>".$student->get_a_tag($student->name())."</td>";
        $stAtRecs = $student->attendanceRecords($classAttendanceRecs);
        if($stAtRecs && isset($stAtRecs['atRecs'])){
            foreach ( $stAtRecs['atRecs'] as $test_id => $stAtRec ){
                if($stAtRec instanceof TableObject){
                    $classAttr = empty($stAtRec->lectures_attended->val)?"class='has-error'" : "";
                    echo "<td $classAttr>".$stAtRec->lectures_attended->getEditableValue()."</td>";
                }
                else{ echo "<td> - </td>"; }
            }
            echo "<td>".$stAtRecs['total']."</td>";
            echo "<td>".$stAtRecs['attended']."</td>";
            echo "<td>".$stAtRecs['percentage']." %</td>";
        }else{
            for( $i = 0; $i < (count($classAttendanceRecs)+3); $i++ ){ echo "<td> - </td>"; }
        }
        echo "</tr>";
        $sr ++;
    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
}else{
    echo "<p class='has-error'>No records found. Please check out the filtering options.</p>";
}
?>

<?php require_once 'html_components/require_comps_end.php'; ?>
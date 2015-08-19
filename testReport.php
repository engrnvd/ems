<?php require_once 'html_components/require_comps_start.php'; ?>

<?php
// handle post requests
require_once "html_components/records_post_handler.php";

// data and variables
$classname = 'Test';
$filterOptions = new FilterOptions( $classname::filterFields() );
$class = new Clas( $filterOptions->filterFields['class_id']->val );
$config = !empty($filterOptions->filterFields['section']->val) ? array('condition'=>"section = '".$filterOptions->filterFields['section']->val."'") : array();
$students = $class->students($config);
$testObjects = $filterOptions->getRecords($classname);
$testRecords = Student::testRecordsAll($students,$testObjects);
?>

<h2><?=$currentPageTitle?></h2>

<?php echo $filterOptions->markup(); ?>

<?php
if($testObjects && $students && $testRecords){
    // prepare heads
    $heads = array('subject_id','syllabus','date','max_marks');
    $headArrays = array();
    foreach ( $testObjects as $key => $test ){
        foreach ( $heads as $head ){ $headArrays[$head][] = $test->get_a_tag($test->$head->displayVal()); }
    }
    // make tests editable:
    $html->echoHiddenInputs(new Test());
    $html->echoHiddenInputs(new Test_record());
    // show table:
    echo "<div id='tableContainer' class='table-responsive'>";
    echo "<table class='table table-striped table-hover'>";
    echo "<thead>";
    foreach ( $headArrays as $head => $headArray ){
        echo "<tr><th colspan='3'>$head</th><th>".join("</th><th>",$headArray)."</th><th colspan='4'></th></tr>";
    }
    echo "<tr><th>Sr#</th><th>Roll#</th><th>Name</th><th colspan='".count($testObjects)."'></th><th>Total</th><th>Obtained</th><th>%age</th><th>Position</th></tr>";
    echo "</thead>";
    echo "<tbody>";
    foreach ( $students as $sr => $student ){
        echo "<tr>";
        echo "<td>".($sr+1)."</td>";
        echo "<td>".$student->roll_num."</td>";
        echo "<td>".$student->get_a_tag($student->name())."</td>";
        $testRecs = $testRecords[$student->id->val];
//        pr($testRecords);
        if($testRecs && isset($testRecs['tests'])){
            foreach ( $testRecs['tests'] as $test_id => $testRec ){
                if($testRec instanceof TableObject){ echo "<td>".$testRec->obtained_marks->getEditableValue()."</td>"; }
                else{ echo "<td> - </td>"; }
            }
            echo "<td>".$testRecs['total']."</td>";
            echo "<td>".$testRecs['obtained']."</td>";
            echo "<td>".$testRecs['percentage']." %</td>";
            echo "<td>".$testRecs['position']."</td>";
        }else{
            for( $i = 0; $i < (count($testObjects)+4); $i++ ){ echo "<td> - </td>"; }
        }
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
}else{
    echo "<p class='has-error'>No records found. Please check out the filtering options.</p>";
}
?>

<?php require_once 'html_components/require_comps_end.php'; ?>
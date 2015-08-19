<?php require_once 'html_components/require_comps_start.php'; ?>

<?php
// handle post requests
require_once "html_components/records_post_handler.php";

// data and variables
// prepare filter fields
$ffst = Student::filterFields();
$fftst = Test::filterFields();
$ffs = array_merge($ffst,$fftst);
// fields we don't need here:
unset($ffs['gender']);
unset($ffs['status']);
// additional fields
$tempStd = new Student();
$ffs['person_id'] = new FilterField($tempStd->person_id);
//$ffs['first_name'] = new FilterField($tempStd->first_name);
//$ffs['last_name'] = new FilterField( $tempStd->last_name);
$ffs['roll_num'] = new FilterField( $tempStd->roll_num);
unset($tempStd);

$filterOptions = new FilterOptions( $ffs );
$students = $filterOptions->getRecords('Student');
$testObjects = $filterOptions->getRecords('Test');
//pr($filterOptions);
$testRecords = Student::testRecordsAll($students,$testObjects);
?>

<?php echo $filterOptions->markup(); ?>

<?php
if($testObjects && $students && $testRecords){
    echo "<div id='stReptMainCntnr' class='row'>";
    echo "<div class='col-lg-6 col-lg-offset-3 col-sm-12'>";
    // make tests editable:
    $html->echoHiddenInputs(new Test());
    $html->echoHiddenInputs(new Test_record());
    // show table:
    foreach ( $students as $student ){
        // separator
//        echo "<hr class='hidden-print'>";
        echo "<div class='studentReportMain'>";
        $html->headerForPrint();
        // heading
        echo "<h2>{$student->name()}</h2>";
        // basic info
        $basicInfo = array(
            'Name' => $student->get_a_tag($student->name()),
            'Father Name' => $student->father_id->a_tag(),
            'Class' => $student->class_id->a_tag(),
            'Roll #' => $student->roll_num->val,
        );
        echo "<div class='stBaiscInfoContainer'>";
        echo "<div class='stBaiscInfo'>";
        foreach ( $basicInfo as $key => $value ){
            echo "<p><span class='key'>$key: </span><span class='value'>$value</span></p>";
        }
        echo "</div>";
        // photo

        echo "</div>";
        // tests
        echo "<h3>Tests Report (".$filterOptions->durationStr().")</h3>";
        echo "<div id='tableContainer' class='table-responsive'>";
        echo "<table class='table table-striped table-hover'>";
        echo "<thead>";
        echo "<tr><th>Sr#</th><th>Subject</th><th>Syllabus</th><th>Date</th><th>Total</th><th>Obtained</th><th>%age</th></tr>";
        echo "</thead>";
        echo "<tbody>";
        $testRecs = $testRecords[$student->id->val];
        if($testRecs && isset($testRecs['tests'])){
            $sr = 1;
            foreach ( $testRecs['tests'] as $test_id => $testRec ){
                if($testRec instanceof TableObject){
                    $test = $testObjects[$test_id];
                    echo "<tr>";
                    echo "<td>".$sr."</td>";
                    echo "<td>".$test->get_a_tag($test->subject_id->displayVal())."</td>";
                    echo "<td>".$test->get_a_tag($test->syllabus->displayVal())."</td>";
                    echo "<td>".$test->get_a_tag($test->date->displayVal())."</td>";
                    echo "<td>".$test->get_a_tag($test->max_marks->displayVal())."</td>";
                    echo "<td>".$testRec->obtained_marks->getEditableValue()."</td>";
                    echo "<td>".($testRec->obtained_marks->val/$test->max_marks->val*100)." %</td>";
                    echo "</tr>";
                    $sr ++;
                }
            }
            echo "<tr><th colspan='4'>Grand Total</th><th>".$testRecs['total']."</th><th>".$testRecs['obtained']."</th><th>".$testRecs['percentage']." %</th></tr>";
            echo "<tr><th colspan='4'>Overall Position in Class</th><th colspan='3'>".$testRecs['position']."</th></tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
        echo "</div>";
        // separator
//        echo "<hr class='hidden-print'>";
        // pagebreak
        $html->pageBreakWidFooter();
    }
    echo "</div>";
    echo "</div>";
}else{
    echo "<p class='has-error'>No records found. Please check out the filtering options.</p>";
}
?>

<?php require_once 'html_components/require_comps_end.php'; ?>
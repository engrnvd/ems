<?php require_once 'html_components/require_comps_start.php'; ?>

<?php
// handle post requests
require_once "html_components/saveEmployeeAttendance_handler.php";
?>
    <h2><?=$curPage->title;?></h2>
    <div class="row">
        <div class="col-sm-12 col-lg-4 col-lg-offset-4">
            <form method="post" id="attendanceDatePickForm" class="searchForm hidden-print">
                <div class="input-group">
                    <?php
                    $date = isset($_POST['date']) ? $_POST['date'] : today();
                    ?>
                    <label for="date" class="input-group-addon">Date</label>
                    <input type="date" class="form-control" id="date" name="date" value="<?=$date?>">
                <span class="input-group-btn">
                    <button class="btn btn-primary" type="submit">Load Attendance</button>
                </span>
                </div>
            </form>
        </div>
    </div>

<?php
// data and variables
$classname = 'Employe';
$atClassname = 'Emplyee_attendance_record';
$records = $classname::findAll();
$attRecs = $atClassname::findByCondition("date='{$date}'");
// assign status of attRecs to records
if($attRecs){
    foreach ( $attRecs as $key => $atRec ){
        $records[$atRec->employee_id->val]->atRec = $atRec;
    }
}
if($records){
    // show table:
    echo "<div class='row'>";
    echo "<div id='tableContainer' class='table-responsive col-lg-6 col-lg-offset-3 col-sm-12'>";
    echo "<table class='table table-striped'>";
    echo "<thead>";
    echo "<tr><th>Sr#</th><th>Employee</th><th>Status</th></tr>";
    echo "</thead>";
    echo "<tbody>";
    echo "<form method='post'>";
    $sr = 1;
    foreach ( $records as $record ){
        echo "<tr>";
        echo "<td>".$sr."</td>";
        echo "<td>".$record->get_a_tag($record->title())."</td>";
        // determine status
        if(!isset($record->atRec)){
            $atR = new Emplyee_attendance_record();
            $atR->employee_id->val = $record->id->val;
            $atR->date->val = $date;
            $record->atRec = $atR;
            unset($atR);
        }
        echo "<td>";
        foreach ( $record->atRec as $fieldName => $tblCol ){
            if( !($fieldName == 'id' && empty($tblCol->val)) ){
                $config = array();
                $config['name'] = "attendance[$sr][$fieldName]";
                $hidden = ($fieldName != 'status') ? "class='hidden'" : "";
                if($hidden){ echo "<span class='hidden'>"; }
                echo $record->atRec->$fieldName->getInputMarkup($config);
                if($hidden){ echo "</span>"; }
            }
        }
        echo "</td>";
        echo "</tr>";
        $sr ++;
    }
    // the submit button, ofcourse!
    echo "<tr>";
    echo "<td colspan='2'></td><td><input class='form-control btn btn-primary' type='submit' id='saveAttendance' name='saveAttendance' value='Save to Database'></td>";
    echo "</tr>";

    echo "</form>";
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    echo "</div>";
}else{
    echo "<p class='has-error'>No records found. Please check out the filtering options.</p>";
}
?>

<?php require_once 'html_components/require_comps_end.php'; ?>
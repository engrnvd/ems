<?php require_once 'html_components/require_comps_start.php';

// data for filter options:
$filterOptions = new FilterOptions(Student::filterFields());
$students = $filterOptions->getRecords('Student');

?>

<h2><?=$currentPageTitle?></h2>
<?php echo $filterOptions->markup(); ?>

<?php

// handle post request
if(isset($_POST['apply'])){
     //prpost();
    if(!isset($_POST['student_ids']))
    {
        $html->echoError("Please select students");
    }
    elseif(!isset($_POST['months']))
    {
        $html->echoError("Please select months");
    }
    else
    {
        foreach ( $_POST['student_ids'] as $stId ){
            $student = $students[$stId];
            $class = $student->clas();
            foreach ( $_POST['months'] as $m ){
                // check if a voucher is already present for that month
                // if not present, add a new fee voucher
                // if present, add fee detail to it
                if(!$feeVoucher = Fee_voucher::findOneByCondition("student_id={$stId} and month={$m}")){
                    $feeVoucher = new Fee_voucher();
                    $feeVoucher->student_id->val = $student->id->val;
                    $y = $m >= $class->starting_month->val ? $class->session->val : ($class->session->val+1);
                    $d = $student->last_date_for_fee_submission->val;
                    $feeVoucher->month->val = $m;
                    $feeVoucher->year->val = $y;
                    $feeVoucher->last_date->val = "$y-$m-$d";
                    $feeVoucher->issue_date->val = "$y-$m-01";
                    if( !$feeVoucher->dbSave() ){ $html->echoError("Fee Voucher not already saved. Failed to create a new one."); }
                }
                // create fee voucher detail
                $feeDetail = new Fee_voucher_datail();
                $feeDetail->fee_voucher_id->val = $feeVoucher->id->val;
                $feeDetail->fee_category_id->val = $_POST['category'];
                $feeDetail->amount->val = $_POST['amount'];
                if(!$feeDetail->dbSave()){ $html->echoError("Failed to add fee detail. Please try later."); }
            }
        }
        $session->setMessage("Fee Detail added successfully.");
        reloadCurrentPage();
    }
}

if($students){
    echo "<form method='post' class='form-horizontal'>";

    echo "<div class='form-group'>";
    echo "<label class='col-sm-2' for='category'>Choose a Fee Category</label>";
    echo "<div class='col-sm-4'><select class='form-control' id='category' name='category'>";
    echo $html->showOptionsForDbTable('category','id','config_fee_categories');
    echo "</select></div>";
    echo "</div>";

    echo "<div class='form-group'>";
    echo "<label class='col-sm-2'>Enter Amount</label>";
    echo "<div class='col-sm-4'><input class='form-control' id='amount' name='amount' required></div>";
    echo "</div>";

    echo "<div class='row'>";
    // students table
    echo "<div class='col-sm-12 col-lg-6'>";
    echo "<h3>Select Students</h3>";
    echo "<div id='tableContainer' class='table-responsive'>";
    echo "<table class='table table-striped table-hover'>";
    echo "<thead><tr>";
    echo "<th>Sr#</th><th>Roll#</th><th>Student</th><td class='selectAll' data-target-class='studentsCheck'>".icon("check")."</td>";
    echo "</tr></thead>";
    echo "<tbody>";
    $count = 1;
    foreach ( $students as $key => $std ){
        echo "<tr>";
        echo "<td>{$count}</td>"; $count ++;
        echo "<td>{$std->roll_num->val}</td>";
        echo "<td><label for='id{$key}'>{$std->name()}</label></td>";
        echo "<td><input type='checkbox' id='id{$key}' name='student_ids[]' value='{$std->id->val}' class='studentsCheck'></td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    echo "</div>";

    // months table
    echo "<div class='col-sm-12 col-lg-6'>";
    echo "<h3>Select Months</h3>";
    echo "<div id='tableContainer' class='table-responsive'>";
    echo "<table class='table table-striped table-hover'>";
    echo "<thead><tr>";
    echo "<th>Sr#</th><th>Month</th><td class='selectAll' data-target-class='monthsCheck'>".icon("check")."</td>";
    echo "</tr></thead>";
    echo "<tbody>";
    $count = 1;
    for( $m = 1; $m <= 12; $m++ ){
        $month = formatDate("2000-{$m}-01","%b");
        echo "<tr>";
        echo "<td>{$count}</td>"; $count ++;
        echo "<td>{$month}</td>";
        echo "<td><input type='checkbox' name='months[]' value='{$m}' class='monthsCheck'></td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    echo "</div>";

    echo "</div>";

    // submit
    echo "<div class='form-group'>";
    echo "<div class='col-sm-4 col-sm-offset-2'><input type='submit' class='form-control btn btn-primary' id='apply' name='apply' value='Apply'></div>";
    echo "</div>";

    // end of form
    echo "</form>";
}

?>

<?php require_once 'html_components/require_comps_end.php'; ?>

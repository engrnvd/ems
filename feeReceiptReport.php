<?php require_once 'html_components/require_comps_start.php'; ?>

<?php
$start_month = $end_month = date("n") - 1;
$start_year = $end_year = date("Y");
if(!empty($_POST)){ extract($_POST); }

$sqlStartMonth = intval($db->dbEscape($start_month));
$sqlEndMonth = intval($db->dbEscape($end_month));
$sqlStartYear = intval($db->dbEscape($start_year));
$sqlEndYear = intval($db->dbEscape($end_year));
?>

    <h2><?=$currentPageTitle?></h2>

    <div id='filterOptions' class='panel-group hidden-print'>
        <div class='panel panel-primary'>
            <div class='panel-heading'><h4 class='panel-title'><a data-toggle='collapse' data-parent='#filterOptions'
                                                                  href='#ffFormCont'>Generate Revenue Report</a></h4></div>
            <div class='panel-collapse collapse in' id='ffFormCont'>
                <div class='panel-body'>
                    <form method='post' id='filterOptionsForm' class='form-inline'>

                        <div class='form-group'><label class="col-lg-2">From: </label>
                            <div class="col-lg-5">
                            <select name="start_month" id="start_month" class='form-control'>
                                <?php echo $html->monthsOptions($start_month); ?>
                            </select>
                            </div>
                            <div class="col-lg-5">
                            <input id="start_year" name="start_year" type="number" class='form-control' value="<?=$start_year?>"/>
                            </div>
                        </div>

                        <div class='form-group'><label class="col-lg-2">To: </label>
                            <div class="col-lg-5">
                            <select name="end_month" id="end_month" class='form-control'>
                                <?php echo $html->monthsOptions($end_month); ?>
                            </select>
                            </div>
                            <div class="col-lg-5">
                            <input id="end_year" name="end_year" type="number" class='form-control' value="<?=$end_year?>"/>
                            </div>
                        </div>

                        <div class='form-group'><input class='form-control btn btn-primary' type='submit'
                                                       id='filterButton' name='filterResults' value='Generate'>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

<h3>Overall Report</h3>
<?php

$classTitleStr = "CONCAT(class, ' ', session, ' (',title,')') class_";
$whereClause = " WHERE month between {$sqlStartMonth} and {$sqlEndMonth} and year between {$sqlStartYear} and {$sqlEndYear}";
$feeVouchersTable = "SELECT DISTINCT fee_vouchers.*, (SELECT sum(amount) FROM fee_voucher_datails WHERE fee_voucher_id = fee_vouchers.id) total FROM fee_vouchers ".$whereClause;
//$db->showTable($feeVouchersTable);
$sqlFirstPart = "SELECT classes.id as classId,
                ".$classTitleStr.",
                (SELECT COUNT(*) FROM students where class_id = classId) 'Total Students',
                sum(total) 'Total Amount Issued',
                sum(received_amount) 'Total Amount Received'
                FROM ({$feeVouchersTable}) fv";
$sqlFirstPart .= " LEFT JOIN students ON students.id = fv.student_id";
$sqlFirstPart .= " LEFT JOIN classes ON classes.id = students.class_id";
$sqlFirstPart .= " LEFT JOIN campuses ON campuses.id = classes.campus_id";
$sqlFirstPart .= $whereClause;
$sql = $sqlFirstPart;
$sql .= " Group By class_";
$sql .= " UNION ";
$sqlLastPart = str_replace( $classTitleStr , "'Total'", $sqlFirstPart);
$sqlLastPart = str_replace( " where class_id = classId" , "", $sqlLastPart);
$sqlLastPart = str_replace( "classes.id as classId" , "'-'", $sqlLastPart);
$sql .= $sqlLastPart;

$db->showTable($sql);

?>
    <h3>Details</h3>
<?php

$sqlFirstPart = "SELECT fee_voucher_datails.fee_category_id 'Category ID',
                category AS 'Fee Category',
                sum(amount) 'Total Amount Issued'
                /*sum(received_amount) 'Total Received'*/
                FROM fee_voucher_datails";
$sqlFirstPart .= " JOIN fee_vouchers ON fee_vouchers.id = fee_voucher_datails.fee_voucher_id";
$sqlFirstPart .= " JOIN config_fee_categories ON config_fee_categories.id = fee_voucher_datails.fee_category_id";
$sqlFirstPart .= $whereClause;
$sql = $sqlFirstPart;
$sql .= " Group By category";
$sql .= " UNION ";
$sqlLastPart = str_replace( "category AS 'Fee Category'" , "'Total'", $sqlFirstPart);
$sqlLastPart = str_replace( "fee_voucher_datails.fee_category_id 'Category ID'" , "'-'", $sqlLastPart);
$sql .= $sqlLastPart;

$db->showTable($sql);
//ChromePhp::log($db->lastQuery);
?>

<script>
    $(function () {
        // make the total row bold
        $(".table tr:last-child").css("font-weight","bold");

        // auto change the end month and year
        $("#start_month").change(function () {
            $("#end_month").val($(this).val());
        });
        $("#start_year").change(function () {
            $("#end_year").val($(this).val());
        });
    });
</script>

<?php require_once 'html_components/require_comps_end.php'; ?>
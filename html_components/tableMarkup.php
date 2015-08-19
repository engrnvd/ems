<?php
/**
 * Created by EngrNaveed
 * Date: 30-Jan-15
 *
 * this page contains html table markup for a specific class
 * Required variables:
 *  - $classname
 *  - $records
 *  - $columns
 */
require_once __DIR__ . "/" . "../initialize.php";

// $classname may be provided by ajax
if (isset($_POST['classname'])) {
    $classname = $_POST['classname'];
}
$columns = $classname::getColumnsC();
//pr($classname::getColumnsC());
?>

<?php
$tableHead = '<table class="table table-striped table-hover"><thead><tr><th>Sr.#</th>';
foreach ($columns as $column) {
    $tableHead .= '<th>' . uc_words($column) . '</th>';
}
$tableHead .= '<th class="hidden-print"></th></tr></thead><tbody>';
$tableEnd = '</tbody></table>';

if ($classname != "Fee_voucher") {
    echo $tableHead;
} // we have a different display for vouchers

?>

<?php
if ($records) {
    // records rows
    $count = 1;
    foreach ($records as $record) {
        $html->echoHiddenInputs($record);
        $html->echoHiddenInputs(new Fee_voucher_datail());

        if ($classname == "Fee_voucher") {
            echo $tableHead;
        } // we have a different display for vouchers

        echo "<tr>";
        echo "<td>$count</td>";
        foreach ($columns as $field) {
            $val = $record->$field instanceof TableColumn ? $record->$field->getEditableValue() : $record->$field->val();
            echo "<td>" . $val . "</td>";
        }
        // delete link
        $href = appendToCurrentUri(array('delete' => 'true', 'record_to_del' => $record->id->val, 'del_class' => $classname));
        $delete_link = "<a href='" . $href . "' class='danger_link' data-recId='" . encrypt($record->id->table . "-" . $record->id->val) . "'>" . icon("remove") . "</a>";
        // open link
        $href = "recordDetail.php?classname=" . tbl2cls($record->id->table) . "&recordId=" . $record->id->val;
        $openLink = "<a href='" . $href . "' target='blank'>" . icon("folder-open") . "</a>";

        // we have a different display for vouchers
        $addNewLink = "";
        if ($classname == "Fee_voucher") {
            $addNewLink = "&nbsp;&nbsp;&nbsp;&nbsp;
                <a href='#' class='newFeeRecModelLauncher' data-voucher-id='" . $record->id->val . "'>" . icon("plus") . "</a>";
        }

        echo "<td class='hidden-print'>$openLink&nbsp;&nbsp;&nbsp;&nbsp;{$delete_link}{$addNewLink}</td>";
        echo "</tr>";
        $count++;

        // special treatment for Fee Vouchers
        if ($record instanceof Fee_voucher) {
            $details = $record->details();
            if ($details) {
                echo "<tr><td colspan='16'>";
                echo "<table width='70%' class='child-table'>";
                echo "<thead>";
                echo "<tr><th>Fee Category</th><th>Amount</th><th>Comments</th><th></th></tr>";
                echo "</thead>";
                foreach ($details as $key => $feeDetail) {
                    // delete link
                    $href = appendToCurrentUri(array('delete' => 'true', 'record_to_del' => $feeDetail->id->val, 'del_class' => 'Fee_voucher_datail'));
                    $delete_link = "<a href='" . $href . "' class='danger_link' data-recId='" . encrypt($feeDetail->id->table . "-" . $feeDetail->id->val) . "'>" . icon("remove") . "</a>";
                    echo "
                    <tr>
                        <td>{$feeDetail->fee_category_id->getEditableValue()}</td>
                        <td>{$feeDetail->amount->getEditableValue()}</td>
                        <td>{$feeDetail->comments->getEditableValue()}</td>
                        <td class='hidden-print'>$delete_link</td>
                    </tr>";
                }
                echo "</table>";
                echo "</td></tr>";
            }
        }
        // special treatment for Fee Vouchers end
        if ($classname == "Fee_voucher") {
            echo $tableEnd;
        } // we have a different display for vouchers
    }
}

if ($classname != "Fee_voucher") {
    echo $tableEnd;
} // we have a different display for vouchers
if ($classname == "Fee_voucher") {
    ?>
    <div class="modal fade" id="newFeeRecModel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Add a New Fee Detail</h4>
                </div>
                <div class="modal-body">

                    <?php

                    $feeDetailObj = new Fee_voucher_datail();
                    echo $feeDetailObj->getFormMarkup();

                    ?>

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <script>
        $(function () {
//        var newRecModal = $("#newFeeRecModel");
//        var voucherId = 21456;
//        console.log(newRecModal.find("#amonut"));
//        newRecModal.find("#amonut").css('background','red');
//        newRecModal.find("#fee_voucher_id").val( voucherId );
//        newRecModal.modal('show');
//        return false;

            $(".newFeeRecModelLauncher").click(function () {
                var voucherId = $(this).data("voucher-id");
                var newRecModal = $("#newFeeRecModel");
                newRecModal.find("#fee_voucher_id").val(voucherId).parents(".form-group").hide();
                newRecModal.modal('show');
                return false;
            });
        });
    </script>

<?php } ?>
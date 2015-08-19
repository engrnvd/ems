<?php
/**
 * User: Engr. Naveed
 * Date: 2/4/2015
 * Time: 8:12 PM
 *
 * required vars:
 * - $visibleHeads
 * - $records
 */

if ($records) {
    echo "<div id='tableContainer' class='table-responsive'>";
    echo "<table class='table table-striped table-hover'>";
    echo "<thead><tr>";
    echo "<th>Sr#</th><th>" . join("</th><th>", $visibleHeads) . "</th>";
    echo "<th></th>";
    echo "</tr></thead>";
    echo "<tbody>";
    $count = 1;
    foreach ($records as $record) {
        echo "<tr>";
        echo "<td>{$count}</td>";
        $count++;
        foreach ($visibleHeads as $header) {
            if (isset($_GET['classname']) && $_GET['classname'] == "Log_messag") { // Log should not be editable
                $val = $record->$header->displayVal();
            } else {
                $val = $record->$header->getEditableValue();
            }
            echo "<td>{$val}</td>";
        }
        // open link
        $href = "recordDetail.php?classname=" . tbl2cls($record->id->table) . "&recordId=" . $record->id->val;
        $openLink = "<a href='{$href}' target='_blank'>" . icon("folder-open") . "</a>";
        echo "<td class='hidden-print'>$openLink</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    // hidden IPs
    $html->echoHiddenInputs($record);
} else {
    echo "<p class='has-error'>No records found. Please check out the filtering options.</p>";
}

<?php
// required vars:
// $headsToDisplay
?>
<div id='headsToDisplayCntnr' class='panel-group hidden-print'>
    <div class='panel panel-primary'>
        <div class='panel-heading'>
            <h4 class='panel-title'><a data-toggle='collapse' data-parent='#headsToDisplayCntnr' href='#htdFormCont'>Choose
                    Heads To Display</a></h4>
        </div>
        <div class='panel-collapse collapse' id='htdFormCont'>
            <div class='panel-body'>
                <form id="headsToDisplayForm" class="form-inline" method="post">
                    <?php
                    foreach ($headsToDisplay as $headName) {
                        $checked = in_array($headName, $visibleHeads) ? "checked" : "";
                        echo "<div class='form-group $checked'>";
                        echo "<label for='heads[" . $headName . "]'>" . uc_words($headName) . ": </label>";
                        echo "<input type='checkbox' $checked name='heads[" . $headName . "]' id='heads[" . $headName . "]'>";
                        echo "</div>";
                    }
                    echo "<div class='form-group'>";
                    echo "<input class='form-control btn btn-primary' type='submit' id='headsButton' name='headsButton' value='Update'>";
                    echo "</div>";
                    ?>
                </form>
            </div>
        </div>
    </div>
</div>
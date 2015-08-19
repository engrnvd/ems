<?php
/**
 * User: Engr. Naveed
 * Date: 2/6/2015
 * Time: 3:41 PM
 *
 * Req. vars:
 * - $classname:
 * - $record:
 */
?>
<div class='row'>
    <div class="col-sm-4">
        <table class="table table-striped">
            <?php
            foreach ($classname::reportHeads() as $fieldname) {
                $field = $record->$fieldname;
                $valToDisplay = $field->getEditableValue();
                echo "<tr><td>" . uc_words($fieldname) . "</td><td>" . $valToDisplay . "</td></tr>";
            }
            ?>
        </table>
    </div>
    <?php
    if ($record instanceof Person || $record instanceof Guardian || $record instanceof Student || $record instanceof Employe) {
        echo "<div class='col-sm-4 col-sm-offset-1'>";
        echo $record->photoMarkup();
        echo "</div>";
    }

    ?>
</div>

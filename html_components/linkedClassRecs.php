<?php if ($linkedClasses): ?>
    <div class='row'>
        <div class="col-sm-12">
            <?php
            foreach ($linkedClasses as $linkedClassName) {
                $lClassRecs = $linkedClassName::findAll();
                $linkedRecs = $record->getLinkedRecs($linkedClassName);
                if ($lClassRecs) {
                    $lClassFields = $linkedClassName::getColumns();
                    //table start
                    echo "<h3>Associated " . plural(uc_words($linkedClassName)) . "</h3>";
                    echo "<table class='table table-striped table-hover'>";
                    // heads
                    echo "<thead><tr>";
                    foreach ($lClassFields as $fieldname => $fieldInfo) {
                        echo "<th>$fieldname</th>";
                    }
                    echo "<th></th></tr></thead>";
                    //body
                    echo "<tbody>";
                    foreach ($lClassRecs as $name => $obj) {
                        echo "<tr><td>";
                        echo join("</td><td>", $obj->todbArray());
                        // checkbox
                        $checked = in_array($obj->id, $linkedRecs) ? "checked" : "";
                        $name = $linkedClassName::tablename() . "_id";
                        $recField = $classname::tablename() . "_id";
                        $tablename = $classname::tablename() . "__" . $linkedClassName::tablename();
                        echo "</td><td><form class='linkedClassForm'><label>toggle: <input class='linkedClassCheckbox' type='checkbox' name='create' value='1' $checked></label>";
                        echo "<input type='hidden' name='$name' value='{$obj->id}'>";
                        echo "<input type='hidden' name='$recField' value='{$record->id}'>";
                        echo "<input type='hidden' name='tablename' value='{$tablename}'>";
                        echo "</form></td>";
                        echo "</tr>";
                    }
                    echo "</tbody></table>";
                }
            }
            ?>
        </div>
    </div>
<?php endif; ?>
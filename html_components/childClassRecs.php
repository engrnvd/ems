<?php
if ($record instanceof TableObject) {
}

if ($childClasses) {
    echo "<div class='row'>";
    echo "<div class='col-sm-12'>";
    foreach ($childClasses as $chClass) {
        if ($chClass instanceof ChildClass) {
        }
        if ($chClass->showUnderRecDetail) {
            $chClassName = $chClass->name;
            if ($chClass->autoInsert) {
                $methodName = "autoInsert" . $chClassName;
                call_user_func(array($record, $methodName));
            }
            echo "<h3>" . uc_words(plural($chClassName)) . " under this " . $classname::classTitle() . "</h3>";

            // special treatment for vouchers
            $amountEntered = 0;
            if ($classname == "Student" && $chClassName == "Fee_voucher") {
                $sql = "SELECT SUM(amount) AS amount FROM fee_voucher_datails
                        JOIN fee_vouchers ON fee_voucher_datails.fee_voucher_id = fee_vouchers.id
                        WHERE fee_vouchers.student_id=" . $record->id->val;
                if ($amount = $db->findBySql($sql)) {
                    $amountEntered = $amount[0]['amount'];
                }
                $annualDues = $record->annual_dues->val;
                $difference = $annualDues - $amountEntered;

                $mistake = $amountEntered != $annualDues;
                $classAttr = $mistake ? "class='has-error'" : "";
                $icon = $mistake ? "" : icon("ok-circle");
                echo "<div $classAttr>";
                if ($mistake) {
                    echo "<h3>There Might Be Some Mistake!</h3>";
                }
                echo "<h4>Annual Dues Specified: " . $annualDues;
                echo "<h4>Total Amount of Vouchers: " . $amountEntered . " " . $icon;
                if ($mistake) {
                    echo "<h4>Net Difference: $difference</h4>";
                }
                echo "</div>";
            }

            $html->echoNewRecForm($chClassName);
            $chRecs = $record->getChildRecs($chClassName);
            if (!$chClass->autoInsert || !$chClass->showAutoInsertForm) {
                if ($chRecs) {
                    $html->echoTable($chClassName, $chRecs);
                } else {
                    echo "<p class='has-error'>No records found in the database.</p>";
                }
            } elseif ($chClass->autoInsert && $chRecs) {
                echo "<div id='tableContainer' class='table-responsive'>";
                echo "<form class='form-horizontal' role='form' method='POST' id='" . $chClassName::tablename() . "AutoInsertForm'>";
                echo "<table class='table table-striped'>";
                echo "<thead>";
                echo "<tr>";
                foreach ($chClass->fieldsWithDesc as $fwd) {
                    echo "<th>$fwd</th>";
                }
                foreach ($chClass->fieldsWithInput as $fwi) {
                    echo "<th>$fwi</th>";
                }
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                echo "<input type='hidden' id='classname' name='classname' value='" . $chClassName . "'>";
                foreach ($chRecs as $recIndex => $chRec) {
                    echo "<tr>";
                    // show hidden input for the record
                    echo "<input id='id' name='" . $chClassName . "[$recIndex][id]' type='hidden' value='{$chRec->id->val}'>";
                    foreach ($chClass->fieldsWithDesc as $fwd) {
                        echo "<td>{$chRec->$fwd->displayVal()}</td>";
                    }
                    foreach ($chClass->fieldsWithInput as $fwi) {
                        $field = $chRec->$fwi;
                        $config = array(
                            'name' => $chClassName . "[$recIndex][" . $field->name . "]",
                        );
                        echo "<td>{$field->getInputMarkup($config)}</td>";
                    }
                    echo "</tr>";
                }
                echo "<tr>";
                echo "<td><input class='form-control btn btn-primary' type='submit' id='autoInsertForm' name='autoInsertForm' value='Save to Database'></td>";
                echo "</tr>";
                echo "</tbody>";
                echo "</table>";
                echo "</form>";
                echo "</div>";
            } else {
                echo "<p class='has-error'>No records found in the database.</p>";
            }
        }
    }
    echo "</div>";
    echo "</div>";
}

?>
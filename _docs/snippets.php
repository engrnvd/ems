<?php
/**
 * Created by PhpStorm.
 * User: Engr. Naveed
 * Date: 14-Mar-15
 * Time: 5:21 PM
 */

// form groups
echo "<div class='form-group'>";
echo "<label class='col-sm-2'>Choose a Fee Category</label>";
echo "<div class='col-sm-5'><input class='form-control' id='fee_category_id' name='fee_category_id' ></div>";
echo "</div>";

?>
<form method='post' class='form-horizontal'>
    <div class='form-group'>
        <label class='col-sm-2' for='category'>Choose a Fee Category</label>
        <div class='col-sm-4'>
            <select class='form-control' id='category' name='category'>
                <option value='1'>Tuition Fee</option>
                <option value='2'>Admission Fee</option>
                <option value='3'>Lab Fee</option>
            </select>
        </div>
    </div>

    <div class='form-group'>
        <label class='col-sm-2'>Enter Amount</label>
        <div class='col-sm-4'><input class='form-control' id='amount' name='amount' required></div>
    </div>
    <div class='form-group'>
        <div class='col-sm-4 col-sm-offset-2'><input type='submit' class='form-control btn btn-primary' id='apply'
                                                     name='apply' value='Apply'></div>
    </div>
</form>

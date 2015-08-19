<?php

/**
 * Created by PhpStorm.
 * User: Engr. Naveed
 * Date: 26-Feb-15
 * Time: 8:17 PM
 */
class VoucherOptions
{
    public $numCopiesPerPage = 2;
    public $applyPrevArrears = 1;
    public $applyLastClassArrears = 1;
    public $finePerAbsence;
    public $note = "";

    function __construct()
    {
        // handle post request
        global $curPage;
        if (isset($_POST['updateOptions'])) {
            //prpost();
            $curPage->saveConfig('voucherOptions', $_POST);
        }
        if ($vOps = $curPage->getConfig("voucherOptions")) {
            foreach ($vOps as $key => $value) {
                if (property_exists(get_called_class(), $key)) {
                    $this->$key = $value;
                }
            }
        }
    }

}

$vOptions = new VoucherOptions();
//var_dump($vOptions);
?>
<div id='vOptCntnr' class='panel-group hidden-print'>
    <div class='panel panel-primary'>
        <div class='panel-heading'>
            <h4 class='panel-title'><a data-toggle='collapse' data-parent='#vOptCntnr' href='#vOptFormCntnr'>Voucher
                    Options (applied to every voucher)</a></h4>
        </div>
        <div class='panel-collapse collapse' id='vOptFormCntnr'>
            <div class='panel-body'>

                <form class="form-horizontal" role="form" method="post">
                    <div class="form-group">
                        <label for="numCopiesPerPage" class="col-sm-4 control-label">No. of Vouchers Per Page</label>

                        <div class="col-sm-8 col-md-4">
                            <input type="number" class="form-control" id="numCopiesPerPage" name="numCopiesPerPage"
                                   value="<?= $vOptions->numCopiesPerPage ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="note" class="col-sm-4 control-label">Note to be Displayed</label>

                        <div class="col-sm-8 col-md-4">
                            <textarea name="note" id="note" class="form-control"
                                      placeholder="Whatever you enter here, will appear in every voucher."><?= $vOptions->note ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="applyPrevArrears" class="control-label col-sm-4">Apply Last Month Arrears</label>

                        <div class="col-sm-8 col-md-4">
                            <select name="applyPrevArrears" id="applyPrevArrears" class="form-control">
                                <?= $html->showBoolOptions($vOptions->applyPrevArrears) ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="finePerAbsence" class="control-label col-sm-4">Apply Fine to Absent Students</label>

                        <div class="col-sm-8 col-md-4">
                            <input type="number" class="form-control" id="finePerAbsence" name="finePerAbsence"
                                   value='<?= $vOptions->finePerAbsence ?>' placeholder="Rupees per absence">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="applyLastClassArrears" class="control-label col-sm-4">Apply Last Class
                            Arrears</label>

                        <div class="col-sm-8 col-md-4">
                            <select name="applyLastClassArrears" id="applyLastClassArrears" class="form-control">
                                <?= $html->showBoolOptions($vOptions->applyLastClassArrears) ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8 col-md-4">
                            <button type="submit" name="updateOptions" class="btn btn-primary form-control">Update
                                Vouchers
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<?php
/**
 * Created by PhpStorm.
 * User: EngrNaveed
 * Date: 29-Dec-14
 * Time: 12:02 PM
 *
 * this page delivers different content for ajax request
 */
require_once __DIR__ . "/" . "../initialize.php";

// $classname may be provided by ajax
if (isset($_POST['classname'])) {
    $classname = $_POST['classname'];
}

// get form markup
$formMarkup = $classname::getFormMarkup();
$formHeading = icon('plus') . " Add a New " . $classname::classTitle();
$in = isFormSubmitted() ? "in" : "";
?>
<?php // ************** show 'add record' link ?>
<?php if (!isAjax()): ?>
<div class="panel-group hidden-print" id="accordion<?= $classname ?>"><?php endif; ?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="panel-title">
                <?php if (!isAjax()): ?><a id='new_record_link<?= $classname ?>' data-toggle="collapse"
                                           data-parent="#accordion<?= $classname ?>"
                                           href="#newRecordForm<?= $classname ?>"><?php endif; ?>
                    <?php echo $formHeading; ?>
                    <?php if (!isAjax()): ?></a><?php endif; ?>
            </h4>
        </div>
        <?php if (!isAjax()): ?>
        <div id="newRecordForm<?= $classname ?>" class="panel-collapse collapse <?= $in ?>"><?php endif; ?>
            <div class="panel-body row">
                <?php if (!isAjax()): ?>
                <div class="col-sm-8"><?php endif; ?>
                    <?php echo $formMarkup; ?>
                    <?php if (!isAjax()): ?></div><?php endif; ?>
            </div>
            <?php if (!isAjax()): ?></div><?php endif; ?>
    </div>
</div>

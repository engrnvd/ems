<?php require_once 'html_components/require_comps_start.php'; ?>
<?php
// handle post requests
require_once "html_components/records_post_handler.php";

// handle link class toggle requests
//require_once "html_components/linkedClassCheckbox.php";

// Go further only if:
// 1. We have a classname and a record id
// 2. class really exists
if( !isset($_GET['classname']) && !isset($_GET['recordId']) || !class_exists($_GET['classname']))
{ show404(); }

// 1. get data
$classname = $_GET['classname'];
$record = $classname::findById($_GET['recordId']);
if( !$record ){ show404(); }
$fields = $classname::getColumns();
$linkedClasses = $classname::linkedClasses();
$childClasses = $classname::childClasses();
// handle delete requests
require_once "html_components/records_delete_handler.php";

?>

<h2><?=uc_words($classname).": ".$record->title();?></h2>

<?php $html->echoHiddenInputs($record); ?>

<?php require_once 'html_components/recordBasicInfo.php'; ?>

<?php require_once 'html_components/linkedClassRecs.php'; ?>

<?php require_once 'html_components/childClassRecs.php'; ?>

<?php require_once 'html_components/require_comps_end.php'; ?>
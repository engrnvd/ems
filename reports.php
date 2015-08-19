<?php require_once 'html_components/require_comps_start.php'; ?>

<?php
// handle post requests
require_once "html_components/records_post_handler.php";

// handle clear log requests
require_once "html_components/clearLogHandler.php";

// must require a classname
if(!isset($_GET['classname'])){ show404(); }

// handle heads selection Request
if(isset($_POST['heads'])){
    foreach ( $_POST['heads'] as $key => $value ){ $heads[] = $key; }
    $curPage->saveConfig('heads',$heads);
}

// data and variables
$classname = $_GET['classname'];
// data for filter options:
$filterOptions = new FilterOptions($classname::filterFields());
//pr($filterOptions);
// data for headsToDisplayMarkup.php
$headsToDisplay = $classname::reportHeads();
// data for list_reportMarkup.php
$curPage->saveConfig('pagination',true);
$records = $filterOptions->getRecords($classname);
$visibleHeads = $curPage->getConfig('heads'); if(empty($visibleHeads)){ $visibleHeads = $classname::visibleReportHeads(); }

?>

<h2><?=$currentPageTitle?></h2>

<?php if($classname == "Log_messag") { echo "<p><a href='".$_SERVER['REQUEST_URI']."&clearLog=true' class='danger_link'>Clear Log</a></p>"; } ?>

<?php echo $filterOptions->markup(); ?>

<?php if($classname != "Log_messag") { require_once 'html_components/headsToDisplayMarkup.php'; } ?>

<?php require_once 'html_components/list_reportMarkup.php'; ?>

<?php require_once "html_components/paginationMarkup.php"; ?>

<?php require_once 'html_components/require_comps_end.php'; ?>
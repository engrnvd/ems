<?php require_once 'html_components/require_comps_start.php'; ?>
<?php
// handle post requests
require_once "html_components/records_post_handler.php";

// No need to go further if page_id is not provided
if( !isset($_GET['page_id']) ){ show404(); }

// 1. get crud_page
$crud_page = getCrudPage($_GET['page_id']);
if( !$crud_page ){ show404(); }
$classname = tbl2cls($crud_page['table_name']);
if($classname instanceof TableObject){}
// find data
$curPage->saveConfig('pagination',true);
if(isset($_POST['q']) && !empty($_POST['q'])){ $records = $classname::findByString($_POST['q']); }
else{ $records = $classname::findAll(); }
//prlq();
//pr($records);

// handle delete requests
require_once "html_components/records_delete_handler.php";

?>

<div class="row">
    <div class="col-sm-9"><h2><?=$crud_page['title'];?></h2></div>
    <div class="col-sm-3">
        <form method="post" id="searchForm" role="search" class="searchForm hidden-print">
            <div class="input-group">
                <?php
                $searchStr = isset($_POST['q']) ? $_POST['q'] : "";
                ?>
                <input type="search" class="form-control" id="q" name="q" value="<?=$searchStr?>" autofocus ">
                <span class="input-group-btn">
                    <button class="btn btn-primary" type="submit"><?=icon('search')?></button>
                </span>
            </div>
        </form>
    </div>
</div>


<?php require_once "html_components/newRecForm.php"; ?>

    <div id='tableContainer' class='table-responsive'>
        <?php require_once "html_components/tableMarkup.php"; ?>
    </div>

<?php require_once "html_components/paginationMarkup.php"; ?>

<?php require_once 'html_components/require_comps_end.php'; ?>
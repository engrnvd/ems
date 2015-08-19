<?php require_once 'html_components/require_comps_start.php'; ?>
<?php

if( !isset($_GET['page_id'])){ show404(); }
$crud_page = getCrudPage($_GET['page_id']);
if( !$crud_page ){ show404(); }
 pr($crud_page);
// default values
	$recordTitle = singularize($crud_page['title'], 0, -1); // e.g. Employee, Pay Record etc
	$url = $crud_page['url']."?page_id=".$_GET['page_id'];
	// $url = isset( $_SERVER['HTTP_REFERER'] )? $_SERVER['HTTP_REFERER'] : $crud_page['url']."?page_id=".$crud_page['id'];

// check deleting:
if( isset($_GET['record_id']) && isset($_GET['delete']) && $_GET['delete'] == 'true' ){
	$logmsg = $recordTitle." Deleted: Record Id = ".$_GET['record_id'];
	deleteRecord( $crud_page['table_name'], "id=".$_GET['record_id'], $logmsg, $url );
}

// handle posted data
if ( isset( $_POST['submit'] ) ){
	// prpost();
	validatefft($crud_page['table_name']);
	if( $form->isValid() ){
		$condition = isset( $_GET['record_id'] ) ? "id=".$_GET['record_id'] : NULL;
		$logmsg = isset( $_GET['record_id'] ) ? $recordTitle." Edited: ".$recordTitle." ID: ".$_POST['id'] : "New ".$recordTitle." Saved";
		saveFormData(  $crud_page['table_name'], $_POST, $condition, $logmsg, $url );
	}
}

?>

		<h2><?php echo $recordTitle; ?> Form</h2>
		
		<?php $record_id = isset($_GET['record_id']) ? $_GET['record_id'] : null;
		showfft( $crud_page , $record_id ); ?>

<?php require_once 'html_components/require_comps_end.php'; ?>


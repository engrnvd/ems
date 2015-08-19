<?php require_once 'html_components/require_comps_start.php'; ?>
<?php

// get all crud page groups
$crud_groups = $db->findAll('crud_page_groups');

// get all crud pages
$crud_pages = $db->findBySql("SELECT * FROM crud_pages LEFT JOIN crud_page_groups ON crud_pages.group_id = crud_page_groups.id");
pr($crud_pages);

// show navigation

?>

<?php require_once 'html_components/require_comps_end.php'; ?>

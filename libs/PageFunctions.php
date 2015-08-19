<?php


function path($file){
//        pr($_SERVER['DOCUMENT_ROOT']."/".$file);
    return strtolower($_SERVER['DOCUMENT_ROOT'])."/nvdFramework/".$file;
}
function getPages(){
    // not used anywhere
    $data = scandir('.');
    $pages = find_in_array( $data, "\.php" );
    return $pages;
}
function show404(){
    global $session;
    $session->setMessage("404: Page not found. Invalid URL." , 'danger');
    redirect('index.php');
}
function getCrudPage($page_id){
    global $db;
    $sql = "SELECT * FROM crud_pages JOIN pages ON crud_pages.page_id = pages.id WHERE pages.id = ".$page_id;
    $crud_page = $db->findBySql($sql);
    if($crud_page){ return $crud_page[0]; }
    return false;
}
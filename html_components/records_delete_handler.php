<?php
/**
 * Created by EngrNaveed.
 * Date: 04-Jan-15
 * Time: 5:07 PM
 */
require_once __DIR__ . "/" . "../initialize.php";

// we need: $tablename, record_id and a delete request
if (areSet(array('del_class', 'record_to_del', 'delete'), $_GET) && $_GET['delete'] == 'true') {
//    pr($classname);
    $response = $_GET['del_class']::dbDelete($_GET['record_to_del']);
    if ($response->succeeded) {
        $msgType = 'info';
    } else {
        $msgType = 'danger';
    }
    $session->setMessage($response->detail, $msgType);
    $uri = preg_replace("/&delete=true.*/", "", $_SERVER['REQUEST_URI']);
    redirect($uri);
}

<?php
/**
 * Created by EngrNaveed.
 * Date: 04-Jan-15
 * Time: 5:07 PM
 */
require_once __DIR__ . "/" . "../initialize.php";

if (areSet(array('clearLog', 'classname'), $_GET) && $_GET['clearLog'] == 'true') {
    if (Log_messag::clearLog()) {
        $msg = "Log Cleared";
        $msgType = 'info';
    } else {
        $msg = "Could not clear log. Please try again later";
        $msgType = 'danger';
    }
    $session->setMessage($msg, $msgType);
    $uri = preg_replace("/&clearLog=true.*/", "", $_SERVER['REQUEST_URI']);
    redirect($uri);
}

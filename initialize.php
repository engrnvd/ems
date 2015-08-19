<?php
// $includeFolders:
// All the files in these $includeFolders are automatically included in all php files
$includeFolders = array('config','libs','generated_models','models');
//$includeFolders = array('config','libs','generated_models');
foreach( $includeFolders as $folder ){
    foreach (glob(__DIR__."/".$folder."/*.php") as $filename){ require_once $filename; }
}

// start output buffering
ob_start();

// get user
$user = User::getUser();

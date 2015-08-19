<?php
require_once 'initialize.php';
// ************************************************************
//create connection
$ses_db = new MySQLDatabase('ses');
// find data

    // find students
    $ses_students = $ses_db->findAll('tblstudents');

// close connection
$ses_db->closeConnection();
// ***********************************************************

$db = new MySQLDatabase();

// insert students
//pr($ses_students[0],'total stds: ('.count($ses_students).')');
foreach( $ses_students as $ses_std ){
//    if($db->create($ses_std, 'pages') ){
//        echo "<p>Created</p>";
//    }
}

pr(getDefVal('city'));




?>

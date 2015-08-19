<?php
require_once 'initialize.php';

// update test
$arrayToSave = array(
    'id' => '1',
    'username' => 'naveed',
    'password' => sha1('naveed'),
    'firstName' => 'Naveed',
    'lastName' => 'ul Hassan'
);
//$db->save($arrayToSave,'users');

// insert test
$arrayToSave = array(
    'username' => 'naveed2',
    'password' => sha1('naveed'),
    'firstName' => 'Naveed',
    'lastName' => 'ul Hassan'
);
//$db->save($arrayToSave,'users');

//delete test
//$db->deleteById('5','users');

// showTable() test
//$db->showTable("DESCRIBE persons");
//$fieldData = $db->getTableColumns('persons');
//pr($fieldData);

// checking exec. times for queries
//smet();
//$tables = $db->getTablesList();
//foreach ( $tables as $key => $value ){
//    $db->query("SELECT * FROM ".$value);
//}
//shet();

// dml command
echo $db->isDMLCommand("insert into sometable WHERE 1")." - 1<br>";
echo $db->isDMLCommand("Select * from sometable WHERE 1")." - 2<br>";
echo $db->isDMLCommand("delete * from sometable WHERE 1")." - 3<br>";
echo $db->isDMLCommand("update sometable WHERE 1")." - 4<br>";





?>

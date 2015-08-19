<?php  require_once 'nvd/initialize.php';


// Encryption **************************************************************************************
//$text = '_pages-url-13';
//
//$encryptedString = encrypt($text);
//pr($encryptedString);
//
//$decStr = decrypt($encryptedString);
//pr($decStr);

//************************************************************************************
//$_SESSION['data']='some data';
//pr($_SESSION);

//*************************************************************************************
//$sql = "Select * from _pages left join _crud_pages on _pages.id = _crud_pages.id";
$sql = "Select *, (id+position)*2 as CalcColumn from _pages";
$mysqlResource = $db->query($sql);
$db->getHtmlTable($sql);

// mysql_fetch_field *****************************************************************
//$numfields = mysql_num_fields($mysqlResource);
//for ($i = 0; $i<$numfields; $i += 1) {
//    $field = mysql_fetch_field($mysqlResource, $i);
//    pr($field);
//}

// mysql_info ************************************************************************
//$db->query("update _pages set title='Home page' where id=1");
//pr(mysql_info(),'mysql_info');
// Output:
//mysql_info:
//Rows matched: 1  Changed: 1  Warnings: 0

// mysql_num_rows *******************************************************************
//pr(mysql_num_rows($mysqlResource) , 'mysql_num_rows');
//pr(mysql_num_fields($mysqlResource) , 'mysql_num_fields');


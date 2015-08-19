<?php require_once '../initialize.php';

$str = "Hello";
$test = "lo";
echo substr_compare($str,$test,-strlen($test),strlen($test)) === 0;



//stfs("SHOW TABLE STATUS LIKE 'assets'");
// stfs("DESC assets");
// stfs("SHOW CREATE TABLE assets");

// ******* explode()*****
// pr( explode(",", "naveed") );
// pr( implode(" ", array("naveed","Engr")) );

// ********************password reset****************************8
// $pass = sha1('naveed');
// $sql = "update users set password='".$pass."' where username='naveed'";
// if(mysql_query($sql)){
// 	echo "<h4>:) Reset!!!!</h4>";
// }else{
// 	echo "<h4>:(</h4>";
// }

// ************fetching primary key****************
// $result = findBySql("SHOW columns from staccount");
//$result = findBySql("SHOW KEYS FROM _pages WHERE Key_name = 'PRIMARY'");
// pr($result);


//$time1 = mktime(23,23,0,4,3,2013);
//$time2 = time();
//$secs = $time2 - $time1;
//1 year, 9 months, 1 day, 14 hours, 17 minutes and 10 seconds
//pr($secs);
//April 3, 2013 23:23




//pr(getDefVal('date'));
//pr(getDefVal('religion'));

//echo number_to_words(14675);

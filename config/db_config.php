<?php 
// Database constants
if($_SERVER['HTTP_HOST'] == "localhost"){
    define('DB_SERVER', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'sesedu_ems');
}else{
    define('DB_SERVER', 'localhost');
    define('DB_USER', 'sesedu');
    define('DB_PASS', 'scholars@2013');
    define('DB_NAME', 'sesedu_ems');
}



?>
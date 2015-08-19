<?php
require_once "initialize.php";
/**
 * Created by EngrNaveed.
 * Date: 01-Jan-15
 * Time: 5:20 PM
 */

// data
$tablesList = $db->getTablesList('ems');
foreach ( $tablesList as $tablename ){
    $className = tbl2cls($tablename);

// create file
    $file = new File("models/$className.php");
    $contents = $file->getContent();
    // refField
    $pattern = '/static \$childClasses \= array\(\);/';
    $replacement = "static \$childRefField = '';";
    $contents = preg_replace($pattern,$replacement,$contents);
    // child classes
    $contents .= "\n$className::\$childClasses = array(
    \t//new ChildClass('ClassName', 'restrict'),
    );";

    echo nl2br( $contents."<hr>" );
    $file->setContent($contents);
}


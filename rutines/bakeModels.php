<?php
require_once "../initialize.php";
/**
 * Created by EngrNaveed.
 * Date: 01-Jan-15
 * Time: 5:20 PM
 */

// data
$tablesList = $db->getTablesList('ems');
foreach ( $tablesList as $tablename ){
    $fields = $db->getTableColumns($tablename);
    $className = tbl2cls($tablename);

//starting comments
    $contents = docStart();
    $contents .= "class {$className} extends {$className}Auto{\n";
    $contents .= "\tstatic \$joinedTables = array();\n";
    $contents .= "\tstatic \$childClasses = array();\n";
    $contents .= "\tstatic \$displayFields = array();\n";

// __construct
    $contents .= "\n\tfunction __construct(\$id = null){\n";
    $contents .= "\t\tparent::__construct(\$id);\n";
    $contents .= "\t}\n"; // contructor end
    $contents .= "\n\n\n\n}"; // class end

// create file
    $file = new File("models/$className.php");
//    $file->setContent($contents);
}

// show in the browser
echo nl2br( $file->getContent() );



function docStart(){
    $output = "<?php\n/**\n * Created by Naveed-ul-Hassan Malik\n * Auto-Generated Using Script On:\n * Date: ".strftime("%a %d-%b-%Y", time()+5*3600)."\n * Time: ".strftime("%I:%M %p PST", time()+5*3600)."\n */\n";
    return $output;
}
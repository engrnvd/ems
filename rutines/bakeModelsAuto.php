<?php
require_once "../initialize.php";
/**
 * Created by EngrNaveed.
 * Date: 01-Jan-15
 * Time: 5:20 PM
 */

// data
$tablesList = $db->getTablesList('ems');
pr($tablesList);
foreach ( $tablesList as $tablename ){
    $fields = $db->getTableColumns($tablename);
    $className = tbl2cls($tablename)."Auto";
    echo $className." -<br>";

//starting comments
    $contents = "<?php\n/**\n * Created by Naveed-ul-Hassan Malik\n * Auto-Generated Using Script On:\n * Date: ".strftime("%a %d-%b-%Y", time()+5*3600)."\n * Time: ".strftime("%I:%M %p PST", time()+5*3600)."\n */\n";
    $contents .= "class $className extends TableObject{\n";
    $contents .= "\tprotected static \$tablename = '".$tablename."';\n";
// fields declaration
    foreach ( $fields as $key => $value ){
        $contents .= "\tpublic $".$value->name.";\n";
    }

    $contents .= "\tstatic \$dbColumns = array('";
    $fieldList = $db->getTableFieldsList($tablename);
    $contents .= join("','", $fieldList);
    $contents .= "');\n";
// __construct
    $contents .= "\n\tfunction __construct(\$id = null){\n";
    foreach ( $fields as $key => $field ){
        $contents .= "\t\t\$this->".$field->name." = new TableColumn( '";
        $contents .= $field->type;
        $contents .= "', '";
        $contents .= $field->max_length;
        $contents .= "', ";
        $contents .= $field->required? "true" : "false";
        $contents .= ", '";
        $contents .= $field->defValue;
        $contents .= "', '";
        $contents .= $field->key;
        $contents .= "'";
        if($field->type == 'enum'){
            $contents .= ", array('";
            $contents .= join("','", $field->enumValues );
            $contents .= "')";
        }
        $contents .= " );\n";
    }
    $contents .= "\t\t// get default value\n";
    $contents .= "\t\tforeach ( \$this as \$field => \$info ){\n";
    $contents .= "\t\t\tif(\$info instanceof TableColumn){\n";
    $contents .= "\t\t\t\tif( \$def = getDefVal(\$field) ){ \$this->\$field->defValue = \$def; }\n";
    $contents .= "\t\t\t\t\$this->\$field->name = \$field;\n";
    $contents .= "\t\t\t\t\$this->\$field->table = '".$tablename."';\n";
    $contents .= "\t\t\t}\n"; // foreach end
    $contents .= "\t\t}\n"; // foreach end
    $contents .= "\t\tparent::__construct(\$id);\n";
    $contents .= "\t}\n"; // contructor end
    $contents .= "\n\n\n\n}"; // class end

// create file
    $file = new File("../generated_models/$className.php");
    $file->setContent($contents);
}

// show in the browser
echo nl2br( $contents );



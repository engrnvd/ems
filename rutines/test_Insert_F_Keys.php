<html>
<head>
    <title></title>
    <style>
        label{
            display: block;
            float: left;
            padding: 4px;
            border: 1px solid #eee;
            border-radius: 5px;
            margin: 4px;
            background-color: #bce8f1;
        }
        input{
            background-color: #953b39;
            border: 1px solid #c9302c;
        }
    </style>
</head>

<body>

<?php
/**
 * Created by PhpStorm.
 * User: EngrNaveed
 * Date: 31-Dec-14
 * Time: 7:57 PM
 */
require_once 'initialize.php';

if( isset( $_POST['saveData'] ) ){
    $arrTosave = $_SESSION['fkey'];
    $arrTosave['column_name'] = $arrTosave['table'].".".$arrTosave['field'];
    $arrTosave['f_display_column'] = join( ",", $_POST['field'] );
    if( $db->save($arrTosave,'f_key_relationships') ){
        echo "saved....";
    }
    else{ echo "faild to save......"; }
    unset( $_SESSION['fkey'] );
}

$checked = false;
// step 1
if(empty($_GET)){
    if( isset( $_SESSION['fkey'] ) ){
        unset( $_SESSION['fkey'] );
    }
    //get tables list
    $tables_list = getTablesList("ems");
    // populate
    echo "<h1>Table</h1>";
    echo "<form><p>";
    foreach ( $tables_list as $key => $value ){
        $checkedAttr = $checked? "" : "checked";
        echo "<label for='table_name'>$value: <input $checkedAttr type=radio id='table_name' name='table_name' value='".$value."' ></label>";
        $checked = true;
    }
    echo "<input name='step2' type='submit' />";
    echo "</p></form>";
}

// step 2
if ( isset( $_GET['step2'] ) ){
    $_SESSION['fkey']['table'] = $_GET['table_name'];
    $fields = $db->getTableFieldsList($_GET['table_name']);
    pr($_SESSION['fkey']);
    echo "<h1>Column</h1>";
    echo "<form method='post' action='test_Insert_F_Keys.php?step3=true'>";
    foreach ( $fields as $key => $value ){
        $checkedAttr = $checked? "" : "checked";
        echo "<p><label for='field'>$value: <input $checkedAttr type=radio id='field' name='field' value='".$value."'></label></p>";
        $checked = true;
    }
    echo "<input name='step3' type='submit' />";
    echo "</form>";
}

// step 3
if ( isset( $_GET['step3'] ) ){
    $_SESSION['fkey']['field'] = $_POST['field'];
    //get tables list
    $tables_list = getTablesList("ems");
    // populate
    pr($_SESSION['fkey']);
    echo "<h1>F Table</h1>";
    echo "<form action='test_Insert_F_Keys.php?step4=true'><p>";
    foreach ( $tables_list as $key => $value ){
        $checkedAttr = $checked? "" : "checked";
        echo "<label for='f_table_name'>$value: <input $checkedAttr type=radio id='f_table_name' name='f_table_name' value='".$value."'></label>";
        $checked = true;
    }
    echo "<input name='step4' type='submit' />";
    echo "</p></form>";
}

// step 4
if ( isset( $_GET['step4'] ) ){
    $_SESSION['fkey']['f_table'] = $_GET['f_table_name'];
    $fields = $db->getTableFieldsList($_GET['f_table_name']);
    pr($_SESSION['fkey']);
    echo "<h1>F Column</h1>";
    echo "<form method='post' action='test_Insert_F_Keys.php?step5=true'>";
    foreach ( $fields as $key => $value ){
        $checkedAttr = $checked? "" : "checked";
        echo "<p><label for='f_column'>$value: <input $checkedAttr type=radio id='f_column' name='f_column' value='".$value."'></label></p>";
        $checked = true;
    }
    echo "<input name='step5' type='submit' />";
    echo "</form>";
}

// step 5
if ( isset( $_GET['step5'] ) ){
    $_SESSION['fkey']['f_column'] = $_POST['f_column'];
    $fields = $db->getTableFieldsList($_SESSION['fkey']['f_table']);
    pr($_SESSION['fkey']);
    echo "<h1>Display Fields</h1>";
    echo "<form method='post' action='test_Insert_F_Keys.php'>";
    foreach ( $fields as $key => $value ){
        echo "<p><label for='field'>$value: <input type=checkbox id='field[]' name='field[]' value='".$value."'></label></p>";
    }
    echo "<input name='saveData' type='submit' value='saveData' />";
    echo "</form>";
}
?>

</body>
</html>

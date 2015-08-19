<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method='post'>
    <button type="submit" name="submit">Construct Pages</button>
</form>

<?php
require_once 'initialize.php';
// ********Automatic Crud Info**************

if( isset($_POST['submit']) ){
    constructPages('ems');
}

function constructPages($db_name)
{
    global $db;
    // list of tables
    $result = $db->findBySql("SHOW tables FROM " . $db_name);
    $tables_list = array();
    foreach ($result as $key => $arr) {
        // skip tables with names starting with '__'. They are linking tables
        if (!preg_match("/__/", $arr['Tables_in_' . $db_name])) {
            $tables_list[] = $arr['Tables_in_' . $db_name];
        }
    }
//     pr($tables_list,'Tables List');
    $record_to_save = array('url' => 'records.php');
    foreach ($tables_list as $key => $table_name) {
        // Check if the page already exists
        $existingPage = $db->findBySql("SELECT * FROM crud_pages WHERE table_name='" . $table_name . "'");
        if (!$existingPage) {
            $record_to_save['table_name'] = $table_name;
            $record_to_save['title'] = ucwords( preg_replace( "/_/", " ", $table_name ) );
            $record_to_save['parent_id'] = "2"; // all are sub pages of data_entery page
            pr($record_to_save);
            // save to _pages
            if ($db->save($record_to_save, "pages")) {
                echo "<p>Record Saved in pages For The Table: " . $table_name . "</p>";
            } else {
                echo "<p>Record Could Not Be Saved in pages For The Table: " . $table_name . "</p>";
            }
            // get the page id
            $record_to_save['page_id'] = $db->getLastInsId();
            // save to _crud_pages
            if ( $db->save( $record_to_save, "crud_pages" ) ) {
                echo "<p>Record Saved in crud_pages For The Table: " . $table_name . "</p>";
            } else {
                echo "<p>Record Could Not Be Saved in crud_pages For The Table: " . $table_name . "</p>";
            }
            // unset the page id so that we may not get the "duplicate primary key" error
            unset($record_to_save['page_id']);
        }
    }
    echo "<p>Done........</p>";
}


?>

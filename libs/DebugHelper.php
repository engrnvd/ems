<?php
/**
 * Date: 08-Dec-14
 * Time: 5:24 PM
 */
function pr($obj , $label=''){
    echo "<hr><b>" . $label . ":</b>";
    //echo "<pre>";
    $tableObject = false;
    if(is_array($obj)){
        foreach ( $obj as $key => $value ){
            if($value instanceof TableObject){ $tableObject = true; }
            break;
        }
    }
    if($tableObject){
        pEcho("Total Objects: ". count($obj));
        foreach ( $obj as $key => $value ){
            $value->pr();
        }
    }else{
        var_dump($obj);
    }
    //echo "</pre><hr>";
}
function pEcho($str){
    echo "<p>$str</p>";
}
function prpost(){ pr( $_POST , 'POST Array' ); }
function prget(){ pr( $_GET , 'GET Array' ); }
function prses(){ pr( $_SESSION , 'SESSION Array' ); }
function prser(){ pr( $_SERVER , 'SERVER Array' ); }
function prlq(){
    global $db;
    echo "<pre>";
    echo "<span class='query'>". $db->lastQuery . "</span><br>";
    echo "</pre>";
}
function smet(){
    global $db;
    $db->query("SET profiling = 1;"); // start measuring the exec. time for queries
}
function shet(){
    global $db;
    // show exec. time for queries
    $db->showTable("SHOW PROFILES;");
    $profiles = $db->findBySql("SHOW PROFILES");
    $numQueries = 0;
    $time = 0;
    foreach ( $profiles as $key => $value ){
        $numQueries ++;
        $time += $value['Duration'];
    }
    echo "<p>Total Querires: $numQueries</p>";
    echo "<p>Total Time: ".($time*1000)." ms</p>";
}

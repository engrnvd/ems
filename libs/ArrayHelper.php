<?php
/**
 * Created by PhpStorm.
 * User: EngrNaveed
 * Date: 12/26/2014
 * Time: 10:33 AM
 */

function find_in_array( $array, $search_val, $return_keys = false){
    $output = null;
    foreach ($array as $key => $value) {
        if( preg_match("/".$search_val."/", $value) ){
            $return_keys? $output[$key] = $value : $output[] = $value;
        }
    }
    return $output;
}

function obj2arr($obj){
    foreach ( $obj as $key => $value ){ $arr[$key] = $value; }
    return $arr;
}

/**
 * @param $keys
 * @param $array
 * @return bool
 * returns true only if all the $keys are set for $array
 */
function areSet($keys,$array){
    $result = true;
    if(!is_array($keys) || !is_array($array)){ return false; }
    foreach ( $keys as $key ){
        if( !isset($array[$key]) ){ $result = false; }
    }
    return $result;
}

/**
 * @param $array
 * @param $element
 * @param $position
 * @return array
 * Inserts $element at $position in $array
 */
 // testing
// create the array
//$x = array("apples","bananas","pears");
//var_dump($x);
//insert "oranges" at position 1
//$x = insert_in_array($x,"oranges",1);
//var_dump($x);
//insert "pineapples" 2 from the end
//$x = insert_in_array($x,"pineapples",-2);
//var_dump($x);
//insert "strawberries" at the end
//$x = insert_in_array($x,"strawberries");
//var_dump($x);
//insert "plums" at position 0 - (because the negative position goes beyond 0)
//$x = insert_in_array($x,"plums",-10);
//var_dump($x);
function insert_in_array(&$array,$element,$position=null){
    if (count($array) == 0) {
        $array[] = $element;
    }
    elseif (is_numeric($position) && $position < 0) {
        if((count($array)+$position) < 0) {
            $array = insert_in_array($array,$element,0);
        }
        else {
            $array[count($array)+$position] = $element;
        }
    }
    elseif (is_numeric($position) && isset($array[$position])) {
        $part1 = array_slice($array,0,$position,true);
        $part2 = array_slice($array,$position,null,true);
        $array = array_merge($part1,array($position=>$element),$part2);
        foreach($array as $key=>$item) {
            if (is_null($item)) {
                unset($array[$key]);
            }
        }
    }
    elseif (is_null($position)) {
        $array[] = $element;
    }
    elseif (!isset($array[$position])) {
        $array[$position] = $element;
    }
    $array = array_merge($array);
    return $array;
}

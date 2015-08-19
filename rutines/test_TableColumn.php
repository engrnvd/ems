<?php require_once 'initialize.php';

$test = new Test(1);
//$filterFields = array();
//foreach ( $test as $key => $value ){
//    $filterFields[] = new FilterField($value);
//}
//pr($filterFields[0]);
//$ff = new FilterField($test->date);
//$ff->filterType = 'bw';
//echo $ff->getMarkup();

$var = 90;
echo $var instanceof TableObject ? "Yes" : "No";
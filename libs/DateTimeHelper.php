<?php
/**
 * Created by PhpStorm.
 * User: EngrNaveed
 * Date: 12/26/2014
 * Time: 10:34 AM
 */

/**
 * @param $startDate String
 * @param $endDate String
 * @return array
 * used in testReportStudent.php indirectly through FilterOptions::durationStr()
 */
function getMonthsFromDates($startDate,$endDate){
    $return = array();
    if($startDate && $endDate){
        $return['start'] = formatDate($startDate, "%b %Y");
        // end month will be same if the endDate is 1st of the month
        $ymd = explode("-", $endDate );
        if( count($ymd) == 3 && $ymd[2] == 1 ) { $return['end'] = $return['start']; }
        else{ $return['end'] = formatDate($endDate, "%b %Y"); }
    }
    return $return;
}

function getLast12Months( $format = "%b %Y"){
    $currentDate = today();
    $currentMonth = formatDate($currentDate , "%m");
    $currentYear = formatDate($currentDate , "%Y");
    $startingYear = $currentYear - 1;
    $last_12_months = array();
    for ($i=( (int)$currentMonth+1); $i <= 12; $i++) {
        $last_12_months[] = formatDate( $startingYear."-".$i."-01" , $format );
    }
    for ($i=1; $i <= $currentMonth; $i++) {
        $last_12_months[] = formatDate( $currentYear."-".$i."-01" , $format );
    }
    return $last_12_months;
}

function formatDate( $dateString , $format = "%a %d %B %Y" ){
    $ymd = explode("-", $dateString );
    if( count($ymd) == 3 ){
        $y = $ymd[0];
        $m = $ymd[1];
        $d = $ymd[2];
        if( checkdate($m,$d,$y) ){ return strftime( $format , mktime( 0, 0, 0, $m , $d, $y ) ); }
    }
    return $dateString;
}

function today(){ return strftime("%Y-%m-%d"); }

function currentYear(){ return strftime("%Y"); }

function currentMonth(){ return strftime("%m"); }

function getime( $dateString){
    list( $y, $m , $d ) = explode("-", $dateString );
    return mktime( 0, 0, 0, $m , $d, $y );
}
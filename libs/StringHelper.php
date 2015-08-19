<?php
/**
 * Created by EngrNaveed
 * Date: 09-Dec-14
 * Time: 1:52 AM
 */

function encrypt($string){
    $encryptedString = '';
    for($i=0;$i<strlen($string);$i++){
        // after every encrypted char, a '-' is appended
        if($encryptedString){ $encryptedString .= "-"; }
        // encrypt each char and append it to the encrypted string
        $encryptedString .= ( 2 * ord( $string[$i] ) + 10 );
    }
    return $encryptedString;
}

function decrypt($encryptedString){
    $decryptedString = '';
    $arr = explode("-",$encryptedString);
    foreach($arr as $num){
        $decryptedString .= chr(($num-10)/2);
    }
    return $decryptedString;
}

/**
 * @param $str
 * @return string
 * Returns the singular of a string.
 * e.g singularize('cities') returns 'city'
 */
function singularize($str){
    if( preg_match("/^(c|C)las$/",$str) ){ return "class"; }
    elseif( preg_match("/ies$/",$str) ){ return substr( $str, 0, -3 )."y"; }
    elseif( preg_match("/es$/",$str) ){ return substr( $str, 0, -2 ); }
    elseif( preg_match("/s$/",$str) ){ return substr( $str, 0, -1 ); }
    else{ return $str; }
}

function plural($str){
    if(preg_match("/s$/",$str)){ return $str."es"; }
    elseif(preg_match("/y$/",$str)){ return substr( $str, 0, -1 )."ies"; }
    else{ return $str."s"; }
}

function getFileExtension($str){
    // extract the extension from a string like somefile.txt

    // 1. position of "."
    $pos = strrpos( $str , ".");
    // 2. extract
    return substr( $str , $pos );
}

/**
 * @param $str
 * String like 'some_string'
 * @return string
 * String like 'Some String'
 */
function uc_words($str){ return ucwords( preg_replace( '/_/', ' ', $str ) ); }

/**
 * @param $tblname
 * e.g. persons
 * @return string e.g. Person
 */
function tbl2cls($tblname){
    $clasname = ucwords(singularize($tblname));
    if( $clasname == 'Class' ){ $clasname = 'Clas'; }
    return $clasname;
}

function number_to_words($number) {

    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= number_to_words($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}
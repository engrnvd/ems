<?php
/**
 * Created by EngrNaveed.
 * Date: 03-Jan-15
 * Time: 5:03 PM
 */

class DefValues {
//    static $city = "Bahawal Pur";
//    static $tehsil = "Bahawal Pur";
//    static $district = "Bahawal Pur";
//    static $religion = "Islam";

    static function date(){ return today(); }
    static function admission_date(){ return today(); }
    static function year(){ return currentYear(); }
    static function session(){ return currentYear(); }
    static function month(){ return currentMonth(); }
    static function last_date_for_fee_submission(){ return 6; }
    // only temp.
//    static function dob(){ return today(); }
//    static function phone(){ return "03336353288"; }
//    static function cnic(){ return "3130316853001"; }
//    static function father_id(){ return 3; }
}

function getDefVal($field){
    global $db;
    $classname = "DefValues";
    if( property_exists($classname,$field) ){
        return $classname::$$field;
    }
    elseif( method_exists($classname,$field) ){
        return call_user_func_array($classname."::".$field,array());
    }
    elseif($value = $db->gfv("value",'default_values',"key_name = '".$field."'")){
        return $value;
    }
    else{
        return null;
    }
}


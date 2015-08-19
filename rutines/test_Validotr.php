<?php
/**
 * Created by EngrNaveed.
 * Date: 03-Jan-15
 * Time: 10:52 AM
 */
require_once "initialize.php";

// required******************************
$fields = array('field1','field2','field3');
$arrayToValidate = array(
    'field1' => '',
    'field2' => '0',
    'field3' => 0
);
//pr($arrayToValidate);
//$validator->validateRequired($fields,$arrayToValidate);
//if( $validator->hasNoErrors() ){ echo "<p>The array has passed the required test.</p>"; }
//else{ pr($validator->extractErrors(), "Errors"); }

// max length******************************
$fields = array('field1','field2','field3');
$arrayToValidate = array(
    'field1' => '123465',
    'field2' => 'Naveed',
    'field3' => 'mustansar husain tararr'
);
//pr($arrayToValidate);
//$validator->validateMaxLength($fields,$arrayToValidate,'10');
//if( $validator->hasNoErrors() ){ echo "<p>The array has passed the maxlength(11) test.</p>"; }
//else{ pr($validator->extractErrors(), "Errors"); }


// passwords******************************
$fields = array('password','password2');
$arrayToValidate = array(
    'password' => 'pass',
    'password2' => 'pass'
);
//pr($arrayToValidate);
//$validator->validateMatchingFields($fields,$arrayToValidate);
//if( $validator->hasNoErrors() ){ echo "<p>The array has passed the matching fields test.</p>"; }
//else{ pr($validator->extractErrors(), "Errors"); }

// dates ******************************
$fields = array('field1','field2','field3','field4','field5');
$arrayToValidate = array(
    'field1' => '2014-12-31', // valid
    'field2' => '2014/12/31', // invalid
    'field3' => '2014-12', // invalid
    'field4' => '2014-2-28', //valid
    'field5' => '2014-02-29', //invalid
);
//pr($arrayToValidate);
//$validator->validateDates($fields,$arrayToValidate);
//if( $validator->hasNoErrors() ){ echo "<p>The array has passed the dates test.</p>"; }
//else{ pr($validator->extractErrors(), "Errors"); }

// cnic ******************************
$fields = array('field1','field2','field3','field4','field5');
$arrayToValidate = array(
    'field1' => '3130316853001',
    'field2' => '31303-1685300-1',
    'field3' => 'a3130316853001',
    'field4' => '3130316853001e',
    'field5' => '313031685300e'
);
//pr($arrayToValidate,'$arrayToValidate');
//$validator->validateCNICs($fields,$arrayToValidate);
//if( $validator->hasNoErrors() ){ echo "<p>The array has passed the cnic test.</p>"; }
//else{ pr($validator->extractErrors(), "Errors"); }

// phones ******************************
$fields = array('field1','field2','field3','field4','field5');
$arrayToValidate = array(
    'field1' => '31303168530',
    'field2' => '31303-1685300',
    'field3' => '03336353288',
    'field4' => '313031',
    'field5' => '313031685300e'
);
//pr($arrayToValidate,'$arrayToValidate');
//$validator->validatePhones($fields,$arrayToValidate);
//if( $validator->hasNoErrors() ){ echo "<p>The array has passed the phones test.</p>"; }
//else{ pr($validator->extractErrors(), "Errors"); }

// numbers ******************************
$fields = array('field1','field2','field3','field4','field5');
$arrayToValidate = array(
    'field1' => '31303168530',
    'field2' => '31303-1685300',
    'field3' => array('1','2','3d',''),
    'field4' => '',
    'field5' => '313031685300e'
);
//pr($arrayToValidate,'$arrayToValidate');
//$validator->validateNumFields($fields,$arrayToValidate);
//if( $validator->hasNoErrors() ){ echo "<p>The array has passed the NumFields test.</p>"; }
//else{ pr($validator->extractErrors(), "Errors"); }

// validate() *******************************************
$rule = "MaxLength";
$fields = array('field1','field2','field3');
$arrayToValidate = array(
    'field1' => '123465',
    'field2' => 'Naveed',
    'field3' => 'mustansar husain tararr'
);
//$validator->validate($rule, array($fields, $arrayToValidate,'10') );
//pr($arrayToValidate,'$arrayToValidate');
//if( $validator->hasNoErrors() ){ echo "<p>The array has passed the $rule test.</p>"; }
//else{ pr($validator->extractErrors(), "Errors"); }

// object validation test
$person = new Person();
$person->first_name = "Mukhye";
$person->last_name = "Mantri";
$person->phone = "09233363532";
$person->dob = "2012-12-20";
$person->gender = 'Male';
$person->religion = "Islam";
$person->cnic = "3130316853003";
//$person->dbSave();
pr($person);
pr($validator->extractErrors());
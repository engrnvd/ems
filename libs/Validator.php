<?php

class Validator{
    private $errors = array();

    public function hasNoErrors(){ return empty($this->errors); }

    /**
     * @return array
     * returns an array of $errors if any.
     * returns an empty array in case of no errors
     * Important: Once you have called this method,
     * the validator object will set its $errors to an empty array
     * so that it may be ready for the next validation
     */
    public function extractErrors(){
        $errors = $this->errors;
        $this->errors = array();
        return $errors;
    }

    public function extractError($field){
        if(isset($this->errors[$field])){
            $error = $this->errors[$field];
            unset($this->errors[$field]);
            return $error;
        }
        return array();
    }

    public function addError( $field, $desc ){
        $this->errors[$field][] = $desc;
    }

    public function validate( $rule, $params ){
        // call_user_func_array(array($object , "func"), array("param1", "param2"));
        $func = "validate".$rule;
        call_user_func_array( array($this,$func), $params );
    }

    /**
     * @param $fields array of field names to be validated
     * @param $array
     * $fields can not be empty
     * Note: if $field has a value equal to 0, it is acceptable
     */
    public function validateRequired( $fields, $array ){
        foreach ($fields as $field) {
            if ( empty($array[$field]) && $array[$field] != '0' ) {
                $this->addError($field,"$field can not be empty.");
            }
        }
    }

    function validateMaxLength( $fields, $array, $maxLength ){
        foreach ($fields as $field) {
            if ( strlen($array[$field]) > $maxLength ) {
                $this->addError($field,"$field should not be larger than $maxLength characters.");
            }
        }
    }

    function validateMatchingFields( $fields, $array ){
        if ( $array[$fields[0]] != $array[$fields[1]] ) {
            $this->addError($fields[0],"{$fields[0]}s must match.");
        }
    }

	public function validateDates( $datesArray , $array){
		foreach ($datesArray as $dateField) {
			$dateString = $array[$dateField];	//get the date string
			$date = explode('-', $dateString);	//split it into year, month & day
			if( count($date) != 3 || !checkdate($date[1], $date[2], $date[0]) ){
                $this->addError($dateField, 'The date should be a valid date and formatted as yyyy-mm-dd.');
			}
			elseif( !preg_match("/\d{4}-\d{2}|\d{1}-\d{2}|\d{1}/", $dateString) ){
                $this->addError($dateField, 'The date should be formatted as yyyy-mm-dd.');
			}
		}
	}
	
	public function validateCNICs($cnicsFields, $array){
		foreach ($cnicsFields as $cnicsField) {
			$cnic = $array[$cnicsField];
			if(  !preg_match( "/\d{13}/", $cnic ) || strlen($cnic) != 13 ){
                $this->addError($cnicsField, 'The cnic should contain exactly 13 digits (without any dashes)');
			}
		}
	}

	public function validateYears($years, $array){
		foreach ($years as $year) {
            $year = $array[$year];
			if(  !preg_match( "/\d{4}/", $year ) || strlen($year) != 4 ){
                $this->addError($year, 'The year should contain 4 digits.');
			}
		}
	}

    /**
     * @param $fields
     * e.g. array(
            'gender' => array('Male','Female'),
            'option' => array('Yes', 'No')
            );
     * @param $arrayToValidate
     *e.g. array(
            'name' => 'asad nawaz khichi',
            'gender' => 'Male',
            'option' => 'Yes'
            );
     *
     */
    public function validateSelectFields($fields, $arrayToValidate){
        foreach ( $fields as $field => $options ){
            if( !in_array( $arrayToValidate[$field], $options ) ){
                $this->addError($field,"$field must be exactly one of the following: ".join(", ", $options));
            }
        }
	}

	public function validatePhones($phoneFields, $arrayToValidate){
		foreach ($phoneFields as $phoneField) {
			$phone = $arrayToValidate[$phoneField];
            if(  !preg_match( "/^\d*$/", $phone ) || strlen($phone) > 11 ){
                $this->addError($phoneField, 'The phone number should contain only digits (a maximum of 11) without any dashes.');
            }
		}
	}

	public function validateNumFields($numFields, $arrayToValidate){
		foreach ($numFields as $field) {
			if(is_array($arrayToValidate[$field])){ // this if-block is added for the following condition:
				// in paysRecords.php, the form has multiple records. ($_POST['pay'] is an array)
				foreach ($arrayToValidate[$field] as $key => $value) {
					if(!is_numeric($value)){ $this->addError($field, $value." should be a numeric value."); }
				}
			}elseif( !is_numeric($arrayToValidate[$field]) ){
                $this->addError($field, "'".$arrayToValidate[$field]."' should be a numeric value.");
			}
		}
	}

}

$validator = new Validator();

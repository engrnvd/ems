<?php

/**
 * Takes an associative array and appends its key => value pairs
 * in the query string of the current url.
 * Very helpful when you don't know what the current url will be.
 * e.g. when you include pagination on more than one page,
 * the pagination links need to have a dynamic href attribute.
 * @param $arr
 * The associative array to be appended in the url
 * @return mixed|string
 * The new url string
 */
function appendToCurrentUri($arr){
    $currentUri = $_SERVER['REQUEST_URI'];
    $extraQuery = array();
    foreach( $arr as $key => $value ){
        // if $extraQuery is already present in the url, remove it
        if( array_key_exists( $key, $_GET ) && preg_match("/".$key."\=/", $currentUri) ){
            if( preg_match("/".$key."\=.*\&/", $currentUri) ){ $currentUri = preg_replace("/".$key."\=.*\&/","",$currentUri); }
            else{ $currentUri = preg_replace("/".$key."\=.*/","",$currentUri); }
        }
        $extraQuery[] = $key."=".$value;
    }
    if( !empty($extraQuery) ){
        $extraQuery = join("&",$extraQuery);
        // if query string is not empty:
        if( preg_match("/\&$/",$currentUri) ){ $currentUri .= $extraQuery; } // if & is present at the end
        elseif( preg_match("/\?/",$currentUri) ){ $currentUri .= "&".$extraQuery; } // if ? is present, the query string is not empty
        // if query string is empty:
        else{  $currentUri .= "?".$extraQuery;  }
    }
    return $currentUri;
}

function icon($icon){
	// returns the markup for glyphicon
	// requires bootstarp
	return "<span class='glyphicon glyphicon-".$icon."'></span>";
}

function isAjax(){
    return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest');
}

function redirect( $location = NULL ) {
	// redirects to location
  if ($location != NULL) {
    header("Location: {$location}");
    exit;
  }
}

function reloadCurrentPage(){
    redirect($_SERVER['REQUEST_URI']);
}

function formBool($val = 0){
	$bool = array( 'No' , 'Yes' );
	return $bool[$val];
}

function keys2vars($arr){
	if(!empty($arr)){
		foreach ($arr as $key => $value) {
			if($key == 'session'){
				$key = 'sessionVal';
			}
			global $$key;
			$$key = $value;
		}
	}
}

function uploadFile( $fileToUpload , $destination ){
	// pr($_FILES);
	// pr($_POST);

	global $session;

	// 1. list possible errors
		$uploadErrors = array(
			0 => 'The file uploaded successfully!',
			1 => 'Error: The uploaded file exceeds the upload_max_filesize directive in php.ini.',
			2 => 'Error: The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
			3 => 'Error: The uploaded file was only partially uploaded.',
			4 => 'Error: There was no file to uploade.',
			6 => 'Error: Missing a temporary folder.',
			7 => 'Error: Failed to write file to disk.',
			8 => 'Error: A PHP extension stopped the file upload.'
			);
		$errorCode = isset($_FILES[$fileToUpload]['error'])? $_FILES[$fileToUpload]['error'] : '';
	// 2. error message to display
		$errorMsg = '';
	// 3. if no errors, move the file to some folder
		if($errorCode == 0){
			// no error: move the file
			$tempName = $_FILES[$fileToUpload]['tmp_name'];

			if( !move_uploaded_file( $tempName, $destination ) ){
				$errorMsg = "Error: Could not move file.";
			}
		}else{
			// error in uploading:
			$errorMsg = $uploadErrors[$errorCode];
		}
	// 4. display error, if any
		if( !empty($errorMsg) ){
			$session->setMessage( $errorMsg , 'eMsg');
			return false;
		}
	// 5. if no error
		return true;
}

function getStPhoto($stId){
	$output = "<img class='stSearchPhoto' src='../photos/";
	$output .= file_exists( "../photos/".$stId.".jpg" ) ? $stId : "default";
	$output .= ".jpg'>";
	return $output;
}

function isFormSubmitted(){
    if( isset($_POST['submit']) ){ return $_POST; }
    return false;
}
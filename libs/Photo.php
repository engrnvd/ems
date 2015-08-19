<?php

class Photo{
// variables used:
// name of the input of type='file'
public $inputFile = '';
// set the target name of the file
public $targetName = "";
// where to store the file
public $destination = '';

public $error = '';

private $uploadErrors = array(
				0 => 'The file uploaded successfully!',
				1 => 'Error: The uploaded file exceeds the upload_max_filesize directive in php.ini.', 
				2 => 'Error: The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
				3 => 'Error: The uploaded file was only partially uploaded.',
				4 => 'Error: There was no file to uploade.',
				6 => 'Error: Missing a temporary folder.',
				7 => 'Error: Failed to write file to disk.',
				8 => 'Error: A PHP extension stopped the file upload.'
			);

public function upload($inputFile,$targetName,$uploadDir){
	// process form data:
	// - check for errors first
	if(!isset( $_FILES[$inputFile] ) || empty($_FILES[$inputFile]) || !is_array($_FILES[$inputFile])){
		// file error
		$this->error = "No file was uploaded.";
		return false;
	}elseif($_FILES[$inputFile]['error'] != 0){
		// upload error
		$this->error = $this->uploadErrors[$_FILES[$inputFile]['error']];
		return false;
	}elseif( empty($targetName) ){
		$this->error = "Either the filename or the file path is empty.";
		return false;
	}elseif( preg_match( '/^image/' , $_FILES[$inputFile]['type'] ) == 0){
		// file is not an image
		$this->error = "Not a valid image File.";
		return false;
	}
	else{
		// no error: attach info
		$this->inputFile = $inputFile;
		$this->targetName = $targetName;
		$this->destination = $uploadDir . "/" . $this->targetName;

		// finally check whether the file already exists
		// if(file_exists($this->destination)){
		// 	$this->error = "File already exists.";
		// 	return false;
		// }
		// Error checking completed! :) try to move it now.
		if( move_uploaded_file($_FILES[$inputFile]['tmp_name'], $this->destination) ){
			return true;
		}else{
			// could not move file
			$this->error = "Could not move file, possibly due to incorrect permissions on the upload folder.";
			return false;
		}
	}
}
public function resizeImage($srcimg,$dstimg,$nw,$nh){
	list($w,$h) = getimagesize($srcimg);
	$img = imagecreatefromjpeg($srcimg);

	$df = ($h/$nh) < ($w/$nw) ? $h/$nh : $w/$nw; //division factor
	$tw = $w/$df;   // temp width
	$th = $h/$df;   // temp height

	$new_img = imagecreatetruecolor($nw,$nh);
	$dx = round(($w-$nw*$df)/2);
	$dy = round(($h-$nh*$df)/2);

	imagecopyresampled( $new_img, $img, 0, 0, $dx, $dy, $tw, $th, $w, $h );
	ob_start();
	imagejpeg($new_img);
	$i = ob_get_clean(); 
	$fp = fopen ($dstimg,'w');
	fwrite ($fp, $i);
	fclose ($fp);
}

}


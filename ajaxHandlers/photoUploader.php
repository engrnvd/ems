<?php
/**
 * Created by PhpStorm.
 * User: Engr. Naveed
 * Date: 2/6/2015
 * Time: 6:10 PM
 */
require_once __DIR__."/"."../initialize.php";

if( isset( $_FILES['photoInput'] ) & isset($_POST['person_id']) ){
    $inputFile = 'photoInput';
    $uploadDir = "../photos";
    $targetName = $_POST['person_id'].".jpg";

    $photo = new Photo();
    if( $photo->upload($inputFile,$targetName,$uploadDir) ){
        $photo->resizeImage($photo->destination,$photo->destination,210,260);
        echo "Photo uploaded successfully.";
    }else{
        echo $photo->error;
    }
}



?>
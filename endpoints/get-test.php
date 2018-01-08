<?php
require_once ("../includes/HttpResponse.php");
require_once ("../includes/Validation.php");
require_once ("../android-php/TestGenerator.php");
require_once ("../android-php/Test.php");
if(isset($_POST['user_id'])){
    $userId = Validation::validateData($_POST['user_id']);
    $chapters = array();
    $duration = 10;
    $marks = 10;
    if(isset($_POST['all'])){
        //requesting for all the test appeared by the particular user

    }
    else if(isset($_POST['chapters'])){
        $temp= $_POST['chapters'];
        foreach ($temp as $item){
            $chapters[] = Validation::validateData($item);
        }
    }
    else{
        HttpResponse::setHttpResponseCode(422);
    }
    if(isset($_POST['duration'])){
        $duration = Validation::validateData($_POST['duration']);
    }
    else{
        HttpResponse::setHttpResponseCode(422);
    }
    if(isset($_POST['marks'])){
        $marks = Validation::validateData($_POST['marks']);
    }
    else{
        HttpResponse::setHttpResponseCode(422);
    }
    $json = TestGenerator::generateTest($userId,$marks,$chapters,$duration);
    echo $json;
}
else{
    HttpResponse::setHttpResponseCode(422);
}
<?php
require_once ("../includes/HttpResponse.php");
require_once ("../android-php/TestGenerator.php");
require_once ("../includes/Validation.php");
/*
 * URL :
 * [subdomain]/GET-test.php
 * Parameters :
 *     user_id = unique numeric id of the user (primary key in the users table)
 *     chapters = array of chapters whose questions is to be requested
 *     marks = total marks the test is requested for
 *     duration = time duration of the test in minutes
 *
 * IF ANY OF THE REQUIRED PARAMETER IS MISSING , SERVER WILL RESPOND WITH ERROR CODE 422
 * */
if(isset($_GET['user_id'])){
    $userId = Validation::validateData($_GET['user_id']);
    $chapters = array();
    $duration = 10;
    $marks = 10;
    if(isset($_GET['all'])){
        //requesting for all the test appeared by the particular user

    }
    else if(isset($_GET['chapters'])){
        $temp= $_GET['chapters'];
        foreach ($temp as $item){
            $chapters[] = Validation::validateData($item);
        }
    }
    else{
        HttpResponse::setHttpResponseCode(422);
    }
    if(isset($_GET['duration'])){
        $duration = Validation::validateData($_GET['duration']);
    }
    else{
        HttpResponse::setHttpResponseCode(422);
    }
    if(isset($_GET['marks'])){
        $marks = Validation::validateData($_GET['marks']);
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
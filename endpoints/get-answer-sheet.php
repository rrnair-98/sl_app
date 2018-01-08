<?php
require_once ("../includes/HttpResponse.php");
require_once ("../includes/Validation.php");
require_once ("../android-php/AnswerSheet.php");
if(isset($_POST['user_id'])){
    $testId = -1;
    $userId = $_POST['user_id'];
    $userId = Validation::validateData($userId);
    if(isset($_POST['all']) && $_POST['all'] == 'true'){
        //if all is true send the list of tests

    }
    else{
        //find a particular test given upon te test id
        if(isset($_POST['test_id'])){
            $testId = $_POST['test_id'];
            $testId = Validation::validateData($testId);
            $answerSheet = new AnswerSheet($testId);
            echo $answerSheet->getJson();
        }
        else {
            HttpResponse::setHttpResponseCode(422);
        }
    }
}
else{
    HttpResponse::setHttpResponseCode(422);
}
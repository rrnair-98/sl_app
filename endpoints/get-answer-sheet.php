<?php
require_once ("../includes/HttpResponse.php");
require_once ("../includes/Validation.php");
require_once ("../android-php/AnswerSheet.php");
if(isset($_GET['test_id'])){
    $testId = $_GET['test_id'];
    $testId = Validation::validateData($testId);
    $answerSheet = new AnswerSheet($testId);
    echo $answerSheet->getJson();
}
else {
    HttpResponse::setHttpResponseCode(422);
}
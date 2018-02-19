<?php
/*require_once ("../android-php/Crud.php");
require_once ("../android-php/DatabaseConstants.php");*/
require_once('../android-php/AnswerSheetModel.php');
require_once ("../includes/HttpResponse.php");
require_once ("../includes/Validation.php");
/*
 * URL :
 * [subdomain]/insert-answer.php
 * Parameters :
 *     answer = {json format of the answer submitted by client}
 *
 * IF ANY OF THE REQUIRED PARAMETER IS MISSING , SERVER WILL RESPOND WITH ERROR CODE 422
 * */
/*
 * JSON Format :
 * MCQ
{
"test_id": "1",
"question_id":"20",
"answers":["24"],
"type":"1"
}
FIB
{
"test_id": "1",
"question_id":"20",
"answers":["a"],
"type":"2"
}
MTF
{
"test_id": "1",
"question_id":"20",
"answers":["1","3","2","4"],
"type":"3"
}
*/
if(isset($_GET['answer'])){
    //$answer_string = Validation::validateData($_GET['answer']);
   $answer_string = $_GET['answer'];
   //echo $answer_string;
    echo "prining <bt>".$answer_string;
    $answers = json_decode($answer_string,true);
    $test_id = $answers['test_id'];
    echo "<bt><bt><bt>";
  print_r($answers);
    
    for($i=0;$i<count($answers['ans']);$i++)
    {
        $answer = $answers['ans'][$i];
        
        $answer_sheet = new AnswerSheetModel($test_id,$answer['question_id'],$answer['answers'],$answer['type']);

    }
    HttpResponse::setHttpResponseCode(200);
    //echo " ";
}
else{
    HttpResponse::setHttpResponseCode(422);
}
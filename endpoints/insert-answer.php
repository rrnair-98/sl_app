
<?php
/**
 * Created by PhpStorm.
 * User: ADMIN-PC
 * Date: 08-01-2018
 * Time: 12:05 PM
 */

    require_once ("Crud.php");
    require_once ("DatabaseConstants.php");
include_once ('../AnswerSheet-model.php');
    $answer_string = $_POST['answer'];

    $answers = json_decode($answer_string,true);

   // print_r($answers);

    for($i=0;$i<count($answers);$i++)
    {
        $answer = $answers[$i];

        $answer_sheet = new AnswerSheet($answer['test_id'],$answer['question_id'],$answer['answers'],$answer['type']);

    }

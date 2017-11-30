<?php
require_once ("AnsweredQuestion.php");
require_once ("DatabaseConstants.php");
$answeredQuestion = new AnsweredQuestion(1);
if($answeredQuestion->isCorrect()){
    echo "<h1>Answer is correct </h1>";
}
else{
    echo "<h1>Answer is incorrect </h1>";
}
$option = new Option(3444);
var_dump($option);
?>
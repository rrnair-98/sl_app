<?php
require_once ("AnswerSheet.php");
require_once ("DatabaseConstants.php");
$answerSheet = new AnswerSheet(1001);
$list = $answerSheet->getAnsweredQuestions();
foreach ($list as $item){
    echo "answer id =". $item->getSelectedOption()->getOptionID()." , answer id = ".$item->getAnswer()->getOptionID()
    ."correct = ".$item->isCorrect()."<br>";
}
echo "count = ".count($list);
?>
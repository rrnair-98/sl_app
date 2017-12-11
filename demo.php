<?php
require_once ("AnswerSheet.php");
require_once ("DatabaseConstants.php");
require_once ("Crud.php");
require_once ("MiscellaneousAnswer.php");
$testId = 1001;
$answerSheet = new AnswerSheet($testId);
$answeredQuestion = $answerSheet->getAnsweredQuestions();
echo "<table>";
echo "<tr>";
echo "<th>"; echo "Answer Sheet Id"; echo "</th>";
echo "<th>"; echo "Question Id"; echo "</th>";
echo "<th>"; echo "Question statement"; echo "</th>";
echo "<th>"; echo "Marks"; echo "</th>";
echo "<th>"; echo "Answered Id"; echo "</th>";
echo "<th>"; echo "Answered Statement"; echo "</th>";
echo "<th>"; echo "Answer Id"; echo "</th>";
echo "<th>"; echo "Answer Statement"; echo "</th>";
echo "<th>"; echo "Is Correct"; echo "</th>";
echo "</tr>";

foreach ($answeredQuestion as $item){
    echo "<tr>";
    echo "<td>"; echo $item->getAnswerSheetId(); echo "</td>";
    $question = $item->getQuestion();
    echo "<td>"; echo $question->getQuestionID(); echo "</td>";
    echo "<td>"; echo $question->getQuestionStatement(); echo "</td>";
    echo "<td>"; echo $question->getQuestionMarks(); echo "</td>";
    if($question->getQuestionType() == 1){
        $selectedOption = $item->getSelectedOption();
        echo "<td>"; echo $selectedOption->getOptionID(); echo "</td>";
        echo "<td>"; echo $selectedOption->getOptionStatement(); echo "</td>";
    }
    else{
        $miscellaneousAnswer = $item->getMiscellaneousAnswer();
        echo "<td>"; echo $miscellaneousAnswer->getMiscellaneousAnswerId(); echo "</td>";
        echo "<td>"; echo str_replace(" ",""
            ,$miscellaneousAnswer->getMiscellaneousStatement()); echo "</td>";
    }
    $answer = $item->getAnswer();
    echo "<td>"; echo $answer->getOptionID(); echo "</td>";
    echo "<td>"; echo str_replace(" ",""
        ,$answer->getOptionStatement()); echo "</td>";
    if($item->isCorrect()){
        echo "<td>"; echo "true"; echo "</td>";
    }
    else {
        echo "<td>"; echo "false"; echo "</td>";
    }
    echo "</tr>";
}

echo "</table>";

echo "Total questions asked : ".$answerSheet->getTotalQuestions()."<br>";
echo "Total questions correctly answered  : ".$answerSheet->getTotalCorrectlyAnsweredQuestions()."<br>";
echo "Total marks : ".$answerSheet->getTotalMarks()."<br>";
echo "marks scored : ".$answerSheet->getMarksScored()."<br>";
$i=0;

echo "<hr>";

$ma = new MiscellaneousAnswer(11);
echo "statement :".$ma->getMiscellaneousAnswerId();

$item = $answeredQuestion[10];

echo "<br>";
$a = str_replace(" ","",$item->getMiscellaneousAnswer()->
    getMiscellaneousStatement());
echo "option = ".$a;
echo "<br>";
$b = str_replace(" ","",$item->getAnswer()->getOptionStatement());
echo "answer = ".$b;
$a = str_replace("\n","",$a);
$b = str_replace("\n","",$b);
$a = str_replace("\t","",$a);
$b = str_replace("\t","",$b);
$a = str_replace("\r","",$a);
$b = str_replace("\r","",$b);
$lenA=strlen($a);
$lenB=strlen($b);
echo "<br>Length of A = $lenA";
echo "<br>Length of B = $lenB";
$htmlA = htmlspecialchars($a);
$htmlB = htmlspecialchars($a);
echo "<br>HTML A = ".$htmlA;
echo "<br>HTML B = ".$htmlB;
for($i=0;$i<strlen($a);$i++){
    if($a[$i] != $b[$i]){
        echo "<br> unmatched string";
        echo "i = $i";
        echo "<br> a[$i] =". $a[$i];
        echo "<br> b[$i] =". $b[$i];
        break;
    }
}
echo "<br>Printing A<br>";
for($i=0;$i<$lenA;$i++){
    echo "$a[$i]";
}
//if(strcmp($a,$b) ==0 ){
if($a==$b ){
    echo "<br> true";
}
$a[1]='X';
echo"<br>A = $a<br>";
echo $answerSheet->getJson();
?>

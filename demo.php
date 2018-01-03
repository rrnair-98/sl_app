<?php
require_once ("AnswerSheet.php");
require_once ("DatabaseConstants.php");
require_once ("Crud.php");
require_once ("MiscellaneousAnswer.php");
require_once ("TestGenerator.php");
require_once ("Question.php");
$count = TestGenerator::generateTest(1,10,array(1),10);
echo "$count";
/*$json = "{
   \"major_stmt\" : \"Match the following\",
  \"question_stmt\" : [
      {
        \"sub_id\" : \"1\",
        \"text\" : \"sub-Question 1\" ,  
        \"text_image\":\"\" 
      },
      {
        \"sub_id\" : \"2\",
        \"text\" : \"sub-Question 2\" ,  
        \"text_image\":\"\" 
      },
      {
        \"sub_id\" : \"3\",
        \"text\" : \"sub-Question 3\" ,  
        \"text_image\":\"\" 
      },
      {
        \"sub_id\" : \"4\",
        \"text\" : \"sub-Question 4\" ,  
        \"text_image\":\"\" 
      }
    ]}";*/
/*$question = new Question(29361);
$json = $question->getJson();
echo "<br>printing Json: <br>$json";
$arr = json_decode($json);
echo "<br><br>";
var_dump($arr);
echo "<br> Major statement = ".$arr->question_statement->major_stmt;
echo "<br> count = ".count($arr);
echo "<br>printing :";
$arr =  $arr->question_statement->question_stmt;
//$arr =  $arr['question_statement'];
for($i = 0;$i<4;$i++){
//   $temp = $arr['question_stmt'][$i];
    $temp = $arr[$i];
   echo "<br> $i = ";
   var_dump($temp);
   echo "<br>JSON $i = <br>";
   echo json_encode($arr[$i]);
}*/
?>

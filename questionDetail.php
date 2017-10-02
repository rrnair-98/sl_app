<?php



include_once('Layer2-Model.php');

$crud = new Crud("localhost","root","","quizapp");



$ques = new Question($crud,29361);

$data = new QuestionData($crud,$ques);



echo json_encode($data);






?>

<!--

{ 
  "major_stmt" : "select corect option",
  "question_stmt" : [
      {
        "text" : "identify which keyword is used for exception handling",
        "text_image":"" 
      }
    ]}
{ 
  "major_stmt" : "select corect option",
  "question_stmt" : [
      {
        "text" : "identify which keyword is used for exception handling",
        "text_image":"" 
      }
    ]}

{ 
   "major_stmt" : "Match the following",
  "question_stmt" : [
      {
        "sub_id" : "1"
        "text" : "sub-Question 1" ,  
        "text_image":"" 
      },
      {
        "sub_id" : "2"
        "text" : "sub-Question 2" ,  
        "text_image":"" 
      },
      {
        "sub_id" : "3"
        "text" : "sub-Question 3" ,  
        "text_image":"" 
      },
      {
        "sub_id" : "4"
        "text" : "sub-Question 4" ,  
        "text_image":"" 
      }
    ]}



-->



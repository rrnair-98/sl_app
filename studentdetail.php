<?php
include_once('Layer2-Model.php');

$crud = new Crud("localhost","root","","quizapp");

$id = $_POST['user_id'];

$sd = new StudentDetails($crud,$id);
$ss = new StudentSubject($crud,$id);
$data = new StudentData($crud,$sd,$ss);


echo json_encode($data);






?>
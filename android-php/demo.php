<?php
ob_start();
require_once ("AnswerSheet.php");
require_once ("DatabaseConstants.php");
require_once ("Crud.php");
require_once ("MiscellaneousAnswer.php");
require_once ("TestGenerator.php");
require_once ("Question.php");
$count = TestGenerator::generateTest(1,7,array(2,3),10);
echo "$count";
/*$as = new AnswerSheet(1001);
echo $as->getJson();*/


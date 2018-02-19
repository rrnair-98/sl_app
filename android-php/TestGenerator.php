<?php
require_once ("Crud.php");
require_once ("DatabaseConstants.php");
require_once ("Question.php");
require_once ("Test.php");
/*
 * This class generates a test depending upon the user id and chapters and marks
 * If the sack containing questions does not sum upto total marks then the total marks is
 * reduced to sum of questions in the sack
 * The class returns a json file containing the entire question paper*/


class TestGenerator implements DatabaseConstants
{
    /*maximum number of options for mcq*/
    const MAX_NUM_OPTIONS = 4;
    /*
 * ***********ALGORITHM TO FILL SACK************
 * 1. start
 * 2. while sum<totalMarks && sack is not empty do
 * 2.1.    index = random(0, sizeOf(questionBank) - 1)
 * 2.2.    if(questionBank[index].marks+sum <= totalMarks)
 * 2.2.1.      add questionBank[index] to sack
 * 2.3      else if(abs(questionBank[index].marks+sum - totalMarks) = 1)
 * 2.3.1.      add quesionBank[index] to sack with modified marks
 * 2.4.    remove questionBank[index] from questionBank  */
    private static function fillSack($questionBank,$totalMarks,&$marks,&$sack)
    {
        while($marks < $totalMarks && count($questionBank) != 0){
            $index = rand(0,count($questionBank)-1);
            //echo "<br><br> count = ".count($questionBank)." <br><br>";
            if(($marks + $questionBank[$index][1]) <= $totalMarks ){
                $sack[] = new Question($questionBank[$index][0]);
                $marks+=$questionBank[$index][1];
            }
            else if( abs($totalMarks - ($marks + $questionBank[$index][1])) == 1 ){
                $q = new Question($questionBank[$index][0]);
                $q->setMarks($totalMarks - $marks);
                $sack[] = $q;
                $marks+=$q->getQuestionMarks();
            }
            array_splice($questionBank,$index,1);
        }
    }
    /*runs a specific query to fetch questions */
    private static function getQuestionBank($query)
    {
        $crud = Crud::getInstance(self::SERVER,self::USERNAME,self::PASSWORD,self::DATABASE);
        $result = $crud->executeQuery($query);
        $questionBank = mysqli_fetch_all($result);
        return $questionBank;
    }

    /*queries all the questions with probability less than 0.5 and not answered by he user */
    protected static function fillWithLeastAskedQuestions($userId,$totalMarks,$chapters,&$marks,&$sack)
    {

        $query = "SELECT question.question_id,question.marks,
            (test_count/(SELECT count(*) from test where test_id IN 
            (SELECT test_id from attempted_questions,question,chapter where 
            attempted_questions.question_id = question.question_id AND 
            question.chapter_id = chapter.chapter_id AND question.chapter_id IN ($chapters)))) as 
            probability from question where probability < 0.5 AND question.chapter_id IN ($chapters) AND 
            question .question_id NOT IN (SELECT question_id from attempted_questions,test where 
            attempted_questions.test_id = test.test_id AND test.user_id = $userId)";
        $questionBank = self::getQuestionBank($query);
        self::fillSack($questionBank,$totalMarks,$marks,$sack);
    }
    /*queries all the questions with probability >= 0.5 and not answered by he user */
    protected static function fillWithFrequentlyAskedQuestions($userId,$totalMarks,$chapters,&$marks,&$sack)
    {
        $query = "SELECT question.question_id,question.marks,
            (test_count/(SELECT count(*) from test where test_id IN 
            (SELECT test_id from attempted_questions,question,chapter where 
            attempted_questions.question_id = question.question_id AND 
            question.chapter_id = chapter.chapter_id AND question.chapter_id IN ($chapters)))) as 
            probability from question where probability >= 0.5 AND question.chapter_id IN ($chapters) AND 
            question .question_id NOT IN (SELECT question_id from attempted_questions,test where 
            attempted_questions.test_id = test.test_id AND test.user_id = $userId)";
        $questionBank = self::getQuestionBank($query);
        self::fillSack($questionBank,$totalMarks,$marks,$sack);
    }
    /*queries all the questions that are not present in the sack*/
    protected static function fillWithRemainingQuestions($userId,$totalMarks,$chapters,&$marks,&$sack)
    {
    $query = "";
    $questions = "";
        if(count($sack) >0 ){
            foreach ($sack as $q){
                $questions.="".$q->getQuestionID().",";
            }
            $questions = substr($questions,0,-1);
            $query = "SELECT question.question_id,question.marks from question where question.chapter_id IN ($chapters) AND
            question.question_id NOT IN ($questions)";
        }
        else{
            $query = "SELECT question.question_id,question.marks from question where question.chapter_id IN ($chapters)";
        }

        $questionBank = self::getQuestionBank($query);
        //echo "<br><br> count before = ".count($questionBank)." <br><br>";
        self::fillSack($questionBank,$totalMarks,$marks,$sack);
    }
    /*returns true if total marks = marks*/
    protected static function isSackFull($totalMarks,$marks)
    {
        if($marks == $totalMarks){
            return true;
        }
        return false;
    }
    /*takes in user id , chapter list and total marks and adds the questions inside the sack*/
    public static function fetchQuestionsForTest($userId,array $chapterIds,&$totalMarks,array &$sack)
    {
        $chapters = "";
        foreach ($chapterIds as $c){
            $chapters.="$c,";
        }
        $chapters = substr($chapters,0,-1);
        $marks = 0;
        $sack = array();
        self::fillWithLeastAskedQuestions($userId,$totalMarks,$chapters,$marks,$sack);
        if(!self::isSackFull($totalMarks,$marks)){
            //the sack was not filled by the above questionBank
            self::fillWithFrequentlyAskedQuestions($userId,$totalMarks,$chapters,$marks,$sack);
        }
        if(!self::isSackFull($totalMarks,$marks)){
            self::fillWithRemainingQuestions($userId,$totalMarks,$chapters,$marks,$sack);
        }
        if(!self::isSackFull($totalMarks,$marks)){
            //there are no more questions left
            $totalMarks = $marks;
        }
    }

    /*takes input as user id , total marks , chapters list and test duration */
    public static function generateTest($userId,$totalMarks,array $chapterIds,$minutes)
    {
        $sack = array();
        self::fetchQuestionsForTest($userId,$chapterIds,$totalMarks,$sack);
        /*$sack[] = new Question(44127);
        $sack[] = new Question(36701);
        $sack[] = new Question(29361);
        $sack[] = new Question(2);
        $totalMarks = 10;*/
        /*$testGenerator = new TestGenerator();
        $testGenerator->sack = $sack;
        $testGenerator->totalMarks = $totalMarks;*/
//        echo "<br> marks = $totalMarks<br>";
        $crud = Crud::getInstance(self::SERVER,self::USERNAME,self::PASSWORD,self::DATABASE);
        $startTimeStamp = strtotime($crud->getDateTime());
        $endTimeStamp = $startTimeStamp+($minutes*60);
        $startTime = date("Y-m-d H:i:s",$startTimeStamp);
        $endTime = date("Y-m-d H:i:s",$endTimeStamp);
        $columns = array("test_title","start_date","end_date","user_id","created_at","updated_at");
        $values = array("Test Host","".$startTime,"".$endTime,$userId,"".$startTime,"".$startTime);
        /*echo "<br>columns: = ";
        var_dump($columns);
        echo "<br>values: = ";
        var_dump($values);*/
        $crud->insert("test",$columns,$values);
        $testId = $crud->getLastInsertedID();
        //$testId = 1004;
        $columns = array("question_id","asked_for_marks","test_id","created_at","updated_at");
//        now the sack is full
        $testObj = new Test($testId);
        $json = "{";
        $json.="\"test_id\":".$testObj->getTestId();
        $json.=",\"test_title\":\"".$testObj->getTestTitle()."\"";
        $json.=",\"test_marks\":".$totalMarks;
        $json.=",\"questions\":[";
        $i = 0;
        foreach ($sack as $q){
            $i++;
            $timeStamp = $crud->getDateTime();
            $values = array($q->getQuestionID(),$q->getQuestionMarks(),$testId,$timeStamp,$timeStamp);
            $crud->insert("attempted_questions",$columns,$values);
            $json .=self::getQuestionJson($q).",";
        }
        $json = substr($json,0,-1);
        $json.="]";
        $json.="}";
        //echo "<br><br>$json";
        return $json;
    }
    /*returns a json format of the question*/
    protected static function getQuestionJson($q)
    {
        switch ($q->getQuestionType()){
            case Question::TYPE_MCQ:
                return self::getMcqJson($q);
            case Question::TYPE_FIB:
                return self::getFibJson($q);
            case Question::TYPE_MTF:
                return self::getMTfJson($q);
        }
    }
    /*returns json of the passed FIB
    FORMAT:
    {
		"question": {
			"question_id": 36701,
			"question_level": 1,
			"question_statement": {
				"major_stmt": "Fill in the blanks with proper articles",
				"question_stmt": [{
					"text": "%blank% dog came running towards Cynthia. She got scared looking at %blank% dog",
					"text_image": ""
				}]
			},
			"question_marks": 1,
			"question_type": 2
		},
		"options": []
	}
    */
    protected static function getFibJson($q)
    {
//        echo "<br> FIB was called ";
        $json="{";
        $temp = $q->getJson();
        $temp = substr($temp, 1);
        $temp = substr($temp,0,-1);
        $json.=$temp;
        $json.=",\"options\":[";
        $json.="]";
        $json.="}";
        return $json;
    }
    /*returns json format of passed question
    FORMAT:
    {
		"question": {
			"question_id": 29361,
			"question_level": 2,
			"question_statement": {
				"major_stmt": "Match the following",
				"question_stmt": [{
					"sub_id": "1",
					"text": "sub-Question 1",
					"text_image": ""
				}, {
					"sub_id": "4",
					"text": "sub-Question 4",
					"text_image": ""
				}, {
					"sub_id": "2",
					"text": "sub-Question 2",
					"text_image": ""
				}, {
					"sub_id": "3",
					"text": "sub-Question 3",
					"text_image": ""
				}]
			},
			"question_marks": 2,
			"question_type": 3
		},
		"options": [{
			"option_id": 29363,
			"option_statement": {
				"sub_id": "3",
				"options_url": "",
				"options_text": "option 3"
			}
		}, {
			"option_id": 29361,
			"option_statement": {
				"sub_id": "1",
				"options_url": "",
				"options_text": "option 1"
			}
		}, {
			"option_id": 29362,
			"option_statement": {
				"sub_id": "2",
				"options_url": "",
				"options_text": "option 2"
			}
		}, {
			"option_id": 29364,
			"option_statement": {
				"sub_id": "4",
				"options_url": "",
				"options_text": "option 4"
			}
		}]
	}
    */
    protected static function getMTfJson($q)
    {
//        echo "<br> MTF was called ";
        $string = $q->getQuestionStatement();
        $obj = json_decode($string);
        $arr =  $obj->question_stmt;
        $upperBound = count($arr) - 1;
        $lb = 0;
        $ub = $upperBound;
        $questions = array();
        for($i = 0;$i<=$upperBound;$i++){
            $index = rand($lb,$ub);
            $questions[] = $arr[$index];
            array_splice($arr,$index,1);
            $ub--;
        }
        $options = $q->getOptions();
        //jumbling the options
        $randomizedOptions = array();
        $lb = 0;
        $ub = count($options)-1;
        $upperBound = $ub;
        for($i = 0;$i<=$upperBound;$i++){
            $index = rand($lb,$ub);
            $randomizedOptions[] = $options[$index];
            array_splice($options,$index,1);
            $ub--;
        }
        $questionStatement = "{";
        $questionStatement.="\"major_stmt\":";
        $questionStatement.="\"".$obj->major_stmt."\"";
        $questionStatement.=",\"question_stmt\":[";
        foreach ($questions as $question){
            $questionStatement.=json_encode($question).",";
        }
        $questionStatement = substr($questionStatement,0,-1);
        $questionStatement.="]";
        $questionStatement.="}";
        $q->setStatement($questionStatement);
        $json = "{";
        $temp = $q->getJson();
        $temp = substr($temp, 1);
        $temp = substr($temp,0,-1);
        $json.=$temp;
        $json.=",\"options\":[";
        foreach ($randomizedOptions as $option){
            $json.=$option->getJson().",";
        }
        $json = substr($json,0,-1);
        $json.="]";
        $json.="}";
        return $json;
    }
    /*returns json format of MCQ
    FORMAT:
    {
		"question": {
			"question_id": 44127,
			"question_level": 1,
			"question_statement": "Ststement57",
			"question_marks": 2,
			"question_type": 1
		},
		"options": [{
			"option_id": 74296,
			"option_statement": {
				"options_url": "",
				"options_text": "this"
			}
		}, {
			"option_id": 74298,
			"option_statement": {
				"options_url": "",
				"options_text": "this"
			}
		}, {
			"option_id": 74297,
			"option_statement": {
				"options_url": "",
				"options_text": "this"
			}
		}, {
			"option_id": 74300,
			"option_statement": {
				"options_url": "",
				"options_text": "this"
			}
		}]
	}
    */
    protected static function getMcqJson($q)
    {
//        echo "<br> MCQ was called question id = ".$q->getQuestionID();
        //mcq jumbling
        $options =  $q->getOptions();
        $lowerBound = 0;
        $size = count($options);
        $upperBound = $size - 1;
        $answerIndex = $size>=self::MAX_NUM_OPTIONS?rand(0,self::MAX_NUM_OPTIONS-1):rand(0,$upperBound);
        $finalizedOptions = array();
        $optionSackSize = $size + 1;
        for($i = 0;$i<$optionSackSize && $i<self::MAX_NUM_OPTIONS;$i++ ){
            if($i == $answerIndex){
                //place answer at $i
                $finalizedOptions[] = $q->getAnswer();
                continue;
            }
            $index = rand($lowerBound,$upperBound);
            $finalizedOptions[] = $options[$index];
            array_splice($options,$index,1);
            $upperBound--;
        }
        $json="{";
        $temp = $q->getJson();
        $temp = substr($temp, 1);
        $temp = substr($temp,0,-1);
        $json.=$temp;
        //substr($json,0,-1);
        $json.=",\"options\":[";
        foreach ($finalizedOptions as $o){
            $json.=$o->getJson().",";
        }
        $json = substr($json,0,-1);
        $json.="]";
        $json.="}";
        return $json;
    }
}
?>
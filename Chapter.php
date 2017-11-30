<?php
require_once ("Crud.php");
require_once ("DatabaseConstants.php");
class Chapter implements DatabaseConstants
{
    private $crud;
    private $chapterWeightage;
    private $chapterName;
    private $chapterID;
    private $questions;
    function __construct($chapterID)
    {
        $this->crud = Crud::getInstance(self::SERVER,self::USERNAME,self::PASSWORD,self::DATABASE);
        $this->chapterID = $chapterID;
        $this->fetchChapterDetails();
    }
    private function fetchChapterDetails()//get chapter details like its name and weightage
    {
        $columns = array('chapter_id','name','weightage');
        $result = $this->crud->getData($this->chapterID,"chapter",$columns,"chapter_id");
        $this->chapterName = $result[0]['name'];
        $this->chapterWeightage = $result[0]['weightage'];
        $this->fetchQuestions();
    }
    private function fetchQuestions()//fetch questions for the given chapter
    {
        $columns = array('question_id','level','statement','marks','probability','image_count','type','answer_ID');
        $result = $this->crud->getData($this->chapterID,"question",$columns,"chapter_id");
        $this->questions = array();
        for($i=0;$i<count($result);$i++)//Insert into array of Question Objects
        {
            $this->questions[] = new Question($this->crud,$result[$i]['question_id']);
        }
    }
    function getChapterWeightage()//return chapter weightage
    {
        return $this->chapterWeightage;
    }
    function getChapterName()//return chapter name
    {
        return $this->chapterName;
    }
    function getChapterID()//return chapterID
    {
        return $this->chapterID;
    }
    function getQuestions()//return array of question objects
    {
        return $this->questions;
    }
    function getQuestionIDs()//return array of questionIDs
    {
        $questionID = array();
        for($i=0;$i<count($this->questions);$i++)
        {
            $question = $this->questions[$i];
            $questionID[] = $question->getQuestionID();
        }
        return $questionID;
    }
}
?>
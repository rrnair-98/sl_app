<?php
require_once ("Crud.php");
require_once ("DatabaseConstants.php");
class Chapter implements DatabaseConstants
{
    private $crud;
    /*holds chapter wiehgtage in float*/
    private $chapterWeightage;
    /*holds teh chapter name*/
    private $chapterName;
    /*holds uniquely generated id for chapter*/
    private $chapterID;
    /*holds a list of all the questions ID this chapter contains*/
    private $questions;
    function __construct($chapterID)
    {
        $this->crud = Crud::getInstance(self::SERVER,self::USERNAME,self::PASSWORD,self::DATABASE);
        $this->chapterID = $chapterID;
        $columns = array('chapter_id','name','weightage');
        $result = $this->crud->getData($this->chapterID,"chapter",$columns,"chapter_id");
        $this->chapterName = $result[0]['name'];
        $this->chapterWeightage = $result[0]['weightage'];
    }
    /*fetch questions for the given chapter*/
    public function fetchQuestions()
    {
        $columns = array('question_id');
        $result = $this->crud->getData($this->chapterID,"question",$columns,"chapter_id");
        $this->questions = array();
        for($i=0;$i<count($result);$i++)//Insert into array of Question Objects
        {
            $this->questions[] = $result[$i]['question_id'];
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
    public function getJson(){
        $string = "{";
        $string.="\"chapter_id\":".$this->chapterID;
        $string.=",\"chapter_name:\":\"".$this->chapterName."\"";
        $string.=",\"chapter_weightage:\":".$this->chapterWeightage;
        $string.="}";
        return $string;
    }

}
?>
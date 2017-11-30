<?php
require_once ("Crud.php");
require_once ("DatabaseConstants.php");
class Subject implements DatabaseConstants//class for a single subject
{
    private $crud;
    private $subjectID;
    private $subjectName;
    private $semesterID;
    private $chapters;
    function __construct($subjectID)
    {
        $this->crud = Crud::getInstance(self::SERVER,self::USERNAME,self::PASSWORD,self::DATABASE);
        $this->subjectID = $subjectID;
        $this->fetchSubjectDetails();
    }
    private function fetchSubjectDetails()//fetch all chapters and semester to which subject belongs
    {
        $columns = array('name','semester_id');
        $result = $this->crud->getData($this->subjectID,"subject",$columns,"subject_id");
        $this->subjectName = $result[0]['name'];
        $this->semesterID = $result[0]['semester_id'];
        $columns = array('chapter_id','name','weightage');
        $result = $this->crud->getData($this->subjectID,"chapter",$columns,"subject_id");
        $this->chapters = array();
        for($i=0;$i<count($result);$i++)//Insert into array of Chapter Objects
        {
            $this->chapters[] = new Chapter($this->crud,$result[$i]['chapter_id']);
        }
    }
    function getSubjectID()//Return SubjectID
    {
        return $this->subjectID;
    }
    function getSubjectName()//Return subject Name
    {
        return $this->subjectName;
    }
    function getSubjectSemesterID()//Return semesterID of subject
    {
        return $this->semesterID;
    }
    function getChapters()//Return array of Chapter Object
    {
        return $this->chapters;
    }
    function getChapterIDs()//Return array of chapter IDs
    {
        $chapterID = array();
        for($i=0;$i<count($this->chapters);$i++)
        {
            $chapterID[] =  $this->chapters[$i]->getChapterID();
        }
        return $chapterID;
    }
    function getChapterNames()//Return array of chapter names
    {
        $chapternames = array();
        for($i=0;$i<count($this->chapters);$i++)
        {
            $chapternames[] =  $this->chapters[$i]->getChapterName();
        }
        return $chapternames;
    }
}
?>
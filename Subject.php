<?php
require_once ("Crud.php");
require_once ("DatabaseConstants.php");
include_once ('Chapter.php');
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
        $columns = array('name','semester_id');
        $result = $this->crud->getData($this->subjectID,"subject",$columns,"subject_id");

        $this->subjectName = $result[0]['name'];
        $this->semesterID = $result[0]['semester_id'];
        $this->fetchChapters();
    }
    private function fetchChapters()//fetch all chapters and semester to which subject belongs
    {
        $columns = array('chapter_id');
        $result = $this->crud->getData($this->subjectID,"chapter",$columns,"subject_id");
        $this->chapters = array();

        for($i=0;$i<count($result);$i++)//Insert into array of Chapter Objects
        {
            $this->chapters[] = new Chapter($result[$i]['chapter_id']);
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
    public function getJson(){
        $string = "{";
        $string.="\"subject_id\":".$this->subjectID;
        $string.=",\"subject_name\":\"".$this->subjectName."\"";
        $string.="}";
        return $string;
    }
}
?>
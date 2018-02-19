<?php
require_once ("Crud.php");
require_once ("DatabaseConstants.php");
class StudentSubject implements DatabaseConstants//Linking of subjects the student has enrolled in
{
    private $crud;
    private $studentID;
    private $subjects;
    function __construct($studentID)
    {
        $this->crud = Crud::getInstance(self::SERVER,self::USERNAME,self::PASSWORD,self::DATABASE);
        $this->studentID = $studentID;
        $this->getStudentSubjects();
    }
    private function getStudentSubjects()//get all enrolled subjects of student
    {
        $columns = array('subject_id');
        $subjectIDs = $this->crud->getData($this->studentID,"enrolls",$columns,"user_id");
        $columns = array('subject_id','name');
        $result = array();
        for($i=0;$i<count($subjectIDs);$i++)
        {
            $result[] = $this->crud->getData($subjectIDs[$i]['subject_id'],"subject",$columns,"subject_id");
        }
        $this->subjects = array();
        for($i=0;$i<count($result);$i++)//loop to create a Subject object for each subject
        {
            $temp = $result[$i][0];
            $this->subjects[] = new Subject($this->crud,$temp['subject_id']);//add new Subject object to array of subjects
        }
    }
    function getSubjects()//returns array of subject objects
    {
        return $this->subjects;
    }
    function getSubjectIDs()//return array of subject IDs
    {
        $subID = array();
        for($i=0;$i<count($this->subjects);$i++)
        {
            $subID[] = $this->subjects[$i]->getSubjectID();
        }
        return $subID;
    }
    function getSubjectNames()//Return array of subject names
    {
        $subNames = array();
        for($i=0;$i<count($this->subjects);$i++)
        {
            $subNames[] = $this->subjects[$i]->getSubjectName();
        }
        return $subNames;
    }
}
?>
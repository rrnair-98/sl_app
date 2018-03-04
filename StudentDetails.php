<?php
include_once('Crud.php');
include_once("DatabaseConstants.php");
include_once ('Branch.php');
include_once ('Semester.php');
class StudentDetails implements DatabaseConstants// Holds the detail of student like its userID branch semester email name
{
    private $crud;
    private $studentID;
    private $branch;
    private $semester;
    private $email;
    private $name;
    function __construct($email)
    {
        $this->crud = Crud::getInstance(self::SERVER,self::USERNAME,self::PASSWORD,self::DATABASE);
        $this->email = $email;
        $this->getStudentDetails();
    }
    private function getStudentDetails() // Pass the student id to get student's branch and semester from database returns Json Object
    {
        $columns = array('name','user_id');
        $result = $this->crud->getData($this->email,"user",$columns,"email");
        $this->name = $result[0]['name'];
        $this->studentID = $result[0]['user_id'];
        $columns = array('branch_id','branch_name','semester_id','semester_name');
        $result = $this->crud->getData($this->studentID,"student_sem_branch_mapping",$columns,"user_id");
        $this->branch = new Branch($result[0]['branch_id'],$result[0]['branch_name']);
        $this->semester = new Semester($result[0]['semester_id'],$result[0]['semester_name']);

    }
    function getStudentPersonalDetails()// Returns result set with name and email of student
    {
        return array("name"=>$this->name,"email"=>$this->email);
    }
    function getStudentName()//Returns name of Student
    {
        return $this->name;
    }
    function getStudentEmail()//Returns Student's Email
    {
        return $this->email;
    }
    function getStudentBranch()//Returns Branch object
    {
        return $this->branch;
    }
    function getStudentSemester()//Returns Semester object
    {
        return $this->semester;
    }
    function getStudentID()//Return's student's ID
    {
        return $this->studentID;
    }
}
?>
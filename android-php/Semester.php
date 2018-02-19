<?php
require_once ("Crud.php");
require_once ("DatabaseConstants.php");
class Semester implements DatabaseConstants
{
    private $crud;
    private $semester_id;
    private $semester_name;
    function __construct($semester_id,$semester_name)
    {
        $this->crud = Crud::getInstance(self::SERVER,self::USERNAME,self::PASSWORD,self::DATABASE);
        $this->semester_id = $semester_id;
        $this->semester_name = $semester_name;
    }
    function getSemesterID()
    {
        return $this->semester_id;
    }
    function getSemesterName()
    {
        return $this->semester_name;
    }
}
?>
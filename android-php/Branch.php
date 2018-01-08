<?php
require_once ("Crud.php");
require_once ("DatabaseConstants.php");
class Branch implements DatabaseConstants
{
    private $crud;
    private $branchId;
    private $branchName;
    private $semesters;
    function __construct($branch_id,$branch_name)
    {
        $this->crud = Crud::getInstance(self::SERVER,self::USERNAME,self::PASSWORD,self::DATABASE);
        $this->branchId = $branch_id;
        $this->branchName = $branch_name;
    }
    function getBranchId()
    {
        return $this->branchId;
    }
    function getBranchName()
    {
        return $this->branchName;
    }
}
?>
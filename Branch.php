<?php
require_once ("Crud.php");
require_once ("DatabaseConstants.php");
class Branch implements DatabaseConstants
{
    private $crud;
    private $branch_id;
    private $branch_name;
    function __construct($branch_id,$branch_name)
    {
        $this->crud = Crud::getInstance(self::SERVER,self::USERNAME,self::PASSWORD,self::DATABASE);
        $this->branch_id = $branch_id;
        $this->branch_name = $branch_name;
    }
    function getBranchID()
    {
        return $this->branch_id;
    }
    function getBranchName()
    {
        return $this->branch_name;
    }
}
?>
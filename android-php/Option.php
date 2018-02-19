<?php
require_once ("Crud.php");
require_once ("DatabaseConstants.php");
class Option implements DatabaseConstants//Class for an object
{
    private $crud;
    private $optionID;
    private $statement;
    private $image_count;
    function __construct($optionID)
    {
        $this->crud = Crud::getInstance(self::SERVER,self::USERNAME,self::PASSWORD,self::DATABASE);
        $this->optionID = $optionID;
        $this->fetchOptionDetails();
    }
    private function fetchOptionDetails()
    {
        $columns = array('option_id','statement','image_count');
        $result = $this->crud->getData($this->optionID,"options",$columns,"option_id");
        $this->statement = $result[0]['statement'];
        $this->image_count = $result[0]['image_count'];
    }
    function getOptionID()
    {
        return $this->optionID;
    }
    function getOptionImageCount()
    {
        return $this->image_count;
    }
    function getOptionStatement()
    {
        return $this->statement;
    }

    public function getJson()
    {
        $string = "{";
        $string.="\"option_id\":".$this->optionID;
        $string.=",\"option_statement\":".$this->statement;
        $string.="}";
        return $string;
    }

}
?>
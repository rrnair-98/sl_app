<?php
require_once ("Crud.php");
require_once ("DatabaseConstants.php");
class Test implements DatabaseConstants {
    private $crud;
    private $testId;
    private $startDate;
    private $endDate;
    private $childOf;/*another test id reference */
    private $adminId;
    private $userId;
    private $testAnswerSheet;/*reference ot a test answer sheet*/
    public function  __construct($testId=NULL){
        $this->crud = Crud::getInstance(self::SERVER,self::USERNAME,self::PASSWORD,self::DATABASE);
        $this->testId = $testId;
        if($testId != NULL){
            $this->fetchTestDetails();
        }
    }
    final public function fetchTestDetails(){
        $columns = array("*");
        $result = $this->crud->getData($this->testId,"test",$columns,"test_id");
        $row = $result[0];
        $this->startDate = $row["start_date"];
        $this->endDate = $row["end_date"];
        $this->child_of = $row["child_of"];
        $this->adminId = $row["admin_id"];
        $this->userId = $row["user_id"];
        $this->testAnswerSheet = new TestAnswerSheet($this->crud,$this->testId);
    }

    /**
     * @param mixed $crud
     */
    public function setCrud($crud)
    {
        $this->crud = $crud;
    }

    /**
     * @param mixed $testId
     */
    public function setTestId($testId)
    {
        $this->testId = $testId;
    }

    /**
     * @return mixed
     */
    public function getTestId()
    {
        return $this->testId;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @return mixed
     */
    public function getChildOf()
    {
        return $this->childOf;
    }

    /**
     * @return mixed
     */
    public function getAdminId()
    {
        return $this->adminId;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return mixed
     */
    public function getTestAnswerSheet()
    {
        return $this->testAnswerSheet;
    }

    /**
     * @returns midex
     */
    public static function getTestIds($userId){
        $crud = Crud::getInstance(self::SERVER,self::USERNAME,self::PASSWORD,self::DATABASE);
        $result = $crud->getData($userId,"test",array ("test_id"),"user_id");
        $tests = array();
        foreach($result as $item){
            $tests[]=$item["test_id"];
            //array_push($tests,$item["test_id"]);
        }
        return $tests;
    }

}
?>
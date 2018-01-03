<?php
require_once ("Crud.php");
require_once ("DatabaseConstants.php");
require_once ("Chapter.php");
require_once ("Subject.php");
class Test implements DatabaseConstants {
    /*reference to the crud class */
    private $crud;
    /*the unique test id surrogate key*/
    private $testId;
    /*start date time of test*/
    private $startDate;
    /*end date time of test*/
    private $endDate;
    /*another test id reference */
    private $childOf;
    /*ID of the admin who initiated the test if any*/
    private $adminId;
    /*string title of the test*/
    private $testTitle;
    /*id of the user who took this test if any*/
    private $userId;
    //private $testAnswerSheet;/*reference to a test answer sheet*/
    /*List of all the chapters that are included in this test*/
    private $testChapters;
    /*List of all the subjects that are included in this test*/
    private $testSubjects;

    public function  __construct($testId=NULL){
        $this->crud = Crud::getInstance(self::SERVER,self::USERNAME,self::PASSWORD,self::DATABASE);
        $this->testId = $testId;
        if($testId != NULL){
            $this->fetchTestDetails();
        }
    }
    /*fetched test details and stores in instance variable*/
    final public function fetchTestDetails(){
        $columns = array("*");
        $result = $this->crud->getData($this->testId,"test",$columns,"test_id");
        $row = $result[0];
        $this->startDate = $row["start_date"];
        $this->endDate = $row["end_date"];
        $this->childOf = $row["child_of"];
        $this->adminId = $row["admin_id"];
        $this->testTitle = $row["test_title"];
        $this->userId = $row["user_id"];
        $columns = array("question_id");
        $result = $this->crud->getData($this->testId,"attempted_questions",$columns,"test_id");
        foreach ($result as $row){
            $chapterId = $this->crud->getData($row["question_id"],"question",
                array("chapter_id"),"question_id");
            $this->testChapters[] = new Chapter($chapterId[0]['chapter_id']);
            $subjectId = $this->crud->getData($chapterId[0]['chapter_id'],"chapter",array("subject_id"),"chapter_id");
            $this->testSubjects[] = new Subject($subjectId[0]['subject_id']);
        }
    }

    /**
     * @param mixed $testId
     */
    /*sets a new id to the test and fetches new details for the object's instance variable*/
    public function setTestId($testId)
    {
        $this->testId = $testId;
        $this->fetchTestDetails();
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
    /*public function getTestAnswerSheet()
    {
        return $this->testAnswerSheet;
    }*/

    /**
     * returns a list of test ids that the user has already given
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

    /**
     * @return mixed
     */
    public function getTestTitle()
    {
        return $this->testTitle;
    }

    /**
     * @return mixed
     */
    public function getTestChapters()
    {
        return $this->testChapters;
    }

    /**
     * @return mixed
     */
    public function getTestSubjects()
    {
        return $this->testSubjects;
    }
}
?>
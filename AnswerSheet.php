<?php
require_once ("Crud.php");
require_once ("DatabaseConstants.php");
require_once("AnsweredQuestion.php");
class AnswerSheet implements DatabaseConstants {
    /*crud reference*/
    private /*Crud */ $crud;
    /*This contains an array of all the AnsweredQuestion object */
    private  /*AnsweredQuestion[]*/$answeredQuestions;
    /*test id to which this answer sheet belongs to */
    private /*long */ $testId;

    public function __construct($testId){
        $this->testId = $testId;
        $this->crud = Crud::getInstance(self::SERVER,self::USERNAME,self::PASSWORD,
            self::DATABASE);
        $this->fetchAnswerSheetDetails();

    }
    private final function fetchAnswerSheetDetails(){
        $result = $this->crud->getData($this->testId,"answer_sheet",array("answer_sheet_id"), "test_id");
        foreach ($result as $row ){
            $this->answeredQuestions[] = new AnsweredQuestion($row['answer_sheet_id']);
        }
    }

    public function getAnsweredQuestions(){
        return $this->answeredQuestions;
    }

}
?>
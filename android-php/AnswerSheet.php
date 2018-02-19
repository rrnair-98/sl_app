<?php
require_once ("Crud.php");
require_once ("DatabaseConstants.php");
require_once ("AnsweredQuestion.php");
require_once ("Test.php");
class AnswerSheet implements DatabaseConstants {
    /*crud reference*/
    private /*Crud */ $crud;
    /*This contains an array of all the AnsweredQuestion object */
    private  /*AnsweredQuestion[]*/$answeredQuestions;
    /*test id to which this answer sheet belongs to */
    private /*long */ $testId;
    /*Test object */
    private /*Test*/ $test;
    /*Total marks scored by the student*/
    private /*long */ $marksScored = 0;
    /*maximum marks that can be stored in test */
    private /*long*/ $totalMarks = 0;
    /*total number of questions in test*/
    private /*long*/ $totalQuestions = 0;
    /*number of questions answered correctly*/
    private /*long*/ $totalCorrectlyAnsweredQuestions = 0;

    /**
     * return total questions
     */
    public function getTotalQuestions()
    {
        return $this->totalQuestions;
    }

    /**
     * return total number of correctly answered questions
     */
    public function getTotalCorrectlyAnsweredQuestions()
    {
        return $this->totalCorrectlyAnsweredQuestions;
    }
    public function __construct($testId){
        $this->testId = $testId;
        $this->crud = Crud::getInstance(self::SERVER,self::USERNAME,self::PASSWORD,
            self::DATABASE);
        $this->fetchAnswerSheetDetails();

    }
    /*fetches and populates this object*/
    private final function fetchAnswerSheetDetails(){
        $result = $this->crud->getData($this->testId,"answer_sheet",array("answer_sheet_id"), "test_id");
        foreach ($result as $row ){
            $tempAnsweredQuestion = new AnsweredQuestion($row['answer_sheet_id']);
            $this->answeredQuestions[] =$tempAnsweredQuestion;
            if($tempAnsweredQuestion->isCorrect()){
                $this->marksScored+=$tempAnsweredQuestion->getQuestion()->getQuestionMarks();
                $this->totalCorrectlyAnsweredQuestions++;
            }
            $this->totalMarks +=$tempAnsweredQuestion->getQuestion()->getQuestionMarks();
            $this->totalQuestions = count($this->answeredQuestions);
        }
        $this->test = new Test($this->testId);
    }

    /**
     * returns Test Id
     */
    public function getTestId()
    {
        return $this->testId;
    }

    /**
     * @return test object
     */
    public function getTest()
    {
        return $this->test;
    }


    /**
     * return int test marks scored by the individual
     */
    public function getMarksScored()
    {
        return $this->marksScored;
    }

    /**
     * returns total marks of the test
     */
    public function getTotalMarks()
    {
        return $this->totalMarks;
    }


    /*returns an array of answered questions */
    public function getAnsweredQuestions(){
        return $this->answeredQuestions;
    }

    /*returns json of this answer sheet containing all the information for rendering an entire test answer sheet*/
    public function getJson(){
        $string = "{";
        $string.="\"test_id\":".$this->testId;
        $string.=",\"chapters\":[";
        foreach ($this->test->getTestChapters() as $chapter){
            $string.="".$chapter->getJson().",";
        }
        $string = substr($string,0,-1);
        $string.="]";
        $string.=",\"subjects\":[";
        foreach ($this->test->getTestSubjects() as $subject){
            $string.="".$subject->getJson().",";
        }
        $string = substr($string,0,-1);
        $string.="]";
        $string.=",\"total_marks\":".$this->totalMarks;
        $string.=",\"marks_scored\":".$this->marksScored;
        $string.=",\"total_questions\":".$this->totalQuestions;
        $string.=",\"questions_answered\":".$this->getTotalCorrectlyAnsweredQuestions();
        $string.=",\"answers\":[";
        foreach ($this->answeredQuestions as $answeredQuestion) {
            $temp=$answeredQuestion->getJson().",";
            $string.=$temp;
        }
        $string = substr($string,0,-1);
        $string.="]}";
        return $string;
    }
}
?>
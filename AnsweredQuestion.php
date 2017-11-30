<?php
require_once ("Crud.php");
require_once ("DatabaseConstants.php");
require_once ("Question.php");
require_once ("Option.php");
class AnsweredQuestion implements DatabaseConstants
{
    private $crud;
    /*the unique id for the answer sheet */
    private /*long */ $answerSheetId;
    /*reference to the question object to which this answer belongs to*/
    private /*Question */$question;
    /*Reference to the selected option for this question*/
    private /* Option */$selected_option;
    /*Reference to the correct option*/
    private /* Option */ $answer;
    function __construct($answer_sheet_id)
    {
        $this->answerSheetId = $answer_sheet_id;
        $this->crud = Crud::getInstance(self::SERVER,self::USERNAME,self::PASSWORD,self::DATABASE);
        $this->fetchAnsweredQuestionDetails();
    }
    private final function fetchAnsweredQuestionDetails()
    {
        $columns = array('answer_sheet_id','question_id','selected_option_id');
        $result = $this->crud->getData($this->answerSheetId,"answer_sheet",$columns,"answer_sheet_id");
        $this->question = new Question($result[0]['question_id']);
        $this->selected_option = new Option($result[0]['selected_option_id']);
        $this->answer = new Option($this->question->getAnswerID());
    }
    function getQuestion()
    {
        return $this->question;
    }
    function getSelectedOption()
    {
        return $this->selected_option;
    }
    function getAnswer()
    {
        return $this->answer;
    }

    /*returns true if the answer is correct*/
    function isCorrect(){
        if ($this->selected_option->getOptionID() == $this->answer->getOptionID()){
            return true;
        }
        return false;
    }

}
?>
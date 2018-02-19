<?php

require_once ("Crud.php");

require_once ("DatabaseConstants.php");

require_once ("Question.php");

require_once ("Option.php");

require_once ("MiscellaneousAnswer.php");

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

    /*Reference to miscellaneous answers */

    private /*MiscellaneousAnswer*/ $miscellaneousAnswer;

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

        if($result[0]['selected_option_id'] != 0){

            $this->selected_option = new Option($result[0]['selected_option_id']);

        }

        else{

            $this->miscellaneousAnswer = new MiscellaneousAnswer($this->answerSheetId);
            if($this->miscellaneousAnswer->getMiscellaneousAnswerSheetId() == null ){
                $this->miscellaneousAnswer  = null;
            }

        }

        $this->answer = $this->question->getAnswer();

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



    /**

     * returns answer stored in the miscellaneous answers  table in db

     */

    public function getMiscellaneousAnswer()

    {

        return $this->miscellaneousAnswer;

    }





    protected function removeSpaces($string){

        $string = str_replace(" ","",$string);

        $string = str_replace("\n","",$string);

        $string = str_replace("\t","",$string);

        $string = str_replace("\r","",$string);

        return $string;

    }

    protected function isMcqCorrect(){

        if($this->selected_option == null){
            return false;
        }
        if ($this->selected_option->getOptionID() == $this->answer->getOptionID()){

            return true;

        }

        return false;

    }



    protected function isFibCorrect(){

        if($this->miscellaneousAnswer == null){
            return false;
        }
        $tempAnswer = $this->answer->getOptionStatement();

        $tempSelection = $this->miscellaneousAnswer->getMiscellaneousStatement();

        $tempAnswer = $this->removeSpaces($tempAnswer);

        $tempSelection = $this->removeSpaces($tempSelection);

         if($tempAnswer == $tempSelection){return true;}

        return false;

    }



    protected function isMtfCorrect(){

        return $this->isFibCorrect();

    }

    /*returns true if the answer is correct*/

    function isCorrect(){

        $type = $this->question->getQuestionType();

        switch ($type){

            case 1:

                //it is MCQ

                return $this->isMcqCorrect();

                break;

            case 2:

                //it is FIB

                return $this->isFibCorrect();

                break;

            case 3:

                return $this->isMtfCorrect();

        }

        return false;

    }



    /**

     * returns answer sheet id

     */

    public function getAnswerSheetId()

    {

        return $this->answerSheetId;

    }



    public function getJson(){

        $string = "{";

        $string.="\"answer_sheet_id\":".$this->answerSheetId;

        $string.=",\"question_id\":".$this->question->getQuestionID();

        $string.=",\"question_statement\":".$this->question->getQuestionStatement()."";

        $string.=",\"marks\":".$this->question->getQuestionMarks();

        $string.=",\"type\":".$this->question->getQuestionType();

        $string.=",\"options\":[";

        $options = $this->question->getOptions();

        foreach ($options as $option){

            $string.=$option->getJson().",";

        }

        if($this->question->getQuestionType() == 1){

            $string.=$this->question->getAnswer()->getJson();

        }

        else if($this->question->getQuestionType() == 3){

            $string = substr($string,0,-1);

        }

        $string.="]";

        if($this->question->getQuestionType() == 1){

            if($this->selected_option == null){
                $string.=",\"selected_option\": null";
            }
            else{
                $string.=",\"selected_option\":".$this->selected_option->getJson();
            }
        

            $string.=",\"user_answered\":null";

        }

        else{

            $string.=",\"selected_option\":null";

            if($this->miscellaneousAnswer == null){
                $string.=",\"user_answered\":null";
            }
            else{
                $string.=",\"user_answered\":".$this->miscellaneousAnswer->getJson();
            }
        }

        $string.=",\"answer\":".$this->answer->getJson();

        if($this->isCorrect()){

            $string.=",\"is_correct\":true";

        }

        else{

            $string.=",\"is_correct\":false";

        }

        $string.=",\"has_forgotten\":null";

        $string.="}";

        return $string;

    }

}

?>
<?php
class QuestionData implements JsonSerializable //A custom implementation for json_encode to get question detail when question object is passed
{
    private $question;
    private $options;
    function __construct($question)
    {
        $this->question = $question;
    }
    public function jsonSerialize()
    {
        $JSONquestion_stmt = array();
        $question_statement = $this->question->getQuestionStatement(); //return question statement from question object
        $statementArray = json_decode($question_statement,true); //decode the question json into an assoc array
        $JSONoptions = array();
        $options = $this->question->getOptions();//get all the options for question
        for($i=0;$i<count($options);$i++) //loop to generate the options sub array with all options details
        {
            $option_statement = $options[$i]->getOptionStatement();
            $option_statementArray = json_decode($option_statement,true);//decode the json in object statement
            $JSONoptions[] = array("option_id"=>$options[$i]->getOptionID(),"options_url"=>$option_statementArray['options_url'],"options_text"=>$option_statementArray['options_text'],"sub_id"=>$option_statementArray['sub_id']);
        }
        return ["question_id"=>$this->question->getQuestionID(),"marks"=>$this->question->getQuestionMarks(),
            "type"=>$this->question->getQuestionType(),"major_stmt"=>$statementArray['major_stmt'],
            "question_stmt"=>$statementArray['question_stmt'],"options"=>$JSONoptions];
        //return the question detail in the required format
    }
}
?>
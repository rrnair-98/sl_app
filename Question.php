<?php
require_once ("Crud.php");
require_once ("DatabaseConstants.php");
class Question implements DatabaseConstants
{
    private $crud;
    private $questionID;
    private $level;
    private $questionProbability;
    private $marks;
    private $statement;
    private $image_count;
    private $type;
    private $answer_id;
    private $test_count;
    private $options;
    function __construct($questionID)
    {
        $this->crud = Crud::getInstance(self::SERVER,self::USERNAME,self::PASSWORD,self::DATABASE);
        $this->questionID = $questionID;
        $this->fetchQuestionDetails();
    }
    private  final function fetchQuestionDetails()
    {
        $columns = array('question_id', 'level', 'marks', 'probability', 'statement', 'image_count','test_count', 'type', 'answer_id');
        $result = $this->crud->getData($this->questionID, "question", $columns, "question_id");
        $this->level = $result[0]['level'];
        $this->questionProbability = $result[0]['probability'];
        $this->marks = $result[0]['marks'];
        $this->statement = $result[0]['statement'];
        $this->image_count = $result[0]['image_count'];
        $this->type = $result[0]['type'];
        $this->answer_id = $result[0]['answer_id'];
        $this->test_count = $result[0]['test_count'];
        $columns = array('option_id', 'statement', 'image_count');
        $result = $this->crud->getData($this->questionID, "options", $columns, "question_id");
        $this->options = array();
        for ($i = 0; $i < count($result); $i++) {
            if ($result[$i]['option_id'] == $this->answer_id)
                continue;
            $this->options[] = new Option($this->crud, $result[$i]['option_id']);
        }
        $this->fetchOptions();
    }
    private function fetchOptions()
    {
        $columns = array('option_id', 'statement', 'image_count');
        $result = $this->crud->getData($this->questionID, "options", $columns, "question_id");
        $this->options = array();
        for($i=0;$i<count($result);$i++)//Insert into array of Option Objects
        {
            $this->options[] = new Option($this->crud,$result[$i]['option_id']);
        }
    }
    function getQuestionID()
    {
        return $this->questionID;
    }
    function getQuestionLevel()
    {
        return $this->level;
    }
    function getQuestionProbability()
    {
        return $this->questionProbability;
    }
    function getQuestionType()
    {
        return $this->type;
    }
    function getAnswerID()
    {
        return $this->answer_id;
    }
    function getQuestionImageCount()
    {
        return $this->image_count;
    }
    function getQuestionStatement()
    {
        return $this->statement;
    }
    function getQuestionMarks()
    {
        return $this->marks;
    }
    function getOptions()//Return array of option objects
    {
        return $this->options;
    }
    function getOptionIDs()// return array of optionIDs
    {
        $optionID = array();
        for ($i = 0; $i < count($this->options); $i++) {
            $option = $this->options[$i];
            $optionID[] = $option->getOptionID();
        }
        return $optionID;
    }
}
?>
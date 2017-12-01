<?php
/**
 * Created by PhpStorm.
 * User: ADMIN-PC
 * Date: 29-11-2017
 * Time: 11:16
 */

include_once ('Layer2-Model.php');

class UploadQuestion
{
    private $crud;
    private $major_statement;
    private $type;
    private $marks;
    private $options;
    private $level;
    private $questionProbability;
    private $statement;
    private $image_count;
    private $test_count;

    private $chapter_id;
    function __construct($crud,$statement,$type,$marks,$options,$level,$image_count,$chapter_id,$questionProbability=0.0, $test_count=0)
    {
        $this->crud = $crud;
        $this->type = $type;
        $this->marks = $marks;
        $this->options = $options;
        $this->level = $level;
        $this->statement = $statement;
        $this->image_count = $image_count;
        $this->chapter_id = $chapter_id;
        $this->questionProbability = $questionProbability;
        $this->test_count = $test_count;
        $this->insertQuestion();

    }

    private function insertQuestion()
    {

        $columns = array('statement','level','marks','probability','image_count','type','chapter_id',
                         'test_count','created_at','updated_at');
        $values = array($this->statement,$this->level,$this->marks,$this->questionProbability,$this->image_count,$this->type,$this->chapter_id
                        ,$this->test_count,$this->crud->getDateTime(),$this->crud->getDateTime());
        try {
            $this->crud->insert('question', $columns, $values);
        }
        catch(UnmatchedColumnValueList $e)
        {
            $e->errorMessage();
        }

        $question_id = $this->crud->getLastInsertedID();

        $columns_option = array('statement','image_count','question_id','created_at','updated_at');
        for($i=0;$i<count($this->options);$i++)
        {
            $values_option = array($this->options[$i],0,$question_id,$this->crud->getDateTime(),$this->crud->getDateTime());
            $this->crud->insert('options',$columns_option,$values_option);
        }


        $answer_id = $this->crud->getLastInsertedID();

        $this->crud->updateData($question_id,'question',array('answer_id'),array($answer_id),'question_id');
    }


}

class OptionModel
{
    private $statement;
    private $image_count;

    function __construct($statement, $image_count)
    {
        $this->image_count = $image_count;
        $this->statement = $statement;
    }

    function getStatement()
    {
        return $this->statement;
    }
    function getImageCount()
    {
        return $this->image_count;
    }
}

class QuestionToJSON
{
    public $major_stmt;
    public $question_stmt;

    function __construct($majorstatement,$questionstatement)
    {
        $this->major_stmt = $majorstatement;
        $this->question_stmt = array(new QuestionStatement($questionstatement,""));
    }
}

class QuestionStatement
{
    public $text;
    public $text_image;

    function __construct($text,$text_image)
    {
        $this->text = $text;
        $this->text_image = $text_image;
    }

}

class FIBOption
{
    public $answers;

    function __construct($answers)
    {
        $this->answers = $answers;
    }

}

class MCQOption
{

    public $options_url; //String
    public $options_text;


    public function __construct( $options_text,$options_url)
    {
        $this->options_url = $options_url;
        $this->options_text = $options_text;
    }

}

class MCQOptions implements JsonSerializable
{
    public $MCQOption;
    public function __construct($mcqOption)
    {
        $this->MCQOption = $mcqOption;
    }


    public function jsonSerialize()
    {

    }
}

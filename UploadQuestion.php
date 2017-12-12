<?php

require_once ("Crud.php");
require_once ("DatabaseConstants.php");

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
    function __construct($statement,$type,$marks,$options,$level,$image_count,$chapter_id,$questionProbability=0.0, $test_count=0)
    {
        $this->crud = Crud::getInstance(self::SERVER,self::USERNAME,self::PASSWORD,self::DATABASE);

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
?>
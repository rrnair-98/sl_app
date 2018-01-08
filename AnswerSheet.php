<?php
/**
 * Created by PhpStorm.
 * User: ADMIN-PC
 * Date: 08-01-2018
 * Time: 12:39 PM
 */

require_once ('DatabaseConstants.php');
require_once ('Crud.php');
require_once ('CustomExceptions.php');
class AnswerSheet implements DatabaseConstants
{
    private $crud;
    private $test_id;
    private $question_id;
    private $answers;
    private $type;

    function __construct($test_id,$question_id,$answers,$type)
    {
        $this->crud = Crud::getInstance(self::SERVER,self::USERNAME,self::PASSWORD,self::DATABASE);
        $this->question_id = $question_id;
        $this->answers  = $answers;
        $this->test_id = $test_id;
        $this->type = $type;
        $this->insertAnswer();
    }

    private function insertAnswer()
    {
        $columns = array('test_id','question_id','selected_option_id','created_at','updated_at');
        if($this->type==1)
            $selected_option_id =$this->answers[0] ;
        else
            $selected_option_id = 0;

        $values = array($this->test_id,$this->question_id,$selected_option_id,$this->crud->getDateTime(),$this->crud->getDateTime());

        try {
            $this->crud->insert('answer_sheet', $columns, $values);
        }
        catch(UnmatchedColumnValueList $e)
        {
            $e->errorMessage();
        }
        if($this->type!=1)
        {
            $sheet_id = $this->crud->getLastInsertedID();
            $columns = array('answer_sheet_id','statement','image_count','created_at','updated_at');
            $statement = "{\"answers\":".json_encode($this->answers)."}";
            $values = array($sheet_id,$statement,0,$this->crud->getDateTime(),$this->crud->getDateTime());
            try {
                $this->crud->insert('answer', $columns, $values);
            }
            catch(UnmatchedColumnValueList $e)
            {
                $e->errorMessage();
            }
        }
    }




}
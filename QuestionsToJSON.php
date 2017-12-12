<?php
/**
 * Created by PhpStorm.
 * User: ADMIN-PC
 * Date: 12-12-2017
 * Time: 10:18 AM
 */



class QuestionsToJSON
{
    public $major_stmt;
    public $question_stmt;

    function __construct($major_stmt,$question_stmt)
    {
        $this->major_stmt = $major_stmt;
        $this->question_stmt = array();
        for($i=0;$i<count($question_stmt);$i++)
        {
            $this->question_stmt[] = new MTFQuestionStatement($question_stmt[$i]->getStatement(),$question_stmt[$i]->getImageUrl(),strval($i+1));
        }

    }
}
?>
<?php
/**
 * Created by PhpStorm.
 * User: ADMIN-PC
 * Date: 12-12-2017
 * Time: 10:17 AM
 */


class QuestionToJSON
{
    public $major_stmt;
    public $question_stmt;

    function __construct($major_stmt,$question_stmt,$text_image)
    {
        $this->major_stmt = $major_stmt;
        $this->question_stmt = array(new QuestionStatement($question_stmt,$text_image));
    }

}
?>
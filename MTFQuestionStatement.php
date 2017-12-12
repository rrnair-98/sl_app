<?php
/**
 * Created by PhpStorm.
 * User: ADMIN-PC
 * Date: 12-12-2017
 * Time: 10:19 AM
 */

include_once ('QuestionStatement.php');


class MTFQuestionStatement extends QuestionStatement
{
    public $sub_id;
    function __construct($text, $text_image,$sub_id)
    {
        parent::__construct($text, $text_image);
        $this->sub_id = $sub_id;
    }

}

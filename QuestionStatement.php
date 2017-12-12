<?php
/**
 * Created by PhpStorm.
 * User: ADMIN-PC
 * Date: 12-12-2017
 * Time: 10:19 AM
 */



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

?>
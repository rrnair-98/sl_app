<?php
/**
 * Created by PhpStorm.
 * User: ADMIN-PC
 * Date: 12-12-2017
 * Time: 10:24 AM
 */


class MCQOption
{

    public $options_url; //String
    public $options_text;


    public function __construct( $options_text,$options_url)
    {
        $this->options_url = $options_url;
        $this->options_text = $options_text;
    }

    public function getOptionsUrl()
    {
        return $this->options_url;
    }


    public function getOptionsText()
    {
        return $this->options_text;
    }



}
?>
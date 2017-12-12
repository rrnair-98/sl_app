<?php
/**
 * Created by PhpStorm.
 * User: ADMIN-PC
 * Date: 12-12-2017
 * Time: 10:25 AM
 */

include_once ('MCQOption.php');

class MTFOption extends MCQOption
{
    public $sub_id;
    function __construct($options_text, $options_url,$sub_id)
    {
        parent::__construct($options_text, $options_url);
        $this->sub_id = $sub_id;
    }

}

?>
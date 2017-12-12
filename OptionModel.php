<?php
/**
 * Created by PhpStorm.
 * User: ADMIN-PC
 * Date: 12-12-2017
 * Time: 10:15 AM
 */



class OptionModel
{
    private $statement;
    private $image_count;
    private $image_url;
    function __construct($statement, $image_count,$img_url)
    {
        $this->image_count = $image_count;
        $this->statement = $statement;
        $this->image_url = $img_url;
    }

    function getStatement()
    {
        return $this->statement;
    }
    function getImageCount()
    {
        return $this->image_count;
    }
    function getImageUrl()
    {
        return $this->image_url;
    }
}

?>
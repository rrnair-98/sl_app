<?php

class ConnectionError extends Exception
{
    private $errorMsg;
    function __construct($message)
    {
        $this->errorMsg = $message;
    }
    function errorMessage()
    {
        return "There was error in connecting to database. Please check your credentials";
    }
}

class UnmatchedColumnValueList extends Exception
{
    private $columns;
    private $values;
    function __construct($columns,$values)
    {
        $this->columns = $columns;
        $this->values = $values;
    }
    function errorMessage()
    {
        return "The number of columns(number of columns :$this->columns) and values(number of values :$this->values) passed do not match. Check the passed arguements ";
    }
}

class TableNotExists extends Exception
{
    private $tableName;
    function __construct($tableName)
    {
        $this->tableName = $tableName;
    }
    
    function errorMessage()
    {
        return "The table '$this->tableName' does not exist";
    }
}

?>
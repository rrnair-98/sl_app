<?php
/*contains methods for input validation*/
class Validation
{
    static public function validateData($data)
    {
        $data=trim(stripslashes(htmlspecialchars(strip_tags(str_replace(array('(',')'),'',$data)),ENT_QUOTES)));
        return $data;
    }
    static public function validatePassword($password)
    {
        $password = trim(stripslashes(htmlspecialchars($password)));
        return $password;
    }
}
<?php

class HttpResponse
{
    public static function setHttpResponseCode($code)
    {
        http_response_code($code);
    }
}
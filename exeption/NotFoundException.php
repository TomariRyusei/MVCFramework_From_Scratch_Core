<?php

namespace tryu\phpmvc\exeption;

class NotFoundException extends \Exception
{
    protected $message = 'Page not found';
    protected $code = 404;
}
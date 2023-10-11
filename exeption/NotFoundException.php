<?php

namespace app\core\exeption;

class NotFoundException extends \Exception
{
    protected $message = 'Page not found';
    protected $code = 404;
}
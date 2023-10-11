<?php

namespace tryu\phpmvc\middlewares;

abstract class BaseMiddleware
{
    abstract public function execute();
}
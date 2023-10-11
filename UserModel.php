<?php

namespace tryu\phpmvc;

use tryu\phpmvc\db\DbModel;

abstract class UserModel extends DbModel
{
    abstract public function getDisplayName(): string;
}
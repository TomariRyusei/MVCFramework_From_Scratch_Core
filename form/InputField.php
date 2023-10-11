<?php

namespace app\core\form;

use app\core\Model;

class InputField extends BaseField
{
    const TYPE_TEXT = 'text';
    const TYPE_PASSWORD = 'password';
    const TYPE_NUMBER = 'number';

    public string $type;
    
    public function __construct(Model $model, string $attribute) {
        parent::__construct($model, $attribute);

        $this->type = self::TYPE_TEXT;
    }

    public function passwordField()
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }

    public function renderInput(): string
    {
        return sprintf('<input type="%s" name="%s" value="%s" class="form-control%s" aria-describedby="emailHelp">',
        $this->type,
        $this->attribute,
        $this->model->{$this->attribute},
        $this->model->hasError($this->attribute) ? ' is-invalid' : '',);
    }
}
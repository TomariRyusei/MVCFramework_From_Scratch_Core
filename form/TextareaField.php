<?php

namespace app\core\form;

use app\core\Model;

class TextareaField extends BaseField
{
    public function renderInput(): string
    {
        return sprintf('<textarea class="form-control%s" name="%s">%s</textarea>',
             $this->model->hasError($this->attribute) ? ' is-invalid' : '',
            $this->attribute,
            $this->model->{$this->attribute},
        );
    }
}
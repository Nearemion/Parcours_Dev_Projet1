<?php

namespace Lib\Form;

abstract class FormType
{
    private $fields = [];

    public function createView()
    {
        $display = '';

        foreach ($this->fields as $field) {
            $display .= $field->buildWidget();
        }

        return $display;
    }
}

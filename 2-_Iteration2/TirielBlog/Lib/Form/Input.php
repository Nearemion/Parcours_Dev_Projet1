<?php

namespace Lib\Form;

class Input
{
    private $label;
    private $type;
    private $types = ['checkbox', 'date', 'email', 'file', 'hidden', 'password', 'radio', 'reset', 'submit', 'text', 'url'];
    private $name;
    private $value;
    private $attributes = [];

    public function __construct($label, $type, $name, $value = null)
    {
        $this->setLabel($label);
        $this->setType($type);
        $this->setName($name);
        if (isset($value)) {
            $this->setValue($value);
        }
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setLabel($label)
    {
        if (is_string($label)) {
            $this->label = $label
        }
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        if (is_string($type) && in_array($type, $this->types)) {
            $this->type = $type;
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        if (is_string($name)) {
            $this->name = $name;
        }
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        if (is_string($value)) {
            $this->value = $value;
        }
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function setAttributes($attribute)
    {
        if (is_string($attribute)) {
            $this->attributes[] = $attribute;
        }
    }

    public function buildWidget()
    {
        $display =
        '<label for="'.$this->name.'">'.$this->label.'</label>
        <input type="'.$this->type.'" name="'.$this->name.'"';

        if (isset($this->value)) {
            $display .= 'value="'.$this->value.'" ';
        }
        
        $display .= implode(' ', $attributes).'/>';

        return $display;
    }
}

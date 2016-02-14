<?php

namespace Lib\Form;

abstract class Field
{
    use \Lib\Hydrator;

    protected $label;
    protected $labelAttributes = [];
    protected $name;
    protected $attributes = [];

    public function __construct($datas)
    {
        $this->hydrate($datas);
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setLabel($label)
    {
        if (is_string($label)) {
            $this->label = $label;
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

    public function getLabelAttributes()
    {
        return $this->labelAttributes;
    }

    public function setLabelAttributes($attribute)
    {
        if (is_string($attribute)) {
            $this->labelAttributes[] = $attribute;
        }
    }

    abstract public function buildWidget();
}

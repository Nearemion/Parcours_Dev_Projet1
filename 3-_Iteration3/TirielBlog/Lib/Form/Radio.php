<?php

namespace Lib\Form;

class Radio extends Field
{
    private $type = 'radio';
    private $value;

    public function getType()
    {
        return $this->type;
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

    public function buildWidget()
    {
        $attributes = implode(' ', $this->attributes);
        $display =
        '<div class="radio">
            <label ';
        if(!empty($this->labelAttributes)) {
             $display .= implode(' ', $this->labelAttributes);
        }
        $display .= '>';

        if (preg_match('/col-[a-z]{2}-[0-9]{1,2}/', implode(' ', $this->attributes), $match)) {
            $display .=
            '<div class="'.$match[0].'">
                <input type="'.$this->type.'" name="'.$this->name.'" value="'.$this->value.'" '.strval($attributes).'/>
            </div>';
        } else {
            $display .= '<input type="'.$this->type.'" name="'.$this->name.'" value="'.$this->value.'" '.strval($attributes).'/>';
        }
        $display .=
            $this->label.'</label>
        </div>';

        return $display;
    }
}

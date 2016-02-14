<?php

namespace Lib\Form;

class Input extends Field
{
    private $type;
    private $types = ['checkbox', 'date', 'email', 'file', 'hidden', 'password', 'radio', 'reset', 'submit', 'text', 'url'];
    private $value;

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
        $display = '';
        
        if (!in_array($this->getType(), array('hidden', 'reset', 'submit'))) {
            $display .= '<label for="'.$this->name.'"';
			if(!empty($this->labelAttributes)) {
			    $display .= implode(' ', $this->labelAttributes);
			}
			$display .= '>'.$this->label.'</label>';
        }
        if (preg_match('/col-[a-z]{2}-[0-9]{1,2}/', implode(' ', $this->attributes), $match)) {
            $display .=
            '<div class="'.$match[0].'">
                <input type="'.$this->type.'" name="'.$this->name.'"';

            if (isset($this->value)) {
                $display .= 'value="'.$this->value.'" ';
            }
            
            $display .= strval($attributes).'/>
            </div>';
        } else {
            $display .= '<input type="'.$this->type.'" name="'.$this->name.'"';

            if (isset($this->value)) {
                $display .= 'value="'.$this->value.'" ';
            }
            
            $display .= strval($attributes).'/>';
        }

        return $display;
    }
}

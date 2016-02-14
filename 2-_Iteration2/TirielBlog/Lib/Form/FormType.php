<?php

namespace Lib\Form;

class FormType
{
    use \Lib\Hydrator;
	
    private $action;
	private $method;
	private $attributes = [];
    private $fields = [];

    public function __construct($datas)
    {
        $this->hydrate($datas);
    }

    public function getAction()
    {
        return $this->action;
    }

    public function setAction($action)
    {
        if (is_string($action)) {
            $this->action = $action;
        }
    }

    public function getMethod()
    {
        return $this->mzthod;
    }

    public function setMethod($method)
    {
        if (in_array($method, array('get', 'post'))) {
            $this->method = $method;
        }
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function setAttributes($attributes)
    {
        $this->attributes[] = $attributes;
    }
	
    public function addField($field)
    {
        $this->fields[] = $field;
    }

    public function createView()
    {
        $display = '
		<form action="'.$this->action.'" method="'.$this->method.'"';
		
		if (!empty($this->attributes)) {
			$display .= implode(' ', $this->attributes);
		}
		
		$display .= '>';

        foreach ($this->fields as $field) {
		$display .=
		'<div class="form-group">'
			.$field->buildWidget().
		'</div>';
        }
		
		$display .= '</form>';

        return $display;
    }
}

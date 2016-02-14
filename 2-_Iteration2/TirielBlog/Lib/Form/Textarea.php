<?php

namespace Lib\Form;

class Textarea extends Field
{
    private $rows;
    private $cols;
    private $placeholder = '';

    public function getRows()
    {
        return $this->rows;
    }

    public function setRows($rows)
    {
        if (is_int($rows)) {
            $this->rows  = strval($rows);
        }
    }

    public function getCols()
    {
        return $this->cols;
    }

    public function setCols($cols)
    {
        if (is_int($cols)) {
            $this->cols  = strval($cols);
        }
    }

    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    public function setPlaceholder($placeholder)
    {
        if (is_string($placeholder)) {
            $this->placeholder = $placeholder;
        }
    }

    public function buildWidget()
    {
        $display = '<label for="'.$this->name.'"';
            if(!empty($this->labelAttributes)) {
                $display .= implode(' ', $this->labelAttributes);
            }
            $display .= '>'.$this->label.'</label>';

        if (preg_match('/col-[a-z]{2}-[0-9]{1,2}/', implode(' ', $this->attributes), $match)) {
            $display.=
            '<div class="'.$match[0].'">
                <textarea name="'.$this->name.'"';
                if (isset($this->rows)) {
                    $display .= ' rows="'.$this->rows.'"';
                }
                if (isset($this->cols)) {
                    $display .= ' cols="'.$this->cols.'"';
                }
                if (isset($this->attributes)) {
                    $display .= implode(' ', $this->attributes);
                }
                $display .= '>'.$this->placeholder.'</textarea>
            </div>';
        } else {
            $display .=
            '<textarea name="'.$this->name.'"';
            if (isset($this->rows)) {
                $display .= ' rows="'.$this->rows.'"';
            }
            if (isset($this->cols)) {
                $display .= ' cols="'.$this->cols.'"';
            }
            if (isset($this->attributes)) {
                $display .= implode(' ', $this->attributes);
            }
            $display .= '>'.$this->placeholder.'</textarea>';
        }

        return $display;
    }
}

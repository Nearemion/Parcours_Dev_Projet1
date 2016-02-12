<?php

namespace Lib;

trait Hydrator
{
    public function hydrate($data)
    {
        foreach ($datas as $key => $value) {
            $method = 'set'.ucfirst($key);

            if (is_callable([$this, $method])) {
                $this->$method($value);
            }
        }
    }
}

<?php

namespace Lib;

use Lib\Manager;

abstract class Controller
{
    protected $manager;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function getManager()
    {
        return $this->manager;
    }
}

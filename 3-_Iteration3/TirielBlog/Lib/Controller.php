<?php

namespace Lib;

use Lib\Manager;

abstract class Controller
{
    protected $manager;
    protected $config;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
        $config = json_decode(file_get_contents(__DIR__.'/../Config/config.json'));
        $this->config = $config;
    }

    public function getManager()
    {
        return $this->manager;
    }
}

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
        $config = new \DOMDocument;
        $config->load(__DIR__.'/../Config/config.xml');
        $this->config = $config;
    }

    public function getManager()
    {
        return $this->manager;
    }
}

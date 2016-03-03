<?php

namespace Lib;

abstract class Controller
{
    protected $manager;

    public function __construct(BlogManager $manager)
    {
        $this->manager = $manager;
    }

    public function getManager()
    {
        return $this->manager;
    }
}

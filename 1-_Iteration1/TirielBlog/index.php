<?php

namespace TirielBlog;

use TirielBlog\Controller\BlogController;

$manager = new BlogManager();
$controller = new BlogController($manager);

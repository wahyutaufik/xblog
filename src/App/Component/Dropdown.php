<?php

namespace App\Component;

use \Bono\Helper\URL;
use \Norm\Norm;

class Tree {

    public function __construct() {
        $this->app = \Bono\App::getInstance();
    }

    public function show($array, $selected = null) {
        $html = '';

        return $html;
    }
}

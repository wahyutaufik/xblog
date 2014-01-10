<?php

namespace App\Component;

use \Bono\Helper\URL;
use \Norm\Norm;

class Dropdown {

    public function __construct($name) {
        $this->app = \Bono\App::getInstance();
        $this->name = $name;
    }

    public function show($array, $selected = null, $hay = '$id', $description = 'description', $default = '') {
        $html = '';

        $html .= '<select name="'.$this->name.'">';
        foreach ($array as $key => $value) {
            $html .= '<option value="'.$value[$hay].'" '.($selected == $value[$hay] ? 'selected' : '').'>'.$value[$description].'</option>';
        }
        $html .= $default;
        $html .= '</select>';

        return $html;
    }
}

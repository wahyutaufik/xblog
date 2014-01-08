<?php

namespace App\Component;

use \Bono\Helper\URL;
use \Norm\Norm;

class Tree {

    public function __construct() {
        $this->app = \Bono\App::getInstance();
    }

    public function show() {
        $collection = Norm::factory('Entry');
        $entries = $collection->find();
        $data = array();
        foreach ($entries as $key => $value) {
            $date = new \DateTime($value->get('$created_time'));
            $data[$date->format('Y')][$date->format('M')][$value->get('$id')] = $value->get('title');
        }

        $html = '<ul class="tree"><li>';

        foreach ($data as $year => $entry) {
            $html .= '<input type="checkbox" id="node-'.$year.'" checked="checked">';
            $html .= '<label for="node-'.$year.'"><a href="#">'.$year.'</a></label>';
            $html .= '<ul><li>';
            foreach ($entry as $month => $_entry) {
                $html .= '<input type="checkbox" id="node-inner-'.$year.'-'.$month.'" checked="checked">
                    <label for="node-inner-'.$year.'-'.$month.'">
                        <a href="#">'.$month.'</a>
                    </label>';
                $html .= '<ul>';
                foreach ($_entry as $key => $value) {
                    $html .= '<li><a href="'.URL::site('entry/'.$key).'">'.$value.'</a></li>';
                }
                $html .= '</ul>';
            }
            $html .= '</li></ul>';
        }

        $html .= '</ul></li>';

        return $html;
    }
}

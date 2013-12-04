<?php

namespace App\Component;

use \Bono\Helper\URL;

class Tree {

    public function __construct() {
        $this->app = \Bono\App::getInstance();
    }

    public function show($children) {
        $html = '<ul>';
        foreach ($children as $child) {
            ;
            if ('/queue/'.$child['$id'].'/task' == $this->app->request->getResourceUri()) {
                $selected = true;
            } else {
                $selected = FALSE;
            }
            $html .= '<li '.($selected ? 'class="selected"' : '').'>';
            $subchildren = $child->children();
            if (empty($subchildren)) {
                $html .= '<a href="'.URL::site('/queue/'.$child['$id'].'/task').'">'.$child['name'].'</a>';
            } else {
                $html .= '<input type="checkbox" id="f-'.$child['$id'].'" checked="checked">';
                $html .= '<label for="f-'.$child['$id'].'">';
                    $html .= '<a href="'.URL::site('/queue/'.$child['$id'].'/task').'">'.$child['name'].'</a>';
                $html .= '</label>';
                $html .= $this->show($subchildren);
            }
            $html .= '</li>';
        }
        $html .= '</ul>';

        return $html;
    }
}
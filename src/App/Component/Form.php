<?php

namespace App\Component;

use \Bono\Helper\URL;
use Norm\Norm;
use Norm\Collection;
use Norm\Model;

class Form {

    public function __construct() {
        $this->app = \Bono\App::getInstance();
    }

    public function show($id = NULL) {
        $collection = Norm::factory('Tags');
        $tags = $collection->find()->toArray();

        $title = '';
        $content = '';
        $_tags = '';

        if (! is_null($id)) {
            $collection = Norm::factory('Entry');
            $model = $collection->findOne($id);
            $title = $model->get('title');
            $content = $model->get('content');
            $_tags = $model->get('tags');
        }

        $html = '<form method="POST" action="">';
        $html .= '<fieldset>';
        $html .= '<div class="row"><div class="span-12">';
        $html .=
            '<div class="wrapper">
                <label>Title</label>
                <input type="text" placeholder="Title" name="title" value="'.$title.'">
            </div>';
        $html .= '</div></div>';
        $html .=
            '<div class="row">
                <div class="wrapper">
                    <div class="span-12">
                        <label>Entry Content</label>
                        <textarea placeholder="Entry Content" name="content">'.$content.'</textarea>
                    </div>
                </div>
            </div>';
        $dropdown = new \App\Component\Dropdown('tags');
        $html .=
            '<div class="wrapper tags">
                <label>Tags</label>';
        $html .= $dropdown->show($tags, $_tags, '$id', 'description', '<option value="create">Create new tags</option>');
        $html .= '</div>';
        $html .=
            '<div class="wrapper">
                <input type="submit" value="Submit">
                <a href="'.URL::base().'" class="button">Cancel</a>
            </div>';
        $html .= '</fieldset>';
        $html .= '</form>';

        $html .= '<script type="text/javascript" src="'. \Bono\Helper\URL::base('js/zepto.js').'"></script>';
        $html .= '<script type="text/javascript" src="'. \Bono\Helper\URL::base('js/app.js').'"></script>';

        return $html;
    }
}

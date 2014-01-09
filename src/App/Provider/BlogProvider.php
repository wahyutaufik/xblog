<?php

namespace App\Provider;

use \App\Component\Tree;
use \App\Component\Form;
use \Bono\Helper\URL;

use Norm\Norm;
use \App\Auth\Auth;

class BlogProvider extends \Bono\Provider\Provider{
    public function initialize() {
        $app = $this->app;
        $this->app->get('/', function() use ($app) {
            $_tree = new Tree();
            $app->response->set('tree', $_tree->show());

            $collection = Norm::factory('Entry');
            $model = $collection->find()->toArray();

            $html = '';
            foreach ($model as $key => $value) {
                $html .= '<a href="'.URL::site('/entry/'.$value->get('$id')).'"><h1>'.$value->get('title').'</h1></a>';
                $html .= '<p>'.nl2br(substr($value->get('content'), 0, 100)).' ...</p>';
                $html .= '<a href="#">'.$value->get('tags').'</a>';
                $html .= '&nbsp;';
                $html .= '<span>By '.$value->get('$created_by').' at '.$value->get('$created_time').'</span>';
                if (Auth::check()) {
                    $html .= '&nbsp;';
                    $html .= '<a href="'.URL::site('entry/'.$value->get('$id').'/edit').'">Edit</a>';
                    $html .= '&nbsp;';
                    $html .= '<a href="'.URL::site('entry/'.$value->get('$id').'/delete').'">Delete</a>';
                }
                $html .= '<hr>';
            }

            $app->response->set('content', $html);

            $app->response->template('layout');
        });

        $this->app->get('/entry/:id/create', function() use ($app) {
            $_form = new Form();
            $app->response->template('layout');
            $app->response->set('content', $_form->show());
        });

        $this->app->post('/entry/:id/create', function() use ($app) {
            $collection = Norm::factory('Entry');

            // Creating new tags
            if (@$_POST['tags'] == 'create') {
                $_collection = Norm::factory('Tags');
                $_model = $_collection->newInstance();
                $_model->set('description', $_POST['newTags']);
                $_model->save();
                $_POST['tags'] = $_model->get('$id');
            }

            $model = $collection->newInstance();
            $model->set('title', $_POST['title']);
            $model->set('content', $_POST['content']);
            $model->set('tags', @$_POST['tags']);
            $model->save();

            $app->response->redirect('/');
        });

        $this->app->get('/entry/:id', function($id) use ($app) {
            $collection = Norm::factory('Entry');

            $model = $collection->findOne($id);
            $_tree = new Tree();
            $app->response->set('tree', $_tree->show());

            $html = '<h1>'.$model->get('title').'</h1>';
            $html .= '<p>'.nl2br($model->get('content')).'</p>';

            if (Auth::check()) {
                $html .= '<a href="'.URL::site('entry/'.$id.'/edit').'">Edit</a>';
                $html .= '&nbsp;';
                $html .= '<a href="'.URL::site('entry/'.$id.'/delete').'">Delete</a>';
            }

            $app->response->set('content', $html);

            $app->response->template('layout');
        });

        $this->app->get('/entry/:id/edit', function($id) use ($app) {
            $_form = new Form();
            $app->response->set('content', $_form->show($id));

            $app->response->template('layout', array('entry'));
        });

        $this->app->post('/entry/:id/edit', function($id) use ($app) {
            if (@$_POST['tags'] == 'create') {
                $_collection = Norm::factory('Tags');
                $_model = $_collection->newInstance();
                $_model->set('description', $_POST['newTags']);
                $_model->save();
                $_POST['tags'] = $_model->get('$id');
            }

            $collection = Norm::factory('Entry');
            $model = $collection->findOne($id);
            $model->set('title', $_POST['title']);
            $model->set('content', $_POST['content']);
            $model->set('tags', @$_POST['tags']);
            $model->save();

            $app->flash('info', 'Successfully updated!');
            $app->response->redirect('/entry/'.$id.'/edit');
        });

        $this->app->get('/entry/:id/delete', function($id) use ($app) {
            $url = (substr($this->app->request->getPathInfo(), -1) == '/') ? substr($$this->app->request->getPathInfo(), 0, -1) : $this->app->request->getPathInfo();
            $urlparts = explode('/', $url);
            array_pop($urlparts);
            $url = implode($urlparts, '/');

            $html = '<form action="" method="POST">';
            $html .= '<input type="hidden" name="confirm" value="1">';
            $html .= '<fieldset>Are you sure want to delete?</fieldset>';
            $html .= '<input type="submit" value="OK">';
            $html .= '<a href="'.URL::site($url).'" class="button">Cancel</a>';
            $html .= '</form>';

            $app->response->set('content', $html);

            $app->response->template('layout');
        });

        $this->app->post('/entry/:id/delete', function($id) use ($app) {
            $collection = Norm::factory('Entry');
            $model = $collection->findOne($id);
            $model->remove();
            $app->flash('info', 'Successfully deleted!');
            $app->response->redirect('/');
        });
    }
}

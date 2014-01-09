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
                $html .= '<p>'.$value->get('content').'</p>';
                $html .= '<hr>';
            }

            $app->response->set('content', $html);

            $app->response->template('layout');
        });

        $this->app->get('/entry/create', function() use ($app) {
            $_form = new Form();
            $app->response->template('layout');
            $app->response->set('content', $_form->show());
        });

        $this->app->post('/entry/create', function() use ($app) {
            $collection = Norm::factory('Entry');

            $model = $collection->newInstance();
            $model->set('title', $_POST['title']);
            $model->set('content', $_POST['content']);
            $model->save();

            $app->response->redirect('/');
        });

        $this->app->get('/entry/:id', function($id) use ($app) {
            $collection = Norm::factory('Entry');

            $model = $collection->findOne($id);
            $_tree = new Tree();
            $app->response->set('tree', $_tree->show());

            $html = '<h1>'.$model->get('title').'</h1>';
            $html .= '<p>'.$model->get('content').'</p>';

            if (Auth::check()) {
                $html .= '<a href="'.URL::site('entry/'.$id.'/edit').'">Edit</a>';
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
            $collection = Norm::factory('Entry');
            $model = $collection->findOne($id);
            $model->set('title', $_POST['title']);
            $model->set('content', $_POST['content']);
            $model->save();

            $app->flash('info', 'Successfully updated!');
            $app->response->redirect('/entry/'.$id.'/edit');
        });
    }
}

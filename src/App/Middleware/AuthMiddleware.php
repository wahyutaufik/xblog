<?php

namespace App\Middleware;
use App\Auth\Auth;

class AuthMiddleware extends \Slim\Middleware {
    public function call() {
        $config = $this->app->config('auth');

        $pathInfo = $this->app->request->getPathInfo();
        $app = $this->app;
        $request = $this->app->request;
        $response = $this->app->response;

        $this->app->get('/login', function() use ($response) {
            $this->app->response->template('login');
        });
        
        $this->app->post('/login', function() use ($response) {
            $post = $this->app->request->post();
            if(Auth::attemp($post)) {
                $this->app->flash('info', 'Successfully logged in!');
            } else {
                if(Auth::authenticate($post)) {
                    $this->app->flash('info', 'Successfully logged in using Central Auth Service');
                    $response->template('login');
                } else {
                    $response->template('login');
                }
            }
        });

        $this->app->get('/logout', function() use($app, $response) {
            Auth::logout();

            $response->redirect('/login');
        });

        $allow = false;
        if (array_key_exists($pathInfo, $config['allow'])) {
            $allow = true;
        }

        if (!$allow && !Auth::check()) {
            $this->app->response->redirect('/login');
        } else {
            $this->next->call();
        }

    }
}
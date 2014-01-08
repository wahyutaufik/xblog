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

        $this->app->get('/login', function() use($app, $response) {
            $selfUrl = 'http://'.$_SERVER['HTTP_HOST'].\Bono\Helper\URL::base('auth');
            $this->app->response->redirect('http://localhost/acc/login?@continue='.urlencode($selfUrl));
        });

        $this->app->get('/auth', function() use($app, $response) {
            $get = $app->request->get();
            $appId = $this->app->config('appId');
            $salt = $this->app->config('app.salt');
            $sid = hash('sha1', $appId.$salt);

            $service = array(
                'ticket' => $get['@ticket'],
                'appId'  => $appId,
                'sid'    => $sid
            );

            Auth::authenticate($service);

            $this->app->response->redirect('/');
        });

        // TODO Maybe we need this one to deauth from server
        // $this->app->get('/deauth', function() use($app, $response) {
        //     $post = $this->app->request->post();
        //     Auth::deauthenticate($post);
        //     $this->app->response->redirect('/');
        // });

        $this->app->get('/logout', function() use($app, $response) {
            Auth::deauthenticate();
            Auth::logout();
            $selfUrl = 'http://'.$_SERVER['HTTP_HOST'].\Bono\Helper\URL::base();
            $this->app->response->redirect('http://localhost/acc/logout?@continue='.urlencode($selfUrl));
        });

        $allow = false;

        if (array_key_exists($pathInfo, $config['allow'])) {
            $allow = true;
        }

        if (!$allow && !Auth::check()) {
            $selfUrl = 'http://'.$_SERVER['HTTP_HOST'].\Bono\Helper\URL::base('auth');
            $this->app->response->redirect('http://localhost/acc/login?@continue='.urlencode($selfUrl));
        } else {
            $this->next->call();
        }

    }
}

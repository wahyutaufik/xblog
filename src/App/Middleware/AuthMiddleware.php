<?php

namespace App\Middleware;
use App\Auth\Auth;

class AuthMiddleware extends \Slim\Middleware {
    public function inArray($string, $array = array()) {
        if (empty($array) || empty($string)) return false;
        foreach ($array as $key => $value) {
            if (fnmatch($key, $string)) {
                return true;
            }
        }
        return false;
    }

    public function call() {
        $config = $this->app->config('auth');

        $pathInfo = $this->app->request->getPathInfo();
        $app = $this->app;
        $request = $this->app->request;
        $response = $this->app->response;

        $this->app->get('/login', function() use($app, $response) {
            $config = $this->app->config('auth');

            $selfUrl = 'http://'.$_SERVER['HTTP_HOST'].\Bono\Helper\URL::base('auth');

            $this->app->response->redirect($config['urlServiceProvider'].'login?@continue='.urlencode($selfUrl));
        });

        $this->app->get('/auth', function() use($app, $response) {
            $get = $app->request->get();
            $appId = $this->app->config('appId');
            $secret = $this->app->config('secret');

            $service = array(
                'ticket' => $get['@ticket'],
                'appId'  => $appId,
                'secret'  => $secret
            );

            Auth::authenticate($service);

            $this->app->response->redirect('/');
        });

        $this->app->get('/logout', function() use($app, $response) {
            $config = $this->app->config('auth');

            Auth::deauthenticate();
            Auth::logout();

            $selfUrl = 'http://'.$_SERVER['HTTP_HOST'].\Bono\Helper\URL::base();

            $this->app->response->redirect($config['urlServiceProvider'].'logout?@continue='.urlencode($selfUrl));
        });

        $allow = false;

        if ($this->inArray($pathInfo, $config['allow']) && ! $this->inArray($pathInfo, @$config['restricted'])) {
            $allow = true;
        }

        if (!$allow && !Auth::check()) {
            $selfUrl = 'http://'.$_SERVER['HTTP_HOST'].\Bono\Helper\URL::base('auth');
            $this->app->response->redirect($config['urlServiceProvider'].'login?@continue='.urlencode($selfUrl));
        } else {
            $this->next->call();
        }

    }
}

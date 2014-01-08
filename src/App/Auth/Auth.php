<?php

namespace App\Auth;
use \Norm\Norm;

class Auth {

    public static function check() {
        return ( (isset($_SESSION['login'])) ? $_SESSION['login'] : false );
    }

    public static function authenticate($service) {
        $serviceUrl = 'http://localhost/acc/auth';

        $curl = curl_init($serviceUrl);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $service);

        $curlResponse = curl_exec($curl);

        if ($curlResponse !== false) {
            $decoded = json_decode($curlResponse, true);

            if (!$decoded['error']) {
                $collection = Norm::factory('User');
                $model = $collection->findOne(array('username' => $decoded['user']['username']));
                if (is_null($model)) {
                    $model = $collection->newInstance();
                    $model->set('username', $decoded['user']['username']);
                    try {
                        $model->save();
                    } catch (\Exception $e) {
                        echo $e.''; exit;
                    }
                }
                $_SESSION['login'] = true;
                $_SESSION['user'] = $collection->findOne(array('username' => $decoded['user']['username']));
            } else {
                $_SESSION['login'] = false;
                $app = \Bono\App::getInstance();
                $app->flash('error', $decoded['message']);
            }
        }

        curl_close($curl);

        return self::check();
    }

    public static function deauthenticate() {
        $serviceUrl = 'http://localhost/acc/deauth';

        $app = \Bono\App::getInstance();

        $service = array(
            'username' => @$_SESSION['user']->username,
            'appId' => $app->config('appId'),
            'ticket' => @$_SESSION['user']->ticket,
        );

        $curl = curl_init($serviceUrl);

        curl_setopt($curl, CURLOPT_URL, $serviceUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $service);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_FORBID_REUSE, true);
        curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);

        $response = curl_exec($curl);

        curl_close($curl);
    }

    public static function logout() {
        if(isset($_SESSION['login'])) {
            $_SESSION['login'] = false;
            unset($_SESSION['login']);

            $_SESSION['user'] = array();
            unset($_SESSION['user']);
        }
    }

}

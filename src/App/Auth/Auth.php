<?php

namespace App\Auth;
use \Norm\Norm;

class Auth {

    public static function check() {
        if(empty($_SESSION['auth']) || empty($_SESSION['ticket'])) {
            return false;
        } else {
            return true;
        }
    }
    
    public static function attemp($service) {
        $collection = \Norm\Norm::factory('User');
        $app = \Bono\App::getInstance();

        $userModel = $collection->findOne(array(
            'username' => $service['username']
        ));

        if (isset($userModel) && $userModel->get('password') === salt($service['password'])) {
            $_SESSION['auth'] = $service['username'];
            $_SESSION['ticket'] = hash('sha512', $service['appId']);
        } else {
            $_SESSION['auth'] = null;
            $_SESSION['ticket'] = null;
        }
        
        return self::check();
    }

    public static function authenticate($service) {
        $service_url = 'http://localhost/acc/auth';
        
        $curl = curl_init($service_url);
        
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $service);
        
        $curl_response = curl_exec($curl);
        curl_close($curl);
        
        if ($curl_response !== false) {
            $decoded = json_decode($curl_response);
            
            if (!empty($decoded->auth)) {
                $_SESSION['auth'] = $decoded->auth;
                $_SESSION['ticket'] = $decoded->ticket;
            } else {
                $_SESSION['auth'] = null;
                $_SESSION['ticket'] = null;

                $app = \Bono\App::getInstance();
                $app->flash('error', $decoded->message);
            }
        }

        return self::check();
    }

    public static function logout() {
        if(isset($_SESSION['auth'])) {
            $_SESSION['auth'] = null;
            unset($_SESSION['auth']);
            self::logout();
        }
    }

}

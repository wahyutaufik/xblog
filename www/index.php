<?php
require '../vendor/autoload.php';

use \Norm\Norm;
use \App\Auth\Auth;

function salt($value) {
    if (!empty($value)) {
        $salt = \Bono\App::getInstance()->config('app.salt');
        $value = hash('sha512', $salt.$value);
    }

    return $value;
}

$app = new \Bono\App(array(
    'autorun' => false,
    'mode' => 'development',
));

$app->run();

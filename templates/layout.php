<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Xinix Blog</title>

    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />

    <link rel="shortcut icon" href="<?php echo \Bono\Helper\URL::base('img/favicon.ico') ?>" type="image/x-icon" />
    <link rel="apple-touch-icon" href="<?php echo \Bono\Helper\URL::base('img/favicon.ico') ?>" /> 
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo \Bono\Helper\URL::base('img/favicon.ico') ?>" /> 

    <link rel="stylesheet" href="<?php echo \Bono\Helper\URL::base('css/naked.css') ?>">
    <link rel="stylesheet" href="<?php echo \Bono\Helper\URL::base('css/font-awesome.css') ?>">
</head>

<?php
use \Bono\Helper\URL;
use \App\Auth\Auth;
?>

<body>
    <div class="navbar">
        <?php if (Auth::check()): ?>
            <ul class="button-group centered">
                <li><a href="<?php echo URL::site('/') ?>" class="button">Home</a></li>
                <li><a href="<?php echo URL::site('/user') ?>" class="button">User</a></li>
                <li><a href="<?php echo URL::site('/logout') ?>" class="button">Logout</a></li>
            </ul>
        <?php else: ?>
            <ul class="button-group centered">
                <li>Welcome</li>
            </ul>
        <?php endif ?>
    </div>
    <div style="padding-top: 60px; margin: 0 5px;">
        <?php if (isset($flash['error']) || isset($flash['info'])): ?>
        <div class="row alert-row">
            <?php if (isset($flash['error'])): ?>
                <div class="alert error">
                    <button type="button" class="close">×</button>
                    <?php echo $flash['error']; ?>
                </div>
            <?php endif ?>
            <?php if (isset($flash['info'])): ?>
                <div class="alert success">
                    <button type="button" class="close">×</button>
                    <?php echo $flash['info']; ?>
                </div>
            <?php endif ?>
        </div>
        <?php endif ?>
        <?php echo $body ?>
    </div>
</body>
</html>
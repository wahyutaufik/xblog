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
        <ul class="button-group centered">
            <li><a href="<?php echo URL::site('/') ?>" class="button">Blog</a></li>
            <?php if(Auth::check()): ?>
                <li><a href="<?php echo URL::site('/logout') ?>" class="button">Logout</a></li>
                <li><a href="<?php echo URL::site('/entry/create') ?>" class="button">Create Entry</a></li>
            <?php else: ?>
                <li><a href="<?php echo URL::site('/login') ?>" class="button">Login</a></li>
            <?php endif ?>
        </ul>
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
        <div class="row">
            <div class="span-2">
                <?php echo @$tree; ?>
            </div>
            <div class="span-10">
                <div class="">
                    <?php echo @$content; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

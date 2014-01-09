<?php
use \ROH\BonoComponent\PlainTable as Table;
use \App\Component\SearchButtonGroup;
use \Bono\App;

$_app = App::getInstance();
$_controller = $_app->controller;
$_table = new Table($_controller->clazz);
$_searchButtonGroup = new SearchButtonGroup();
?>
<h2><?php echo $_controller->clazz ?></h2>

<?php echo $_searchButtonGroup->show() ?>

<?php echo $_table->show($entries) ?>

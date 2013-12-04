<?php
use \Bono\Helper\URL;
use \App\Component\Tree;
use \App\Component\Table;
?>
<?php

$_tree = new Tree();
$_table = new Table('Task', array(
    'actions' => array(
        'update' => function($key, $value, $context) {
            return '<a href="'.URL::site('/task/'.$context['$id'].'/update?continue='.\Bono\App::getInstance()->request->getResourceUri()).'">Update</a> ';
        },
        'delete' => function($key, $value, $context) {
            return '<a href="'.URL::site('/task/'.$context['$id'].'/delete?continue='.\Bono\App::getInstance()->request->getResourceUri()).'">Delete</a> ';
        }
    )
));
?>

<!--
<div class="row">
    <h1>Task</h1>
</div> -->

<div class="row">
    <div class="xlarge-2 large-2 medium-3 small-12 tiny-12">
        <div class="button-group">
            <a href="<?php echo URL::site('/queue/null/create') ?>?parent=<?php echo \Bono\App::getInstance()->request->getSegments(2) ?>&continue=<?php echo \Bono\App::getInstance()->request->getResourceUri() ?>" class="button">Add</a>
        </div>
        <ul class="tree">
            <li <?php echo \Bono\App::getInstance()->request->getResourceUri() == '/queue/null/task' ? 'class="selected"' : '' ?>>
                <input type="checkbox" id="f-all" checked="checked">
                <label for="f-all">
                    <a href="<?php echo URL::site('/queue/null/task') ?>">All</a>
                </label>
                <?php echo $_tree->show($_queues) ?>
            </li>
        </ul>
    </div>
    <div class="xlarge-10 large-10 medium-9 small-12 tiny-12">
        <div class="button-group">
            <a href="<?php echo URL::site('/task/null/create') ?>?queue=<?php echo \Bono\App::getInstance()->request->getSegments(2) ?>&continue=<?php echo \Bono\App::getInstance()->request->getResourceUri() ?>" class="button">Add</a>
        </div>
        <?php echo $_table->show($tasks) ?>
    </div>
</div>
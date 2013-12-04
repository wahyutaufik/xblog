<?php
use \App\Component\Table;
use \App\Component\SearchButtonGroup;

$_table = new Table($_controller->clazz);
$_searchButtonGroup = new SearchButtonGroup();
?>
<h2><?php echo $_controller->clazz ?></h2>

<?php echo $_searchButtonGroup->show() ?>

<?php echo $_table->show($entries) ?>

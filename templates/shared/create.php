<?php
use \ROH\BonoComponent\PlainForm as Form;
use \Bono\App;

$_app = App::getInstance();
$_controller = $_app->controller;

$_form = new Form($_controller->clazz);
?>
<h2><?php echo $_controller->clazz ?></h2>

<form action="" method="POST">
    <fieldset>
        <?php echo $_form->renderFields(@$entry) ?>
    </fieldset>
    <div class="row">
        <input type="submit" value="Save" class="button">
        <a href="<?php echo \Bono\Helper\URL::site($_controller->getRedirectUri()) ?>" class="button">Back to List</a>
    </div>
</form>

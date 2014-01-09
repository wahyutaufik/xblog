<?php
use \Bono\App;

$_app = App::getInstance();
$_controller = $_app->controller;

?>
<form action="" method="POST">
    <input type="hidden" name="confirm" value="1">
    <fieldset>
        Are you sure want to delete this entry?
    </fieldset>

    <input type="submit" value="OK">
    <a href="<?php echo \Bono\Helper\URL::site($_controller->getRedirectUri()) ?>" class="button">Cancel</a>
</form>

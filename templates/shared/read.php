<?php
use \App\Component\Form;

$_form = new Form($_controller->clazz);
?>
<h2><?php echo $_controller->clazz ?></h2>

<fieldset>
    <?php echo $_form->renderReadonlyFields(@$entry) ?>
</fieldset>
<div class="row">
    <a href="<?php echo \Bono\Helper\URL::site($_controller->getRedirectUri()) ?>" class="button">Back to List</a>
</div>
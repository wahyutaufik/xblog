<h2><?php echo $_controller->clazz ?></h2>

<form action="" method="POST">
    <input type="hidden" name="confirm" value="1">
    <fieldset>
        Are you sure want to delete?
    </fieldset>

    <input type="submit" value="OK">
    <a href="<?php echo \Bono\Helper\URL::site($_controller->getRedirectUri()) ?>" class="button">Cancel</a>
</form>

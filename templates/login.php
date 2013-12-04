<!--FIXME Consider to use this method in Input-->
<?php
use App\Auth\Auth;
use \Bono\App;

$app = \Bono\App::getInstance();
?>
<form action="" method="POST">
    <div class="row">
        <label>Username</label>
        <input type="text" name="username">
    </div>
    <div class="row">
        <label>Password</label>
        <input type="password" name="password">
    </div>
    <div class="row">
        <input type="submit" value="Login">
    </div>
    <input type="hidden" name="appId" value="<?php echo $app->config('appId'); ?>">
</form>
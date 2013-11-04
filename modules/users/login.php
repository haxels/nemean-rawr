<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 26.03.12
 * Time: 21:25
 * To change this template use File | Settings | File Templates.
 */
?>
<form action="" method="post">
    Username: <input name="username" type="text" /><br />
    Password: <input name="password" type="password" /><br />
    <?php echo (isset($data['error'])) ? $data['error'] : ''; ?>
    <br />
    <input name="login" type="submit" value="Register" />
</form>
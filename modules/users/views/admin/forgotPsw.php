<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 12.07.12
 * Time: 21:36
 * To change this template use File | Settings | File Templates.
 */

?>
<form action="" method="POST">

    <li>
        <label for="tmpPassword">Tmp password:</label>
        <input name="tmpPassword" type="text" value="" />
        <span><?php echo (isset($data['errors']['tmpPassword'])) ? $data['errors']['tmpPassword'] : ''; ?></span>
    </li>
    <li>
        <label for="password">New password:</label>
        <input name="password" type="password" value="" />
        <span><?php echo (isset($data['errors']['password'])) ? $data['errors']['password'] : ''; ?></span>
    </li>
    <li>
        <label for="confTmpPassword">Confirm new password:</label>
        <input name="confTmpPassword" type="password" value="" />
    </li>
    <li>
        <label for="submit">&nbsp;</label>
        <input name="submitForgot" type="submit" value="Send" />
    </li>

</form>
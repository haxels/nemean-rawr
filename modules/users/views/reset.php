<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 26.08.12
 * Time: 10:40
 * To change this template use File | Settings | File Templates.
 */

?>
<section id="main">
<div class="formBox">
<h3>Resetting av passord</h3>
<hr>
<div class="form-left">
<form action="" method="POST">
    <li>
        <label for="tmpPw">Midlertidig passord:</label>
        <input name="tmpPw" type="password" value="<?php echo (isset($_POST['tmpPw'])) ? $_POST['tmpPw'] : ''; ?>" />
        <span><?php echo (isset($data['errors']['tmpPw'])) ? $data['errors']['tmpPw'] : ''; ?></span>
    </li>
    <li>
        <label for="newPw">Nytt passord:</label>
        <input name="newPw" type="password" />
        <span><?php echo (isset($data['errors']['newPw'])) ? $data['errors']['newPw'] : ''; ?></span>
    </li>
    <li>
        <label for="confNewPw">Gjenta nytt passord:</label>
        <input name="confNewPw" type="password" />
    </li>
    <li>
        <label for="tmpPw">&nbsp;</label>
        <input class="btn" name="submit_reset" type="submit" value="Reset" />
    </li>
</form>
</div>
<div class="form-right"></div>
</div>
</section>
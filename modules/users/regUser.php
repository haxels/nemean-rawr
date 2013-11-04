<?php
/**
 * User: Ragnar
 * Date: 3/25/12
 * Time: 11:28 PM
 */
?>

<form action="" method="post">
    Firstname: <input name="firstname" type="text" />
    <?php echo (isset($errors['firstname'])) ? $errors['firstname'] : ''; ?>
    <br />
    <input name="submit" type="submit" value="Register" />
</form>
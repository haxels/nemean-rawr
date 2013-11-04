<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 20.06.12
 * Time: 23:36
 * To change this template use File | Settings | File Templates.
 */
?>

<?php
    if (isset($data['errors']))
    {
        echo $data['errors'];
    }
?>

<form action="" method="POST">

    <ol>
        <li>
            <label for="name">Sponsor name:</label>
            <input name="name" type="text" value="<?php echo (isset($_POST['name'])) ? $_POST['name'] : ''; ?>" />
        </li>
        <li>
            <label for="image">Image url:</label>
            <input name="image" type="text" value="<?php echo (isset($_POST['image'])) ? $_POST['image'] : ''; ?>" />
        </li>
        <li>
            <label for="link">Link:</label>
            <input name="link" type="text" value="<?php echo (isset($_POST['link'])) ? $_POST['link'] : ''; ?>" />
        </li>
        <li>
            <label for="submit">&nbsp;</label>
            <input name="submit" type="submit" value="Lagre" />
        </li>
    </ol>

</form>
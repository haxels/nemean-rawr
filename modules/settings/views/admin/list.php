<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ragnar
 * Date: 5/1/12
 * Time: 2:47 PM
 * To change this template use File | Settings | File Templates.
 */

?>
<h2>Settings</h2>

    <form action="" method="POST">
        <ul>
    <?php foreach ($data['settings'] as $setting) : ?>

            <li>
                <label for="<?php echo $setting->getName(); ?>"><?php echo $setting->getName(); ?></label>
                <input name="<?php echo $setting->getName(); ?>" type="<?php echo $setting->getType(); ?>" value="<?php echo ($setting->getValue() == true) ? 0 : 1; ?>" <?php echo ($setting->getValue() == 1) ? 'checked' : 'unchecked'; ?> />
            </li>

    <?php endforeach; ?>
            <li>
                <label for="submit">&nbsp;</label>
                <input name="submit" type="submit" value="Save" />
            </li>
        </ul>

    </form>
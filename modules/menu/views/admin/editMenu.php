<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ragnar
 * Date: 5/1/12
 * Time: 1:32 PM
 * To change this template use File | Settings | File Templates.
 */

$menuItem = $data['menuItem'];


?>

<h2>Edit menu</h2>

    <form action="" method="POST">
        <ul>
            <li>
                <label for='label'>Label:</label>
                <input name="label" type="text" value="<?php echo $menuItem->getLabel(); ?>" />
            </li>
            <li>
                <label for='link'>Label:</label>
                <input name="link" type="text" value="<?php echo $menuItem->getLink(); ?>" />
            </li>
            <li>
                <label for="submit">&nbsp;</label>
                <input name="submit" type="submit" value="Save" />
            </li>
        </ul>
    </form>

    <h3>Children</h3>
    <?php

        if ($menuItem->hasChildren())
        {
            foreach ($menuItem->getChildren() as $child)
            {
                ?>

                    <?php echo $child->getLabel(); ?> <a href="?m=menu&act=deleteChild&mID=<?php echo $menuItem->getMenuId(); ?>&cID=<?php echo $child->getMenuId(); ?>">Delete</a>

                <?php
            }
        }
        else
        {
            echo '<p>No children</p>';
        }

    ?>
    
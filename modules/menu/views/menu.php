<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ragnar
 * Date: 5/3/12
 * Time: 10:08 PM
 * To change this template use File | Settings | File Templates.
 */

?>

<nav>
    <ol>
<?php foreach ($data['menu'] as $menu) : ?>

<?php if ($menu->isParent() && $menu->getLabel() != 'Hjem') : ?>
    <li><a href="?pID=<?php echo $menu->getMenuId(); ?>&<?php echo $menu->getLink(); ?>"><?php echo $menu->getLabel(); ?></a></li>
<?php else : ?>
    <li><a href="<?php echo $menu->getLink(); ?>"><?php echo $menu->getLabel(); ?></a></li>
<?php endif; ?>

<?php endforeach; ?>
    </ol>
</nav>

<?php if (isset($data['submenu'])) : ?>

<nav>
    <ol>
        <?php foreach ($data['submenu'] as $menu) : ?>

        <?php if ($menu->isParent()) : ?>
            <li><a href="?pID=<?php echo $menu->getMenuId(); ?>"><?php echo $menu->getLabel(); ?></a></li>
            <?php else : ?>
            <li><a href="<?php echo $menu->getLink(); ?>"><?php echo $menu->getLabel(); ?></a></li>
            <?php endif; ?>

        <?php endforeach; ?>
    </ol>
</nav>
<?php endif; ?>
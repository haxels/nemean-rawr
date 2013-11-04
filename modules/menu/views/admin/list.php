<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ragnar
 * Date: 4/16/12
 * Time: 10:41 PM
 * To change this template use File | Settings | File Templates.
 */

$menus = $data['menu'];

?>

<h3>Menu manager</h3>
<a href="?m=menu&act=add">Add new menu</a>

<table>
    <thead>
        <tr>
            <th>Label</th>
            <th>Link</th>
            <th>Children</th>
            <th>Operations</th>
    </thead>
    <tbody>
        <?php foreach ($menus as $menu) : ?>
            <tr>
                <td align="center"><?php echo $menu->getLabel(); ?></td>
                <td align="center"><?php echo $menu->getLink(); ?></td>
                <td align="center"><?php echo ($menu->hasChildren()) ? 'Yes' : 'No'; ?></td>
                <td align="center">
                    <a href="?m=menu&act=edit&mID=<?php echo $menu->getMenuId(); ?>">Edit</a> |
                    <a href="?m=menu&act=delete&mID=<?php echo $menu->getMenuId(); ?>">Delete</a> |
                    <a href="?m=menu&act=moveMenu&mID=<?php echo $menu->getMenuId(); ?>&up=1">Up</a>
                    <a href="?m=menu&act=moveMenu&mID=<?php echo $menu->getMenuId(); ?>&up=0">Down</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
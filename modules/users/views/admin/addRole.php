<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 11.06.12
 * Time: 23:49
 * To change this template use File | Settings | File Templates.
 */
    $user_id = (isset($_GET['uID'])) ? $_GET['uID'] : 0;
?>

<h3>Add role</h3>

Roles:

<ol>
<?php foreach ($data['roles'] as $role) : ?>
    <li><?php echo $role->getRole(); ?> | <a href="?m=users&act=doAddRole&uID=<?php echo $user_id; ?>&rID=<?php echo $role->getRole_id(); ?>">Add</a> </li>
<?php endforeach; ?>
</ol>
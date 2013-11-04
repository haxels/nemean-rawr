<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 11.06.12
 * Time: 23:11
 * To change this template use File | Settings | File Templates.
 */

$uID = (isset($_GET['uID'])) ? $_GET['uID'] : 0;
?>

<h3>User permisssions</h3>

<a href="?m=users&act=addRole&uID=<?php echo $uID; ?>">Add Role</a> <br />

Roller: <?php echo count($data['roles']); ?>

<ol>
<?php foreach ($data['roles'] as $role) : ?>
    <li><?php echo $role->getRole(); ?> <a href="?m=users&act=deleteRole&uID=<?php echo $uID; ?>&rID=<?php echo $role->getRole_id(); ?>">X</a> </li>
<?php endforeach; ?>
</ol>
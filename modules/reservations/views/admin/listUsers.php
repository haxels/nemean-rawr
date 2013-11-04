<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 14.06.12
 * Time: 00:01
 * To change this template use File | Settings | File Templates.
 */
?>

<ol>
<?php foreach ($data['users'] as $user) : ?>
    <li><a href="?m=reservations&act=reserveSeat&sID=<?php echo $data['seat_id'] ;?>&uID=<?php echo $user->getUserId(); ?>"><?php echo $user->getName(); ?></a> </li>
<?php endforeach; ?>
</ol>
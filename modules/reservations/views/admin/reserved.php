<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 13.06.12
 * Time: 23:12
 * To change this template use File | Settings | File Templates.
 */
?>

<h3>Seat: <?php echo $data['seat_id']; ?></h3>
Reserved to <?php echo $data['user']->getName(); ?>

<a href="?m=users&act=view&uID=<?php echo $data['user']->getUserId(); ?>">View user</a> |
<a href="?m=reservations&act=delete&sID=<?php echo $data['seat_id']; ?>">Delete reservation</a>
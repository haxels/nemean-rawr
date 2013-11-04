<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 14.06.12
 * Time: 22:41
 * To change this template use File | Settings | File Templates.
 */
?>
<h3>Available seat: <?php echo $data['seat_id']; ?></h3>

    <a href="?m=reservations&dAct=dReserveSeat&sID=<?php echo $data['seat_id']; ?>">Reserve</a>
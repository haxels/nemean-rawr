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
    Available



<a href="?m=reservations&act=reserveSeat&sID=<?php echo $data['seat_id']; ?>">Reserve to someone</a>
<a href="?m=reservations&act=lockSeat&sID=<?php echo $data['seat_id']; ?>">Lock seat</a>
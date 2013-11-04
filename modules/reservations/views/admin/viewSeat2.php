<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 13.06.12
 * Time: 10:25
 * To change this template use File | Settings | File Templates.
 */
?>
<h3>Seat: <?php echo $data['seat_id'];?></h3>

<?php
switch ($data['map']->checkSeat($data['seat_id']))
{
    case Map::AVAILABLE:
        echo 'Available';
        break;

    case Map::RESERVED:
        $r = $data['map']->getReservation($data['seat_id']);
        echo 'Reserved to ' . $r['user']->getName();
        break;

    case Map::CURRENT_USER:
        $r = $data['map']->getReservation($data['seat_id']);
        echo $r['user']->getFirstname() . ', this is your seat';
        break;

    case Map::ILLEGAL:
        echo 'Illegal';
        break;
}
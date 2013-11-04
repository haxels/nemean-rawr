<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 11.09.12
 * Time: 17:30
 * To change this template use File | Settings | File Templates.
 */

?>
<hr />
<ul>
    <li>Plasser totalt: <?php echo $data['map']->getSeats(); ?></li>
    <li>Ledige plasser: <?php echo $data['map']->getFreeSeats(); ?></li>
    <li>Reserverte plasser: <?php echo $data['map']->getNumReservations(); ?></li>
</ul>
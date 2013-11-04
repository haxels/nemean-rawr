<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 13.06.12
 * Time: 00:13
 * To change this template use File | Settings | File Templates.
 */
    $type = $data['reservation']->getType();
?>
Seat: <?php echo $data['reservation']->getSeatId(); ?>

<br />

<?php if ($data['user'] instanceof User) : ?>

Reservert til: <?php echo $data['user']->getName(); ?>

<?php elseif ($type == 1) : ?>

LOCKED

<?php else : ?>

    LEDIG

<?php endif; ?>


<?php

    /**
     * Laste in view basert på type plass i stede for if else sånn som det er nå?????
     */

?>
<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 11.10.12
 * Time: 12:37
 * To change this template use File | Settings | File Templates.
 */

?>
<h2>Kiosk</h2>
<a href="?m=kiosk">Start</a> | <a href="?m=kiosk&act=listDelivered">Vis leverte</a> |
<a href="?m=kiosk&qAct=<?php echo ($data['open']) ? 'close' : 'open'; ?>"><?php echo ($data['open']) ? 'Stenge' : 'Åpne'; ?></a>

    <h3><?php echo $data['title']; ?></h3>
<table>
    <tr>
        <td>OID</td>
        <td>BID</td>
        <td>Navn</td>
        <td>Produkter</td>
        <td>Pris</td>
        <td>Operations</td>
    </tr>
    <?php foreach ($data['orders'] as $order) : ?>
    <tr>
        <td width="5%"><?php echo $order->getOrderId(); ?></td>
        <td width="5%"><?php echo $order->getUserId(); ?></td>
        <td><?php echo '<span style="float: right;">( '.$order->getSeatId().' )</span> '.$order->getName(); ?></td>
        <td>
            <table>
                <tr>
                    <td><img src="site/img/ordericons/burger.png" height="50" width="50" <?php echo ($order->hasProduct("Burger") == true) ? "" : "hidden" ?>/></td>
                    <td width="50"><img src="site/img/ordericons/pizza.png" height="50" width="50" <?php echo ($order->hasProduct("Pizza") == true) ? "" : "hidden" ?>/></td>
                    <td width="50"><img src="site/img/ordericons/ost.png" height="50" width="50" <?php echo ($order->hasProduct("Ost") == true) ? "" : "hidden" ?> /></td>
                    <td width="50"><img src="site/img/ordericons/dressing.png" height="50" width="50" <?php echo ($order->hasProduct("Hamburgerdressing") == true) ? "" : "hidden" ?> /></td>
                    <td width="50"><img src="site/img/ordericons/ketchup.png" height="50" width="50"  <?php echo ($order->hasProduct("Ketchup") == true) ? "" : "hidden" ?>/></td>
                    <td width="50"><img src="site/img/ordericons/mais.png" height="50" width="50" <?php echo ($order->hasProduct("Mais") == true) ? "" : "hidden" ?> /></td>
                    <td width="50"><img src="site/img/ordericons/salat.png" height="50" width="50" <?php echo ($order->hasProduct("Isbergsalat") == true) ? "" : "hidden" ?> /></td>
                    <td width="50"><img src="site/img/ordericons/tomat.png" height="50" width="50" <?php echo ($order->hasProduct("Tomat") == true) ? "" : "hidden" ?> /></td>
                </tr>
            </table>
        </td>
        <td width="5%">
            <?php echo $order->getPrice(); ?>
        </td>
        <td width="10%">
            <a href="?m=kiosk&qAct=<?php echo ($order->getDelivered() == 0) ? 'deliver' : 'undeliver'; ?>&order_id=<?php echo $order->getOrderId(); ?>"><?php echo ($order->getDelivered() == 0) ? 'Lever' : 'Ikke levert'; ?></a>
            | <a href="?m=kiosk&qAct=delete&order_id=<?php echo $order->getOrderId(); ?>">Slett</a>
        </td>
    </tr>

    <?php endforeach; ?>
</table>

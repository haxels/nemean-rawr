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
            <?php foreach ($order->getProducts() as $product) : ?>
                <img src="resources/img/kiosk/img/products/<?php echo $product->getImage(); ?>" height="30" width="30" />
            <?php endforeach; ?>
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

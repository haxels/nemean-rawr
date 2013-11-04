<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 12.06.12
 * Time: 23:45
 * To change this template use File | Settings | File Templates.
 */
//include 'menu.php';
?>
<div id="map" class="mapDiv adminPopup">
    <button type="button" class="close x" >&times;</button>
    <h3>Plasskart</h3>
    <img src="resources/site/img/design/scene.png" style="margin-left: 100px;"/>
    <div class="evenDivider">
        <?php $data['map']->printSection(1, 224); ?>
    </div>
</div>
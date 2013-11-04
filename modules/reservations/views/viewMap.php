<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 14.06.12
 * Time: 22:37
 * To change this template use File | Settings | File Templates.
 */
?>
<section id="main" xmlns="http://www.w3.org/1999/html">
<h3>Plasskart</h3>


<div class="centerDiv">
    <div class="infoBarPanel">
    <div class="infoBar">
        <a class="mapAvailableInfo"></a>
        <p>Ledig</p>
    </div>

    <div class="infoBar">
        <a class="mapReservedInfo"></a>
        <p>Reservert</p>
    </div>

    <div class="infoBar">
        <a class="mapCurrentUserInfo"></a>
        <p>Min plass</p>
    </div>

    <div class="infoBar">
        <a class="mapLockedInfo"></a>
        <p>Låst</p>
    </div>
    </div>

    <br />



    <div class="mapDiv">
        <img src="resources/site/img/design/scene.png" style="margin-left: 100px;"/>
        <div class="evenDivider">
            <?php $data['map']->printSection(1, 224); ?>
</div>
            <!-- <img src="resources/site/img/design/exit.png" style="position: absolute; top: 320px; left: -110px;" /> -->
    </div>


</section>
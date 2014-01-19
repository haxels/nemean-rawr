<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 14.06.12
 * Time: 22:37
 * To change this template use File | Settings | File Templates.
 */
?>
<section id="registrationMap">
    <h3>Plasskart</h3>

    <div class="centerDiv">

        <div class="infoBarPanel">

            <div class="infoBar">
                <a class="mapAvailableInfo"></a>
                <span>Ledig</span>
            </div>

            <div class="infoBar">
                <a class="mapReservedInfo"></a>
                <span>Reservert</span>
            </div>

            <div class="infoBar">
                <a class="mapCurrentUserInfo"></a>
                <span>Min plass</span>
            </div>

            <div class="infoBar">
                <a class="mapLockedInfo"></a>
                <span>Låst</span>
            </div>
        </div>

        <div class="mapDiv">
            <h4>Scene</h4>
            <div class="evenDivider">
                <?php $data['map'] -> printSection(1, 160); ?>
            </div>
            <!-- <img src="resources/site/img/design/exit.png" style="position: absolute; top: 320px; left: -110px;" /> -->
        </div>
    </div>
</section>
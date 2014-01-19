<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 04.07.12
 * Time: 12:49
 * To change this template use File | Settings | File Templates.
 */
?>

                 
                <?php ($data['left'] != null) ? $data['left']->leftContent() : ''; ?>
                <a class="X" href="#">X</a>
                <div class="formBox">
                    <?php require_once("forms.php")?>
                </div>

                <? if (isset($_GET['m']) && $_GET['m'] =='reservations') : ?>
                <?php
                    if ($session->isAuthorized(['Developer', 'Crew'])){
                ?>
                <button id="liveModeOnBtn">Live mode on</button>
                <button id="liveModeOffBtn">Live mode off</button>
                 <?php } ?>
                <div data-update="map.php" data-refresh-interval="500">
                <? endif;  ?>
                <?php
                if ($data['content'] != null)
                {
                  $data['content']->display();
                }
                ?>

                <? if (isset($_GET['m']) && $_GET['m'] =='reservations') : ?>
                </div>
                <? endif;  ?>
        </div>
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

                <?php
                if ($data['content'] != null)
                {
                  $data['content']->display();
                }
                ?>
        </div>

            
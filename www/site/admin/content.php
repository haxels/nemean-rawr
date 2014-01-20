<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 16.07.12
 * Time: 13:22
 * To change this template use File | Settings | File Templates.
 */
?>
    <div class="container">

            <section>
                <?php
                    if ($data['content'] != null)
                    {
                        $data['content']->display();
                    }
                ?>
                <br /><br /><br /><br />
            </section>

    </div>
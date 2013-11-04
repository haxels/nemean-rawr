<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 14.04.12
 * Time: 00:03
 * To change this template use File | Settings | File Templates.
 */

$article = $data['article'];
?>
<section id="main">
    <article>
        <h1><?php echo $article->getTitle(); ?></h1>
        <br>
        <div class="ingress"><i><?php echo stripcslashes($article->getIngress()); ?></i></div>
        <div class="text"><?php echo stripcslashes($article->getText()); ?></div>
        <br><br>

        <?php
        if($article->isPublished())
        {?>
            <span class="author"><?php echo $article->getUser()->getName(); ?> <br>

            <div id="date"><?php echo $article->getPublish_date(); ?></div>
            <?php
        }
        ?>



        </span>
    </article>
</section>
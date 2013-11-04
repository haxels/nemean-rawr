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

<article>
    <h1><?php echo $article->getTitle(); ?></h1>
    <span class="author">Skrevet av: <?php echo $article->getUser()->getName(); ?></span>
    <div class="ingress"><?php echo stripcslashes($article->getIngress()); ?></div>
    <div class="text"><?php echo stripcslashes($article->getText()); ?></div>
</article>
<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 4/28/12
 * Time: 5:38 PM
 * To change this template use File | Settings | File Templates.
 */


?>




<?php
    for($i=0; $i < count($data['articles']); $i++)
    {
        $article = $data['articles'][$i];

        if($i >= 0 && $i<5)
        { ?>
            <a href="?m=articles&act=view&artID=<?php echo $article->getArticle_id()?>">
            <section class="aList">
                <p><img src="<?php echo ($article->getPicture() != '') ? 'resources/img/articles/'.$article->getPicture() : 'resources/site/img/art_standard.png'; ?>" /></p>
                <br>
                <p>
                    <?php echo stripcslashes($article->getIngress()); ?>
                </p>
                <h4 style="float: right;"> Les mer</h4>
            </section>
            </a>
           <?php
        }
        
    }



?>
        
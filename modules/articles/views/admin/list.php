<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 13.04.12
 * Time: 20:16
 * To change this template use File | Settings | File Templates.
 */

?>
<div id="header"> <h3>Artikler</h3> </div>
<ul class="nav nav-tabs">
<li><a href="?m=articles&act=add">Opprett artikkel</a></li>
</ul>
<table class="table table-hover table-bordered table-striped" id="p">
    <thead>
        <tr>
            <th>Tittel</th>
            <th>Forfatter</th>
            <th>Opprettet</th>
            <th>Publisert</th>
            <th>Operasjoner</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data['articles'] as $article) : ?>
            <?php
                $editLink    = (isset($_GET['m'])) ? '?m='.$_GET['m'].'&act=edit&artID='.$article->getArticle_id() : '';
                $publishLink = (isset($_GET['m'])) ? '?m='.$_GET['m'].'&act=publish&artID='.$article->getArticle_id() : '';
                $deleteLink = (isset($_GET['m'])) ? '?m='.$_GET['m'].'&act=delete&artID='.$article->getArticle_id() : '';
                $viewLink = (isset($_GET['m'])) ? '?m='.$_GET['m'].'&act=view&artID='.$article->getArticle_id() : '';
            ?>
            <tr>
                <td><?php echo $article->getTitle(); ?></td>
                <td align="center"><?php echo $article->getUser()->getName(); ?></td>
                <td align="center"><?php echo $article->getDate_created(); ?></td>
                <td align="center"><?php echo ($article->isPublished()) ? $article->getTimeToPublish() : 'No'; ?></td>
                <td align="center">
                    <div class="btn-group">
                    <a class="btn" href="<?php echo $editLink; ?>" title="Rediger artikkel"> <i class="icon-pencil"> </i></a> |
                    <a class="btn" href="<?php echo $publishLink; ?>" title="<?php echo ($article->isPublished()) ? 'Avpubliser artikkel' : 'Publiser artikkel'; ?>"> <?php echo ($article->isPublished()) ? '<i class="icon-ban-circle"> </i>' : '<i class="icon-eye-open"> </i>'; ?></a> |
                    <a class="btn" href="<?php echo $deleteLink; ?>" title="Slett artikkel"><i class="icon-remove"> </i></a> |
                    <a class="btn" href="<?php echo $viewLink; ?>" title="Se på artikkel"><i class="icon-search"> </i></a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
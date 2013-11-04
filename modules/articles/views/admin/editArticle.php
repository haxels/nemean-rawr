<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 15.04.12
 * Time: 03:19
 * To change this template use File | Settings | File Templates.
 */
$article = (isset($data['article'])) ? $data['article'] : null;
if ($article == null)
{
    $errors = (isset($data['errors'])) ? $data['errors'] : array();

    foreach ($errors as $key => $value)
    {
        echo $value."<br />";
    }
}

$user = $data['user']; ?>

<h3>Edit article</h3>

<form class="form-inline" action="" method="POST">

    <div class="controls-row">
        <input name="title" class="span3" type="text" placeholder="Tittel" value="<?php echo (isset($_POST['title'])) ? $_POST['title'] : $article->getTitle(); ?>" />


        <?php if ($user->isInRole(array('Publisher'))) : ?>
        <input name="publish"class="span3" type="text" placeholder="Publiseringsdato - dd/mm/yyyy" value="<?php echo (isset($_POST['publish'])) ? $_POST['publish'] : date('d/m/Y', strtotime($article->getPublish_date())); ?>" />

        <input name="time"class="span3" type="text" placeholder="Tidspunkt - hh:mm" value="<?php echo (isset($_POST['time'])) ? $_POST['time'] : date('H:i', strtotime($article->getPublish_date())); ?>" />

        <?php endif; ?>
    </div>
    <div class="controls-row">
        <input id="artImage" class="span3" name="image" placeholder="Bilde" type="text" value="<?php echo (isset($_POST['image'])) ? $_POST['image'] : $article->getPicture(); ?>"/>

        <select name="category" class="span3">
            <option value="0"><-- Velg kategori --></option>
            <?php foreach ($data['categories'] as $category) : ?>
            <option value="<?php echo $category['category_id']; ?>" <?php echo ($category['category_id'] == $article->getCategoryID()) ? 'SELECTED' : ''; ?>><?php echo $category['category']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <textarea placeholder="Ingress" class="span6" name="ingress"><?php echo (isset($_POST['ingress'])) ? $_POST['ingress'] : stripcslashes($article->getIngress()); ?></textarea>

    <textarea id="text" placeholder="Skriv artikkel her" name="text"><?php echo (isset($_POST['text'])) ? $_POST['text'] : stripcslashes($article->getText()); ?></textarea>
    <script>
        var editor = CKEDITOR.replace('text');
        CKFinder.setupCKEditor(editor, '../plugins/ckfinder/');
    </script>
    <input name="author_id" type="hidden" value="<?php echo (isset($_POST['author_id'])) ? $_POST['author_id'] : $article->getAuthorId(); ?>" />
    <div class="controls-row">
        <hr>
        <input name="submit" class="btn btn-primary" type="submit" value="Lagre" />

    </div>
</form>
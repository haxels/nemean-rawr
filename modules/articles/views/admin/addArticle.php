<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 13.04.12
 * Time: 18:11
 * To change this template use File | Settings | File Templates.
 */

$errors = (isset($data['errors'])) ? $data['errors'] : array();

$user = $data['user'];

foreach ($errors as $key => $value)
{
    echo $value."<br />";
}
    //TODO - Must be able to set a publish date, if authorized
?>
<h3>Add new article</h3>
<form class="form-inline" action="" method="POST">

    <div class="controls-row">
     <input name="title" class="span3" type="text" placeholder="Tittel" value="<?php echo (isset($_POST['title'])) ? $_POST['title'] : ''; ?>" />


        <?php if ($user->isInRole(array('Publisher'))) : ?>
            <input name="publish"class="span3" type="text" placeholder="Publiseringsdato - dd/mm/yyyy" value="<?php echo (isset($_POST['publish'])) ? $_POST['publish'] : ''; ?>" />

            <input name="time"class="span3" type="text" placeholder="Tidspunkt - hh:mm" value="<?php echo (isset($_POST['time'])) ? $_POST['time'] : ''; ?>" />

        <?php endif; ?>
    </div>
    <div class="controls-row">
        <input id="artImage" class="span3" name="image" placeholder="Bilde" type="text" />

            <select name="category" class="span3">
                <option value="0">Velg kategori</option>
                <?php foreach ($data['categories'] as $category) : ?>
                <option value="<?php echo $category['category_id']; ?>"><?php echo $category['category']; ?></option>
                <?php endforeach; ?>
            </select>
    </div>
                <textarea placeholder="Ingress" class="span6" name="ingress"><?php echo (isset($_POST['ingress'])) ? $_POST['ingress'] : ''; ?></textarea>

                    <textarea id="text" placeholder="Skriv artikkel her" name="text"><?php echo (isset($_POST['text'])) ? $_POST['text'] : ''; ?></textarea>
            <script>
                var editor = CKEDITOR.replace('text');
                CKFinder.setupCKEditor(editor, '../plugins/ckfinder/');
            </script>
    <div class="controls-row">
        <hr>
            <input name="submit" class="btn btn-primary" type="submit" value="Lagre" />

    </div>
</form>
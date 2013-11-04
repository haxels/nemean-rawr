<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ragnar
 * Date: 5/1/12
 * Time: 1:10 PM
 * To change this template use File | Settings | File Templates.
 */

$errors = (isset($data['errors'])) ? $data['errors'] : array();

?>

<h2>Add new menu</h2>
<a href="?m=menu&act=add&type=internal">Internal link</a> |
<a href="?m=menu&act=add&type=external">External link</a>

    <form action="" method="POST">
        <ul>
            <li>
                <label for="label">Label:</label>
                <input name="label" type="text" value="" />
                <span><?php echo (isset($errors['label'])) ? $errors['label'] : ''; ?></span>
            </li>

            <?php if (isset($_GET['type']) && $_GET['type'] == 'external') : ?>
            <li>
                <label for="link">Link:</label>
                <input name="link" type="text" value="" />
                <span><?php echo (isset($errors['link'])) ? $errors['link'] : ''; ?></span>
            </li>

            <?php elseif (isset($_GET['type']) && $_GET['type'] == 'internal') : ?>
            <li>
                <label for="link">Link:</label>
                <select name="link">
                    <option value="0"><-- Velg artikkel --></option>
                <?php foreach ($data['articles'] as $article) : ?>
                    <option value="<?php echo $article->getArticle_id(); ?>"><?php echo $article->getTitle(); ?></option>
                <?php endforeach; ?>
                </select>
                <span><?php echo (isset($errors['link'])) ? $errors['link'] : ''; ?></span>
            </li>
            <?php endif; ?>

            <li>
                <label for="parent">Parent:</label>
                <select name="parent">
                    <option value="0">Is parent</option>
                    <?php foreach ($data['parents'] as $parent) : ?>
                        <option value="<?php echo $parent->getMenuId(); ?>"><?php echo $parent->getLabel(); ?></option>
                    <?php endforeach; ?>
                </select>
            </li>
            <li>
                <label for="submit">&nbsp;</label>
                <input name="submit" type="submit" value="Save" />
            </li>
        </ul>
    </form>
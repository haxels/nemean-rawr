<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 13.04.12
 * Time: 20:16
 * To change this template use File | Settings | File Templates.
 */
include('menu.php');
?>


<div id="header"> <h3>Presentasjoner</h3> </div>

<table class="table table-hover table-bordered table-striped" id="p">
    <thead>
    <tr>
        <th>#</th>
        <th>Tittel</th>
        <th>Operasjoner</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($data['slides'] as $slide) : ?>

    <tr>
        <td><?php echo $slide->getSlideId(); ?></td>
        <td><?php echo $slide->getTitle(); ?></td>
        <td align="center">
            <div class="btn-group">
                <a class="btn" href="?m=presentation&act=edit&slide_id=<?php echo $slide->getSlideId(); ?>">Rediger</a>
                <a class="btn" href="?m=presentation&qAct=delete&slide_id=<?php echo $slide->getSlideId(); ?>">Slett</a>
            </div>
        </td>
    </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 28.06.12
 * Time: 12:47
 * To change this template use File | Settings | File Templates.
 */
?>
<?php include 'menu.php'; ?>
<h3>Compoer</h3>

<a class="btn btn-popup" href="#newCompo">Opprett compo</a>
<a class="btn btn-danger" href="#">Slett alle compoer</a>

<table class="table table-hover table-bordered" id="p">
    <thead>
    <tr>
        <th>Componavn</th>
        <th>Påmelding</th>
        <th>Start</th>
        <th>Lag</th>
        <th>Operasjoner</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($data['compos'] as $team) : ?>
    <tr>
        <td><?php echo $team->getCompoName(); ?></td>
        <td><?php echo $team->getTimeLeft(); ?></td>
        <td><?php echo $team->getTimeToEventStart(); ?></td>
        <td><?php echo $team->getNumEntries(); ?></td>
        <td>
            <div class="btn-group">
                <a class="btn" href="?m=compos&act=viewCompo&cID=<?php echo $team->getCompoID(); ?>" title="Se på compo"> <i class="icon-search"> </i></a> |
                <a class="btn" href="#" title="Slett compo"><i class="icon-remove"> </i></a> |
            </div>
        </td>
    </tr>
    <?php endforeach; ?>

    </tbody>
    </table>
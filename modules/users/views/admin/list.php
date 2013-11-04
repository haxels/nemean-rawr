<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ragnar
 * Date: 5/11/12
 * Time: 4:37 PM
 * To change this template use File | Settings | File Templates.
 */

$count = count($data['users']);



?>
<?php include 'menu.php'; ?>
<div id="header"> <h3>Brukere</h3> </div>

<div class="btn-group">
    <a class="btn btn-popup" href="#addUser">Ny bruker</a>
</div>

<?php if ($count != 0) : ?>


<table class="table table-hover table-bordered" id="p">

    <thead>
    <th>#</th>
    <th>Navn</th>
    <th>Aktivert</th>
    <th>Betalt</th>
    <th>Operasjoner</th>
    </thead>

    <tbody>

        <?php foreach ($data['users'] as $user) : ?>

    <tr>
        <td><?php echo $user->getUserId(); ?></td>
        <td class="name"><?php echo $user->getName(); ?></td>
        <td class="active"><?php echo ($user->getActivated()) ? 'Ja' : 'Nei'; ?></td>
        <td class="betalt"><?php echo ($user->isInRole(array('Paid'))) ? 'Ja' : 'Nei'; ?></td>
        <td>
            <div class="btn-group">
                <a title="<?php echo ($user->getActivated()) ? 'Fjern aktivering' : 'Aktiver'; ?>" class="btn" href="?m=users&act=activate&uID=<?php echo $user->getUserId(); ?>"><?php echo ($user->getActivated()) ? '<i class="icon-remove-sign"></i>' : '<i class="icon-ok-sign"></i>'; ?></a>
                <a title="<?php echo ($user->isInRole(array('Paid'))) ? 'Fjern betaling' : 'Registrer betaling'; ?>"class="btn" href="?m=users&act=paid&uID=<?php echo $user->getUserId(); ?>"><?php echo ($user->isInRole(array('Paid'))) ? '<i class="icon-thumbs-down"></i>' : '<i class="icon-thumbs-up"></i>'; ?></a>
                <a title="Slett" class="btn" href="?m=users&act=delete&uID=<?php echo $user->getUserId(); ?>"><i class="icon-remove"> </i></a>
                <a title="Vis" class="btn user-btn" id="v<?php echo $user->getUserId(); ?>" href="#"><i class="icon-search"></i></a>
            </div>
        </td>
    </tr>
        <?php endforeach; ?>

    </tbody>

</table>

<?php else : ?>

No results returned

<?php endif; ?>
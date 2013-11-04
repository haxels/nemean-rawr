<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 28.06.12
 * Time: 15:07
 * To change this template use File | Settings | File Templates.
 */
?>
<?php include 'menu.php'; ?>
<h3>Teams</h3>
<table class="table table-hover table-bordered" id="p">
    <thead>
    <tr>
        <th>Name</th>
        <th>Leader</th>
        <th>Competitors</th>
        <th>Operations</th>
    </tr>
    </thead>
    <tbody>
<?php foreach ($data['teams'] as $team) : ?>
    <tr>
        <td><?php echo $team->getTeamName(); ?></td>
        <td><?php echo $team->getTeamLeader()->getName(); ?></td>
        <td><?php echo $team->getNumCompetitors(); ?></td>
        <td>
            <a href="?m=compos&act=viewTeam&cID=<?php echo $team->getTeamID(); ?>">View</a> |
            <a href="?m=compos&act=view&cID=<?php echo $team->getCompoID(); ?>">Delete</a> |
            <a href="?m=compos&act=view&cID=<?php echo $team->getCompoID(); ?>">Push Down</a> |
            <a href="?m=compos&act=view&cID=<?php echo $team->getCompoID(); ?>">Push Up</a>
        </td>
</tr>
<?php endforeach; ?>
    </tbody>
</table>
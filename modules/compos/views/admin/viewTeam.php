<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 28.06.12
 * Time: 14:47
 * To change this template use File | Settings | File Templates.
 */
$team = $data['team'];
$compos = $data['compos'];
?>

<h3>Viewing team: <?php echo $team->getTeamName(); ?></h3>

<br /> <br />
Leader: <?php echo $team->getTeamLeader()->getName(); ?>
<br /> <br />

<?php if ($team->getNumCompetitors() > 0) : ?>
<h4>Competitors</h4>
<ol>
    <?php foreach ($team->getCompetitors() as $competitor) : ?>
    <li>
        <?php echo $competitor->getName(); ?> -
        <a href="?m=users&act=view&uID=<?php echo $competitor->getCompetitorId(); ?>">View</a>
        <a href="?m=compos&act=deleteTeam&tID=<?php echo $competitor->getCompetitorId(); ?>">Delete</a>
    </li>
    <?php endforeach; ?>
</ol>
<?php endif; ?>

<br /><br />

<?php if (count($compos) > 0) : ?>

    <h4>Compos competing in:</h4>
    <ol>
    <?php foreach ($compos as $compo) : ?>
        <li>
            <a href="?m=compos&act=viewCompo&cID=<?php echo $compo->getCompoID(); ?>"><?php echo $compo->getCompoName(); ?></a> -
            <a href="">X</a>
        </li>
    <?php endforeach; ?>

<?php endif; ?>
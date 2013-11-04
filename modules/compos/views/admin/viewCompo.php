<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 28.06.12
 * Time: 14:06
 * To change this template use File | Settings | File Templates.
 */

$compo = $data['compo'];
?>

<h3>Viewing compo: <?php echo $compo->getCompoName(); ?></h3>

<?php echo $compo->getTimeLeft(); ?>
<br />
<?php echo $compo->getTimeToEventStart(); ?>
<br /> <br />
Responsible: <?php echo $compo->getCompoManager()->getName(); ?>
<br /> <br />
<h4>Entries</h4>
<ol>
    <?php foreach ($compo->getEntries() as $team) : ?>
    <li>
        <?php echo $team->getTeamName(); ?> -
        <a href="?m=compos&act=viewTeam&tID=<?php echo $team->getTeamID(); ?>">View</a>
        <a href="?m=compos&act=deleteTeam&tID=<?php echo $team->getTeamID(); ?>">Delete</a>
    </li>
    <?php endforeach; ?>
</ol>
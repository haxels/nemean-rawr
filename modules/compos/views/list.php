<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 19.10.12
 * Time: 19:00
 * To change this template use File | Settings | File Templates.
 */
?>
<section id="main">
<h2>Compoer</h2>

<table>
    <thead>
    <tr>
        <td>Name</td>
        <td>Signup</td>
        <td>Start</td>
        <td>Teams</td>
        <td>Operations</td>
    </tr>
<?php foreach ($data['compos'] as $compo) : ?>
    <tr>
        <td><a href="?m=compos&act=viewCompo&cID=<?php echo $compo->getCompoID(); ?>"><?php echo $compo->getCompoName(); ?></a></td>
        <td><?php echo $compo->getTimeLeft(); ?></td>
        <td><?php echo $compo->getTimeToEventStart(); ?></td>
        <td><?php echo $compo->getNumEntries(); ?></td>
    </tr>

<?php endforeach; ?>
</table>
</section>
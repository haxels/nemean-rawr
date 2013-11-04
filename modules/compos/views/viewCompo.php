<?php
/**
 * Created by JetBrains PhpStorm.
 * User: havardaxelsen
 * Date: 10/19/12
 * Time: 7:14 PM
 *
 */
    $compo = $data['compo'];
    $teams = $compo->getEntries();


    ?>

<div id ="viewCompo">

    <h1> <?php echo $compo->getCompoName(); ?></h1><br><br>

    Compo-ansvarlig: <?php echo $compo->getCompoManager()->getName(); ?><br>

    Påmelding mellom <?php echo $compo->getSignupStart(); ?> og <?php echo $compo->getSignupDue();?> <br><br><br>

    <a id="<?php echo $compo->getCompoID() ?>_<?php echo $compo->getNumCompetitors();?>" class="compoReg">Meld deg på her!</a><br><br>

    Antall spillere per lag: <?php echo $compo->getNumCompetitors(); ?><br>


    <table>
        <tr>
            <td>Name</td>
            <td>Manager</td>
        </tr>
        <?php foreach ($teams as $team) : ?>
        <tr>
            <td><?php echo $team->getTeamName(); ?></td>
            <td><?php echo $team->getTeamLeader()->getName(); ?></td>

        </tr>

        <?php endforeach; ?>
    </table>




</div>
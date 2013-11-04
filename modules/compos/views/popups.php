<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 19.10.12
 * Time: 19:16
 * To change this template use File | Settings | File Templates.
 */
?>

<div id="addTeamDiv" class="popupDiv">

    <a class="X" href="#">X</a>
    <p>
        Du som melder på laget blir autmatisk registrert på laget og trenger derfor ikke skrive inn ditt navn
        i skjemaet.
    </p>
    <form id="addTeamForm" action="" method="POST">
        <h4>Påmelding for compo</h4>
        <hr />
        <li>
            <label for="team_name">Lagnavn:</label>
            <input name="team_name" type="text" />
            <span class="hidden"></span>
        </li>



            <input name="team_leader" type="hidden" value="<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0; ?>" />
            <span class="hidden"></span>

        <li>
            <label>&nbsp;</label>
            <input type="submit" id="submit" name="submit" value="Send"/>
        </li>
        <div class="loader"><img src="resources/site/img/design/loader.gif" /></div>
    </form>

</div>
<?php
$settings = $data['settings'];

?>

<form id="settingsForm" action="" method="">
    <fieldset>
        <legend>Innstillinger</legend>

        <label class="checkbox">
            <input id="closed" type="checkbox" <?php echo ($settings['comporeg_open']->getValue() == 1) ? 'checked=""' : '' ?>/>Åpent
        </label>

    </fieldset>
    <hr>

    <input class="btn btn-primary" type="submit" name="submit" value="Bekreft" />
    <a class="btn btn-danger">Avbryt</a>
</form>
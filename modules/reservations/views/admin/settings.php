<?php
 $settings = $data['settings'];

?>

<form id="settingsForm" action="" method="">
    <fieldset>
        <legend>Settings</legend>

        <label class="checkbox">
            <input id="aisle" type="checkbox" <?php echo ($settings['aisle']->getValue() == 1) ? 'checked=""' : '' ?>/> Midtgang
        </label>

        <label class="checkbox">
            <input id="inverse" type="checkbox" <?php echo ($settings['inverse']->getValue() == 1) ? 'checked=""' : '' ?>/>Inverse
        </label>

        <label class="checkbox">
            <input id="closed" type="checkbox" <?php echo ($settings['locked']->getValue() == 0) ? 'checked=""' : '' ?>/>Åpent
        </label>

        <label>Antall seter</label>
        <input type="text" value="<?php echo $settings['seats']->getValue()?>">

        <label>Seter per rad</label>
        <input type="text" value="<?php echo $settings['width']->getValue()?>">
    </fieldset>
    <fieldset>
        <legend>Forhåndsdefinert</legend>

        <a class="btn">Hemnehallen</a>
        <a class="btn">Samfunnshuset</a>

    </fieldset>
    <hr>
    <input class="btn btn-primary" type="submit" name="submit" value="Bekreft" />
    <a class="btn btn-danger">Avbryt</a>
</form>
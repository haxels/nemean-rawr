<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ragnar
 * Date: 5/11/12
 * Time: 5:30 PM
 * To change this template use File | Settings | File Templates.
 */

$user = $data['user'];
$authy = $data['authy'];

?>
<div id="" class="">
<h2>Vis bruker</h2>

<!--<ul class="nav nav-tabs">-->
    <div class="btn-group">
    <a title="<?php echo ($authy->getActivated()) ? 'Fjern aktivering' : 'Aktiver'; ?>" class="btn" href="?m=users&act=activate&uID=<?php echo $user->getUserId(); ?>"><?php echo ($authy->getActivated()) ? '<i class="icon-remove-sign"></i>' : '<i class="icon-ok-sign"></i>'; ?></a>
    <a title="Slett" class="btn" href="?m=users&act=delete&uID=<?php echo $user->getUserId(); ?>"><i class="icon-remove"> </i></a>

        <a title="Rettigheter" class="btn dropdown-toggle" data-toggle="dropdown" id="permissions">Rettigheter <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <?php foreach($data['permissions'] as $role) : ?>
            <li><input id="<?php echo $user->getUserId(); ?>" name="<?php echo ($user->isInRole([$role->getRole()])) ? '0' : '1'; ?>" class="chkUpdate" title="" name="<?php echo $role->getRole(); ?>" type="checkbox" value="<?php echo $role->getRole_id(); ?>" <?php echo ($user->isInRole([$role->getRole()])) ? 'checked=checked' : ''; ?> /> <?php echo $role->getRole(); ?></li>
            <?php endforeach; ?>
        </ul>
    <a title="<?php echo ($user->isInRole(array('Paid'))) ? 'Fjern betaling' : 'Registrer betaling'; ?>"class="btn" href="?m=users&act=paid&uID=<?php echo $user->getUserId(); ?>"><?php echo ($user->isInRole(array('Paid'))) ? '<i class="icon-thumbs-down"></i>' : '<i class="icon-thumbs-up"></i>'; ?></a>
    </div>
<!--</ul>-->


    <fieldset class="span2">
        <legend>Personalia</legend>
        <blockquote>
            <strong>Navn</strong><br>
            <?php echo $user->getName(); ?><br><br>

            <strong>Fødselsdato</strong><br>
            <?php echo $user->getBirthdate(); ?></h6>
        </blockquote>
    </fieldset>

    <fieldset class="span3">
        <legend>Kontaktinformasjon</legend>

        <p>
        <blockquote>
        <address>
            <strong><?php echo $user->getName(); ?></strong><br>
            <?php echo $user->getContactInfo()->getAddress()->getStreetAddress(); ?><br>
            <?php echo $user->getContactInfo()->getAddress()->getZipLocation()->getZipcode().", ".$user->getContactInfo()->getAddress()->getZipLocation()->getZipLocation();?><br>
            <abbr title="Phone">P:</abbr> <?php echo $user->getContactInfo()->getTelephone(); ?><br>
            <a href="mailto:#"><?php echo $user->getContactInfo()->getEmail(); ?></a>

        </address>
    </blockquote>
        </p>
    </fieldset>


    <fieldset class="span2">
        <legend>Roller</legend>
        <blockquote>
            <strong>Roller</strong><br><br>
            <?php foreach ($user->getRoles() as $role) : ?>
            <?php echo $role->getRole(); ?> <br>

        <?php endforeach; ?>
        </blockquote>
    </fieldset>

    <fieldset class="span2">
        <legend>Annet</legend>
        <blockquote>
            <strong>Brukernavn</strong><br>
            <?php echo $authy->getUsername(); ?><br><br>
            <strong>Status</strong><br>
            <?php echo ($authy->getActivated()) ? 'Aktivert' : 'Ikke aktivert'; ?><br><br>
            <strong>Registreringsdato</strong><br>
            <?php echo $user->getRegdate(); ?>
        </blockquote>
    </fieldset>

    <?php if ($user->getParent() != null) : ?>

        <fieldset class="span2">

            <legend>Foresatt</legend>
            <blockquote>
                <strong>Navn</strong><br>
                <?php echo $user->getParent()->getName();?><br><br>
                <strong>Email</strong><br>
                <?php echo $user->getParent()->getEmail(); ?><br><br>
                <strong>Phone</strong><br>
                <?php echo $user->getParent()->getTelephone(); ?><br><br>
            </blockquote>
        </fieldset>

    <?php endif; ?>
</div>
<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 29.06.12
 * Time: 00:34
 * To change this template use File | Settings | File Templates.
 */

    require_once MODULEPATH . 'sponsors/classes/SponsorMapper.php';
    require_once SYSPATH . 'NController.php';

    require_once MODULEPATH . 'sponsors/controller/AdminController.php';

    $sm = new SponsorMapper($adapter);

    $module = new AdminController($session, $sm);
    $module->quickActions();
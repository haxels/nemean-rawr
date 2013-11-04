<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 29.06.12
 * Time: 00:23
 * To change this template use File | Settings | File Templates.
 */

    require_once MODULEPATH . 'compos/classes/CompoMapper.php';
    require_once SYSPATH . 'NController.php';
    require_once MODULEPATH . 'compos/controller/AdminController.php';

    $cm = new CompoMapper($adapter);

    $module = new AdminController($session, $cm, $settings);
    $module->quickActions();
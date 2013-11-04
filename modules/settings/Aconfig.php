<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    require_once MODULEPATH . 'settings/classes/SettingsMapper.php';

    require_once SYSPATH . 'NController.php';

    require_once MODULEPATH . 'settings/controller/AdminController.php';

    $sm = new SettingsMapper($adapter);

    $module = new AdminController($session, $sm);


?>
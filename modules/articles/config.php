<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

    require_once MODULEPATH.'/articles/classes/ArticleMapper.php';
    require_once MODULEPATH.'users/classes/ParentsMapper.php';
    require_once MODULEPATH.'users/classes/RoleMapper.php';
    require_once MODULEPATH.'users/classes/UserMapper.php';

    require_once SYSPATH.'NController.php';

    require_once MODULEPATH.'/articles/controller/ArticleController.php';

    $um = new UserMapper($adapter, new ParentsMapper($adapter), new RoleMapper($adapter));
    $am = new ArticleMapper($adapter, new PollMapper($adapter), $um);
    $sm = new SettingsMapper($adapter);

    $module = new ArticleController($session, $um, $am);
    $module->quickActions();


?>

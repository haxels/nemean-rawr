<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 29.06.12
 * Time: 00:28
 * To change this template use File | Settings | File Templates.
 */

    require_once MODULEPATH.'menu/classes/MenuMapper.php';
    require_once MODULEPATH.'articles/classes/ArticleMapper.php';
    require_once MODULEPATH . 'users/classes/ParentsMapper.php';
    require_once MODULEPATH . 'users/classes/RoleMapper.php';
    require_once MODULEPATH.'users/classes/UserMapper.php';
    require_once SYSPATH.'NController.php';
    require_once MODULEPATH.'menu/controller/AdminController.php';


    $mm = new MenuMapper($adapter);
    $um = new UserMapper($adapter, new ParentsMapper($adapter), new RoleMapper($adapter));
    $am = new ArticleMapper($adapter, new PollMapper($adapter), $um);

    $module = new AdminController($session, $mm, $um, $am);
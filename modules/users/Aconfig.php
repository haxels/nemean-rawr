<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    require_once MODULEPATH . 'users/classes/AuthyMapper.php';
    require_once MODULEPATH . 'users/classes/ParentsMapper.php';
    require_once MODULEPATH . 'users/classes/RoleMapper.php';
    require_once MODULEPATH . 'users/classes/UserMapper.php';

    require_once SYSPATH . 'NController.php';
    require_once SYSPATH . 'class.phpmailer.php';
    require_once SYSPATH . 'class.pop3.php';

    require_once MODULEPATH . 'users/controller/AdminController.php';

    $um = new UserMapper($adapter, new ParentsMapper($adapter), new RoleMapper($adapter));
    $am = new AuthyMapper($adapter);

    $module = new AdminController($adapter, $session, $um, $am);


?>
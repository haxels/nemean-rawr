<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 29.06.12
 * Time: 00:31
 * To change this template use File | Settings | File Templates.
 */

    require_once MODULEPATH . 'users/classes/UserMapper.php';
    require_once MODULEPATH . 'users/classes/AuthyMapper.php';
    require_once MODULEPATH . 'users/classes/ParentsMapper.php';
    require_once MODULEPATH . 'users/classes/RoleMapper.php';
    require_once MODULEPATH . 'reservations/classes/Map.php';
    require_once MODULEPATH . 'reservations/classes/Guest.php';
    require_once MODULEPATH . 'reservations/classes/ReservationsMapper.php';
    require_once MODULEPATH . 'reservations/mpdf/mpdf.php';
    require_once SYSPATH . 'NController.php';

    require_once MODULEPATH.'reservations/controller/AdminController.php';

    $um = new UserMapper($adapter, new ParentsMapper($adapter), new RoleMapper($adapter));
    $rm = new ReservationsMapper($adapter);

    $module = new AdminController($session, $settings, $um, $rm);
    $module->quickActions();


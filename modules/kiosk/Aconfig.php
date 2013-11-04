<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 11.10.12
 * Time: 09:57
 * To change this template use File | Settings | File Templates.
 */

require_once MODULEPATH . 'kiosk/classes/ProductMapper.php';
require_once MODULEPATH . 'kiosk/classes/OrderMapper.php';
require_once SYSPATH . 'NController.php';
require_once MODULEPATH . 'kiosk/controller/AdminController.php';

$pm = new ProductMapper($adapter);
$om = new OrderMapper($adapter);

$module = new AdminController($session, $pm, $om, $settings);
$module->quickActions();
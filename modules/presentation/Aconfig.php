<?php
/**
 *
 */

require_once MODULEPATH . 'presentation/classes/PresentationMapper.php';
require_once SYSPATH . 'NController.php';
require_once MODULEPATH . 'presentation/controller/AdminController.php';



$sm = new PresentationMapper($adapter);

$module = new AdminController($session, $sm);
$module->quickActions();
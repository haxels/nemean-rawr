<?php
/**
 *
 */

require_once MODULEPATH . 'presentation/classes/PresentationMapper.php';
require_once SYSPATH . 'NController.php';
require_once MODULEPATH . 'presentation/controller/PresentationController.php';



$sm = new PresentationMapper($adapter);

$module = new PresentationController($session, $sm);
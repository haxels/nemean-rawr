<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
define('SYSPATH', $_SERVER['DOCUMENT_ROOT'].'Zebra/system/');
define('MODULEPATH', $_SERVER['DOCUMENT_ROOT'].'Zebra/modules/');

require_once '../../system/config.php';

require_once SYSPATH. 'page/IMainContent.php';
require_once SYSPATH. 'page/ILeftContent.php';
require_once SYSPATH. 'db/DataMapper.php';
require_once SYSPATH. 'db/IDatabaseAdapter.php';
require_once SYSPATH. 'db/PDOAdapter.php';
require_once SYSPATH. 'Session.php';

require_once 'classes/AuthyMapper.php';
require_once 'classes/ParentsMapper.php';
require_once 'classes/RoleMapper.php';
require_once 'classes/UserMapper.php';

require_once SYSPATH . 'NController.php';
require_once SYSPATH . 'class.phpmailer.php';
require_once SYSPATH . 'class.pop3.php';

require_once 'controller/UserController.php';

$adapter = new PDOAdapter('mysql:host='.DBHOST.';dbname='.DBNAME, DBUSER, DBPASS);

$um = new UserMapper($adapter, new ParentsMapper($adapter), new RoleMapper($adapter));
$am = new AuthyMapper($adapter);
$session = new Session($adapter);
$module = new UserController($session, $um, $am);
$module->quickActions();
?>

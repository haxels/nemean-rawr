<?php
/**
 * Created by PhpStorm.
 * User: Ragnar
 * Date: 1/18/14
 * Time: 8:53 PM
 */
require_once '../system/NConfig.php';
require_once MODULEPATH . 'settings/classes/SettingsMapper.php';
$adapter = new PDOAdapter('mysql:host='.DBHOST.';dbname='.DBNAME, DBUSER, DBPASS);
$session = new Session($adapter);
$settingsMapper = new SettingsMapper($adapter);

//$menu = new MenuController($adapter);

/** Generate site settings  */
$settings = array();

foreach ($settingsMapper->findAll() as $setting)
{
    $settings[$setting->getName()] = $setting;
}
require_once "../modules/reservations/config.php";
$module->viewMap();
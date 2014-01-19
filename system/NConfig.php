<?php
/**
 * Application environment
 *
 * - development
 * - production
 */
    define('ENVIRONMENT', 'development');

    define('SYSPATH', '../system/');
    define('MODULEPATH', '../modules/');
    define('RESOURCEPATH', 'resources/');

    //if (ENVIRONMENT == 'development')
    //{
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
    //}

    /** Set default timezone to Norwegian time */
    date_default_timezone_set('Europe/Oslo');

    require_once SYSPATH.'config.php';
    require_once SYSPATH.'db/PDOAdapter.php';
    require_once SYSPATH.'db/DataMapper.php';

    require_once 'Session.php';

    require_once SYSPATH.'page/ILeftContent.php';
    require_once SYSPATH.'page/IMainContent.php';
    require_once SYSPATH.'page/IRightContent.php';
    require_once SYSPATH.'page/Page.php';


    /** Load helpers */
    require_once 'helpers/validation/Validator.php';
    require_once 'helpers/Uploader.php';
    require_once 'helpers/FileBrowser.php';

?>
<?php

    session_start();

    require_once '../system/NConfig.php';
    require_once MODULEPATH . 'settings/classes/SettingsMapper.php';
    require_once MODULEPATH . 'menu/controller/MenuController.php';

    /** Initialize DB connection */
    $adapter = new PDOAdapter('mysql:host='.DBHOST.';dbname='.DBNAME, DBUSER, DBPASS);

    $session = new Session($adapter);

    /** Generate site settings  */
    $settingsMapper = new SettingsMapper($adapter);

    $settings = array();

foreach ($settingsMapper->findAll() as $setting)
{
    $settings[$setting->getName()] = $setting;
}

    /** Fetch module */
    $moduleName = (isset($_GET['m'])) ? $_GET['m'] : '';
    $module = null;
    if ($moduleName != '')
    {
        if (file_exists(MODULEPATH . $moduleName . '/Aconfig.php'))
        {
            require_once MODULEPATH . $moduleName . '/Aconfig.php';
        }
        else
        {
            echo 'Module not found!';
        }
    }
    elseif ($moduleName == '')
    {
        require_once MODULEPATH.'start/Aconfig.php';
    }

    $menu = new MenuController($adapter);

    $roles = array('Developer', 'Moderator', 'Writer', 'Publisher', 'Crew');

    if (isset($_POST['submit_login']))
    {

        $session->login($_POST['username'], $_POST['password'], $roles);
    }

    if (isset($_GET['mAct']) && $_GET['mAct'] == 'logout')
    {
        $session->logout();
        header('Location: admin.php');
    }

    if (!$session->isAuthenticated())
    {
        /** User not logged in */
        $error = $session->getError();
        require_once 'site/closed.php';
    }
    else
    {
        if (!$session->isAuthorized($roles))
        {
            $session->logout();
            header('Location: admin.php');
        }
        if (isset($_GET['aAct']))
        {
            $module->ajaxActions();
        }
        else
        {
            /** Build page */
            $page = new Page($session, $module, null, null, array('map'), $settings, $menu);
            $page->addHeader('admin/header');
            $page->addFooter('admin/footer');
            $page->addContent('admin/content');
            $page->buildPage();
        }
    }
?>
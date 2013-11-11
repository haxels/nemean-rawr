<?php
echo "This is a test";
    session_start();

try
{
    require_once '../system/NConfig.php';

    require_once MODULEPATH . 'settings/classes/SettingsMapper.php';
    require_once MODULEPATH . 'menu/controller/MenuController.php';

    $adapter = new PDOAdapter('mysql:host='.DBHOST.';dbname='.DBNAME, DBUSER, DBPASS);

    $session = new Session($adapter);

    $settingsMapper = new SettingsMapper($adapter);

    $menu = new MenuController($adapter);

    /** Generate site settings  */
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
        if (file_exists(MODULEPATH . $moduleName . '/config.php'))
        {
            require_once MODULEPATH . $moduleName . '/config.php';
        }
        else
        {
            echo 'Module not found!';
        }
    }
    else
    {
        if (file_exists(MODULEPATH . 'articles' . '/config.php'))
        {
            require_once MODULEPATH . 'articles' . '/config.php';
        }
        else
        {
            echo 'Module not found!';
        }
    }



    if ($settings['site_closed'] == '0')
    {
        $roles = array('Developer', 'Writer', 'Publisher', 'Moderator', 'Crew');
    }
    else
    {
        $roles = array('User', 'Developer', 'Writer', 'Publisher', 'Moderator', 'Crew');
    }

    if (isset($_POST['submit_login']))
    {
        $session->login($_POST['username'], $_POST['password'], $roles);
        //header("Location: index.php");

        if ($settings['site_closed'] == '0')
            {
            $lc =  ($module instanceof ILeftContent) ? $lc = $module : null;

            $page = new Page($session, $module, $lc, null, [], $settings, $menu);
            $page->addHeader('new/header');
            $page->addFooter('new/footer');
            $page->addContent('new/content');
            $page->buildPage();
        }

    }

    elseif (isset($_GET['mAct']) && $_GET['mAct'] == 'logout')
    {
        $session->logout();
        header('Location: index.php');
    }

    elseif (isset($_GET['aAct']))
    {
        $module->ajaxActions();
    }

    elseif (!isset($_GET['aAct'], $_POST['submit_login']))
    {
         $lc =  ($module instanceof ILeftContent) ? $lc = $module : null;
        /** Build page */
        $page = new Page($session, $module, $lc, null, [], $settings, $menu);
        $page->addHeader('new/header');
        $page->addFooter('new/footer');
        $page->addContent('new/content');
        $page->buildPage();
    }

}
catch (Exception $e)
{
    echo $e->getMessage();
}
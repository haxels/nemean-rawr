<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ragnar
 * Date: 4/16/12
 * Time: 9:02 PM
 * To change this template use File | Settings | File Templates.
 */
    require_once MODULEPATH . 'menu/classes/Menu.php';
    require_once MODULEPATH . 'menu/classes/MenuItem.php';
    require_once MODULEPATH . 'menu/classes/MenuMapper.php';
    require_once SYSPATH    . 'NController.php';

    class MenuController extends NController
    {
        protected $moduleName = 'menu';

        private $menuMapper;

        public function __construct(IDatabaseAdapter $adapter)
        {
            $this->menuMapper = new MenuMapper($adapter);
        }
        public function display()
        {
            $this->root();
        }

        public function quickActions()
        {

        }

        public function root()
        {
            $data['menu'] = $this->menuMapper->getMenu();

            $submenu = (isset($_GET['pID'])) ? $_GET['pID'] : 0;

            if ($submenu != 0)
            {
                $data['submenu'] = $this->menuMapper->findAll(array('parent_id' => $submenu));
            }
            $this->loadView('menu', $data);
        }

        public function getMenu()
        {
            return $this->menuMapper->getMenu();
        }

        public function getSubMenu()
        {
            $submenu = (isset($_GET['pID'])) ? $_GET['pID'] : 0;
            $retVal = array();
            if ($submenu != 0)
            {
                $retVal =  $this->menuMapper->findAll(array('parent_id' => $submenu));
            }
            return $retVal;
        }

    }

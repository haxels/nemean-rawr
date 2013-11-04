<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ragnar
 * Date: 4/25/12
 * Time: 6:17 PM
 * To change this template use File | Settings | File Templates.
 */
require_once MODULEPATH . 'settings/classes/SettingsMapper.php';
require_once SYSPATH . 'NController.php';

    class AdminController extends NController
    {
        protected $moduleName = 'settings';

        private $settingsMapper;

        public function __construct(Session $s, SettingsMapper $sm)
        {
            $this->session = $s;
            $this->settingsMapper = $sm;
        }

        public function display()
        {
            $action = (isset($_GET['act'])) ? $_GET['act'] : '';

            switch ($action)
            {
                default:
                    $this->listSettings();
                    break;
            }
        }

        public function quickActions() {}

        public function ajaxActions()
        {
            $act = (isset($_GET['aAct'])) ? $_GET['aAct'] : '';
            switch($act)
            {
                case 'JSONupdateSettings':
                    $this->JSONupdateSettings();
                    break;

                case 'JSONupdateSetting':
                    $this->JSONupdateSetting();
                    break;
            }
        }

        public function listSettings()
        {
            $data['settings'] = $this->settingsMapper->findAll();

            if (isset($_POST['submit']))
            {
                foreach ($data['settings'] as $setting)
                {
                    $setting = new Setting($setting->getType(), $setting->getName(), (int)$_POST[$setting->getName()]);
                    $this->settingsMapper->update($setting);
                    header('Location: ?m=settings');
                }
            }
            $this->loadView('admin/list', $data);
        }

        public function editSettings()
        {

        }

        public function JSONupdateSettings()
        {
            $settings = isset($_POST) ? $_POST : null;
            print_r($settings);
            return;
            if (is_array($settings))
            {

            }
            else
            {

            }
        }

        public function JSONupdateSetting()
        {
            $type = (isset($_POST['type'])) ? $_POST['type'] : '';
            $value = (isset($_POST['value'])) ? $_POST['value'] : '';

            $this->settingsMapper->update(new Setting('', $type, $value));
            $setting = $this->settingsMapper->findById($type);

            $arr = ['setting' => ['type' => $setting->getValue(), 'value' => $setting->getValue()]];
            echo json_encode($arr);
        }
    }

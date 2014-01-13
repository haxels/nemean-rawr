<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 9/29/12
 * Time: 9:57 AM
 * To change this template use File | Settings | File Templates.
 */
class AdminController extends NController
{
    protected $moduleName = 'start';
    protected $session;
    protected $settings;

    public function __construct(Session $s, array $settings = [])
    {
        $this->session = $s;
        $this->settings = $settings;
    }

    public function display()
    {
        $data['site_closed'] = $this->settings['site_closed']->getValue();
        $data['locked'] = $this->settings['locked']->getValue();
        $data['regOpen'] = $this->settings['comporeg_open']->getValue();
        $this->loadView('admin/list', $data);
    }

    public function quickActions()
    {}
}

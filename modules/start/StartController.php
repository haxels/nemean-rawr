<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 9/29/12
 * Time: 9:57 AM
 * To change this template use File | Settings | File Templates.
 */
class StartController extends NController
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
        $data['session'] = $this->session;
        $this->loadView('start', $data);
    }

    public function quickActions()
    {}
}

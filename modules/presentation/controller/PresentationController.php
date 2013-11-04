<?php
/**
 * Created by JetBrains PhpStorm.
 * User: havardaxelsen
 * Date: 2/13/13
 * Time: 11:29 PM
 * To change this template use File | Settings | File Templates.
 */
class PresentationController extends NController
{
    protected $moduleName = 'presentation';

    protected $css = ['presentation'];

    private $presentationMapper;

    public function __construct(Session $s, PresentationMapper $pm)
    {
        $this->session = $s;
        $this->presentationMapper = $pm;
    }


    /**
     * Used for methods that uses views
     *
     * @return mixed
     */
    public function display()
    {
        $action = (isset($_GET['act'])) ? $_GET['act'] : '';

        switch ($action)
        {
            case 'view':
            default:
                $this->viewPresentation();
                break;
        }
    }

    /**
     * Used for methods that do not use views
     *
     * @return mixed
     */
    public function quickActions()
    {
        // TODO: Implement quickActions() method.
    }

    public function ajaxActions()
    {
        $action = (isset($_GET['aAct'])) ? $_GET['aAct'] : '';

        switch ($action)
        {
            case 'view':
            default:
                $this->viewPresentation();
                break;

            case 'fetch':
                $this->viewpres();
                break;
        }
    }


    private function viewPresentation()
    {
        $data['presentation'] = $this->presentationMapper->findAll();
        $this->loadView('viewpresentation', $data);
    }

    private function viewpres()
    {
        $data['presentation'] = $this->presentationMapper->findAll();
        $this->loadView('pres', $data);
    }
}

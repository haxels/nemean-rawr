<?php
/**
 * Created by JetBrains PhpStorm.
 * User: havardaxelsen
 * Date: 2/13/13
 * Time: 11:30 PM
 * To change this template use File | Settings | File Templates.
 */
class AdminController extends NController
{
    protected $moduleName = 'presentation';

    private $presentationMapper;

    public function __construct(Session $s, PresentationMapper $pm)
    {
        $this->session = $s;
        $this->presentationMapper = $pm;
    }

    public function display()
    {
        $action = (isset($_GET['act'])) ? $_GET['act'] : '';
        switch($action)
        {
            case 'add':
                $this->addSlide();
                break;

            case 'edit':
                $this->editSlide();
                break;

            default:
                $this->listSlides();
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
        $action = (isset($_GET['qAct'])) ? $_GET['qAct'] : '';
        switch($action)
        {
            case 'delete':
                $this->deleteSlide();
                break;
        }
    }

    public function addSlide()
    {
        if (!$this->session->isAuthorized(array('Developer', 'Moderator', 'Crew')))
        {
            echo 'You\'re not authorized';
            return;
        }

        $data['user'] = $this->session->getUser();
        $data['errors'] = [];

        if (isset($_POST['submit']))
        {
            $title              = (isset($_POST['title'])) ? trim($_POST['title']) : '';
            $content            = (isset($_POST['content'])) ? trim($_POST['content']) : '';

            $validator = new Validator();
            $validator->addField('title', array(Validator::REQUIRED), array('min' => 5));
            $validator->addField('content', array(Validator::REQUIRED, array('max' => 255)));
            $validator->validate();

            if ($validator->hasErrors())
            {
                $data['errors'] = $validator->getErrors();
                $this->loadView('admin/addSlide', $data);
            }
            else
            {
                $slide = new Slide(0, $title, $content, "");
                if ($this->presentationMapper->insert($slide) != 0)
                {
                    echo 'Slide lagt til!';
                }
                else
                {
                    echo 'No gikk ikke helt som planlagt! Whatevs... Snakkes!';
                }
            }
        }
        else
        {
            $this->loadView('admin/addSlide', $data);
        }
    }

    public function editSlide()
    {
        if (!$this->session->isAuthorized(array('Developer', 'Moderator', 'Crew')))
        {
            echo 'You\'re not authorized';
            return;
        }

        $slide_id = (isset($_GET['slide_id'])) ? $_GET['slide_id'] : 0;
        $slide = $this->presentationMapper->findById($slide_id);
        if (!$slide instanceof Slide) {
            echo 'Fant ikke denne sliden, snakkes!';
        }

        $data['slide'] = $slide;
        $data['errors'] = [];

        if (isset($_POST['submit']))
        {
            $title              = (isset($_POST['title'])) ? trim($_POST['title']) : '';
            $content            = (isset($_POST['content'])) ? trim($_POST['content']) : '';

            $validator = new Validator();
            $validator->addField('title', array(Validator::REQUIRED), array('min' => 5));
            $validator->addField('content', array(Validator::REQUIRED, array('max' => 255)));
            $validator->validate();

            if ($validator->hasErrors())
            {
                $data['errors'] = $validator->getErrors();
                $this->loadView('admin/editSlide', $data);
            }
            else
            {
                $slide = new Slide($slide_id, $title, $content, "");
                if ($this->presentationMapper->update($slide) != 0)
                {
                    echo 'Slide redigert!';
                }
                else
                {
                    echo 'Ingen endringer gjort!';
                }
            }
        }
        else
        {
            $this->loadView('admin/editSlide', $data);
        }
    }


    public function deleteSlide()
    {
        if (!$this->session->isAuthorized(array('Developer', 'Moderator', 'Crew')))
        {
            echo 'Ha dæ vækk! Ta her har du itj låv t, fjått!';
            return;
        }

        $slide_id = (isset($_GET['slide_id'])) ? $_GET['slide_id'] : 0;

        $slide = $this->presentationMapper->findById($slide_id);
        if ($slide instanceof Slide)
        {
            $this->presentationMapper->deletePK($slide_id);
            echo 'Slide fjernet!';
        }
        else
        {
            echo 'Jeg kan ikke slette en slide som ikke eksisterer... (ID '.$slide_id.')';
        }
    }

    public function listSlides()
    {
        $data['slides'] = $this->presentationMapper->findAll();
        $this->loadView('admin/list', $data);
    }


}

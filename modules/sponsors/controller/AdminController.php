<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 20.06.12
 * Time: 16:09
 * To change this template use File | Settings | File Templates.
 */


class AdminController extends NController
{
    protected $moduleName = 'sponsors';

    private $sponsorMapper;

    public function __construct(Session $s, SponsorMapper $sm)
    {
        $this->session          = $s;
        $this->sponsorMapper    = $sm;
    }

    public function display()
    {
        $action = (isset($_GET['act'])) ? $_GET['act'] : '';

        switch ($action)
        {
            case 'addSponsor':
                $this->addSponsor();
                break;

            case 'editSponsor':
                $this->editSponsor();
                break;

            case 'deleteSponsor':
                $this->deleteSponsor();
                break;

            default:
                $this->listSponsors();
                break;
        }
    }

    public function quickActions()
    {

    }

    private function listSponsors()
    {
        $data['sponsors'] = $this->sponsorMapper->findAll();
        $this->loadView('admin/list', $data);
    }

    private function addSponsor()
    {
        $data = array();

        if (isset($_POST['submit']))
        {
            $sponsor = new Sponsor(0, $_POST['name'], $_POST['image'], $_POST['link']);
            if ($this->sponsorMapper->insert($sponsor) != 0)
            {
                echo 'Sponsor added';
            }
            else
            {
                $data['errors'] = 'All fields must be valid';
                $this->loadView('admin/add', $data);
            }
        }
        else
        {
            $this->loadView('admin/add', $data);
        }
    }

    private function editSponsor()
    {
        $sponsor_id = (isset($_GET['sID'])) ? $_GET['sID'] : 0;
        $data['sponsor'] = $this->sponsorMapper->findById($sponsor_id);

        if (isset($_POST['submit']))
        {
            // Validate
            $sponsor = new Sponsor($sponsor_id, $_POST['name'], $_POST['image'], $_POST['link']);
            $this->sponsorMapper->update($sponsor);
            echo 'Sponsor updated';
        }
        else
        {
            if ($data['sponsor'] instanceof Sponsor)
            {
                $this->loadView('admin/edit', $data);
            }
            else
            {
                echo 'Sponsor was not found, or serial error';
            }
        }
    }

    private function deleteSponsor()
    {
        $sponsor_id = (isset($_GET['sID'])) ? $_GET['sID'] : 0;

        $sponsor = $this->sponsorMapper->findById($sponsor_id);

        if ($sponsor instanceof Sponsor)
        {
            $this->sponsorMapper->deletePK($sponsor_id);
            echo 'Deleted';
        }
        else
        {
            echo 'Sponsor not found, or serial error';
        }
    }
}

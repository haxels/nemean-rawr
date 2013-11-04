<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 28.06.12
 * Time: 03:32
 * To change this template use File | Settings | File Templates.
 */

class AdminController extends NController
{
    protected $moduleName = 'compos';
    protected $compoMapper;
    protected $settings;

    public function __construct(Session $s, CompoMapper $cm, array $settings = [])
    {
        $this->session = $s;
        $this->compoMapper = $cm;
        $this->settings = $settings;
    }

    public function display()
    {
        if (!$this->session->isAuthorized(array('Developer', 'Moderator')))
        {
            return;
        }

        $act = (isset($_GET['act'])) ? $_GET['act'] : '';

        switch ($act)
        {
            case 'viewCompo':
                $this->viewCompo();
                break;

            case 'addEntry':
                $this->addEntry();
                break;

            case 'viewTeam':
                $this->viewTeam();
                break;

            case 'listTeams':
                $this->listTeams();
                break;

            default:
                $this->listCompos();
                break;
        }
        $this->loadView('admin/popups');
    }

    public function quickActions()
    {

    }

    public function ajaxActions()
    {
        $act = (isset($_GET['aAct'])) ? $_GET['aAct'] : '';
        switch($act)
        {
            case 'JSONgetSettings':
                $this->JSONviewSettings();
                break;
        }
    }

    private function listCompos()
    {
        $data['compos'] = $this->compoMapper->findAll();
        $data['regOpen'] = $this->settings['comporeg_open']->getValue();
        $this->loadView('admin/list', $data);
    }

    private function listTeams()
    {
        $data['teams'] = $this->compoMapper->getTeams();
        $this->loadView('admin/listTeams', $data);
    }

    private function viewCompo()
    {
        $compo_id = (isset($_GET['cID'])) ? $_GET['cID'] : 0;
        $compo = $this->compoMapper->findById($compo_id);

        if (!$compo instanceof Compo)
        {
            echo 'Compo not found!';
            return;
        }
        else
        {
            $data['compo'] = $compo;
            $this->loadView('admin/viewCompo', $data);
        }
    }

    private function viewTeam()
    {
        $team_id = (isset($_GET['tID'])) ? $_GET['tID'] : 0;
        $team = $this->compoMapper->getTeam($team_id);
        $compos = $this->compoMapper->getTeamCompos($team_id);

        if (!$team instanceof Team)
        {
            echo 'Team not found!';
            return;
        }
        else
        {
            $data['team'] = $team;
            $data['compos'] = $compos;
            $this->loadView('admin/viewTeam', $data);
        }
    }

    private function addCompo()
    {

    }

    private function addTeam()
    {

    }

    private function addEntry()
    {
        $compo_id = (isset($_GET['cID'])) ? $_GET['cID'] : 0;
        $compo = $this->compoMapper->findById($compo_id);
        if (!$compo instanceof Compo)
        {
            echo 'Compo not found!';
            return;
        }

        if (!$compo->isSignupOpen())
        {
            echo 'Signup is not open';
            return;
        }

        $team_id = (isset($_GET['tID'])) ? $_GET['tID'] : 0;
        $team = $this->compoMapper->getTeam($team_id);
        if (!$team instanceof Team)
        {
            echo 'Team not found!';
            return;
        }

        if ($compo->isCompetingTeam($team))
        {
            echo 'Team is already signed up for this compo';
            return;
        }

        $competitor = new Competitor(16, 'Ragnar Kalland');
        if ($compo->isCompetingCompetitor($competitor))
        {
            echo 'Competitor is already signed up for this compo by another team';
            return;
        }

        echo 'Ready to add';
        // Get compo by id
        // Check is signups for compo are open still
        // Check if team is already competing in compo
        // Check if one of the team competitors is already competing in compo with another team
    }

    public function JSONviewSettings()
    {
        $data['settings'] = $this->settings;
        $this->loadView('admin/settings', $data);
    }

}

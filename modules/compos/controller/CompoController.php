<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 04.07.12
 * Time: 12:21
 * To change this template use File | Settings | File Templates.
 */
    class CompoController extends NController
    {
        protected $moduleName = 'compos';

        private $compoMapper;
        private $settings;

        public function __construct(Session $s, CompoMapper $cm, array $settings = [])
        {
            $this->session = $s;
            $this->compoMapper = $cm;
            $this->settings = $settings;

        }

        public function getCSS()
        {
            return ['css/compo'];
        }

        public function getJS()
        {
            return ['js/functions'];
        }


        public function display()
        {
            $action = (isset($_GET['act'])) ? $_GET['act'] : '';

            switch ($action)
            {
                case 'view':
                default:
                    $this->viewCompos();
                    break;

                case 'viewCompo':
                    $this->viewCompo();
                    break;
            }
            $this->loadView('popups');
        }

        public function quickActions()
        {

        }

        private function viewCompos()
        {
            $data['compos'] = $this->compoMapper->getOpenCompos();
            $this->loadView('list', $data);
        }

        private function viewCompo()
        {
            $compoID = $_GET['cID'];
            $data['compo'] = $this->compoMapper->findById($compoID);
            $this->loadView('viewCompo', $data);


        }

        private function viewUserTeams()
        {

        }


        /** Methods returning JSON objects */

        private function JSONaddTeam()
        {
            $arr = [];
            $validUserIds = $this->compoMapper->getUserIds();

            if (isset($_POST['team_name']))
            {
                $team_name          = isset($_POST['team_name'])        ? $_POST['team_name']           : '';
                $team_leader        = isset($_POST['team_leader'])      ? $_POST['team_leader']         : '';
                $team_competitors   = isset($_POST['team_competitors']) ? $_POST['team_competitors']    : '';

                $validator = new Validator();
                $validator->addField('team_name', $team_name, [Validator::REQUIRED]);
                $validator->addField('team_leader', $team_leader, [Validator::REQUIRED]);
                $validator->addField('team_competitors', $team_leader, [Validator::REQUIRED], ['whitelist' => $validUserIds]);

                $validator->validate();

                if (!$validator->hasErrors())
                {
                    /**
                     * 1 - Create and add team
                     * 2 - Add users as team members
                     * 3 - Add team to the compo's entries
                     */
                    $team = new Team(0, $team_name, new Leader($team_leader, ''), $team_competitors);
                    $this->compoMapper->addTeam($team);
                }
                else
                {
                    $arr = ['success' => false, 'errors' => $validator->getErrors()];
                }
            }
            else
            {
                $arr = ['success' => false, 'msg' => 'Alle felt må fylles ut.'];
            }

            echo json_encode($arr);
        }

    }

<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ragnar
 * Date: 5/3/12
 * Time: 9:48 PM
 * To change this template use File | Settings | File Templates.
 */

    class AdminController extends NController
    {
        protected $moduleName = 'users';

        private $userMapper;
        private $authyMapper;

        public function __construct(IDatabaseAdapter $adapter, Session $s, UserMapper $um, AuthyMapper $am)
        {
            $this->session      = $s;
            $this->userMapper   = $um;
            $this->authyMapper  = $am;
        }

        public function display()
        {
            if (!$this->session->isAuthorized(array('Developer', 'Moderator', 'Crew')))
            {
                echo 'You\'re not authorized to do this.';
                return;
            }

            $act = (isset($_GET['act'])) ? $_GET['act'] : '';

            switch ($act)
            {
                case 'view':
                    $this->viewUser();
                    break;

                case 'activate':
                    $this->activate();
                    break;

                case 'delete':
                    $this->deleteUser();
                    break;

                case 'new':
                    $this->addUser();
                    break;

                case 'paid':
                    $this->setPaid();
                    break;

                case 'permissions':
                    $this->userPermissions();
                    break;

                case 'addRole':
                    $this->addRole();
                    break;

                case 'deleteRole':
                    $this->deleteRole();
                    break;

                case 'doAddRole':
                    $this->doAddRole();
                    break;

                case 'mailtest':
                    $this->sendActivationMail();
                    break;

                default:
                    $this->listUsers();
                    break;
            }
            $this->loadView('admin/popups');
        }

        /**
         * @see NController
         * @return mixed
         */
        public function quickActions()
        {
            if (!$this->session->isAuthorized(array('Developer', 'Moderator', 'Crew')))
            {
                echo 'You\'re not authorized to do this.';
                return;
            }

            $act = (isset($_GET['act'])) ? $_GET['act'] : '';

            switch ($act)
            {

            }
        }

        public function ajaxActions()
        {
            $act = (isset($_GET['aAct'])) ? $_GET['aAct'] : '';

            switch ($act)
            {
                case 'JSONgetUser':
                    $this->JSONgetUser();
                    break;

                case 'JgetUser':
                    $this->viewUser();
                    break;

                case 'JSONaddUser':
                    $this->JSONaddUser();
                    break;

                case 'JSONgetUsers':
                    $this->JSONgetUsers();
                    break;

                case 'JSONupdateRole':
                    $this->JSONupdateRole();
                    break;
            }
        }

        public function listUsers()
        {
            if (!$this->session->isAuthorized(array('Developer', 'Moderator', 'Crew')))
            {
                 echo 'You\'re not authorized to do this.';
                return;
            }

            $data['users'] = $this->userMapper->findAll();

            $this->loadView('admin/list', $data);

        }

        public function addUser()
        {
            $data = array();
            if (isset($_POST['submit']))
            {
                if($_POST['password']!= "" && $_POST['password'] == $_POST['confpassword'] && !$this->userMapper->existsEmail($_POST['email']))
                {

                    $ci     = new ContactInfo("", $_POST['email'], null );
                    $user   = new User(0, $_POST['firstname'], $_POST['lastname'], null, $ci);
                    $id     = $this->userMapper->quickInsert($user);
                    $auth   = new Authy($_POST['email'], $_POST['password'], 0, $id);


                    if($this->authyMapper->insert($auth) == 0)
                    {
                        $this->userMapper->getRoleMapper()->addRole($id, 3);
                        echo "User registered!";
                        //TODO Send mail stupid!
                    }
                    else
                    {
                        $this->loadView('admin/add', $data);
                        echo "ID =0 or authy failed";
                    }
                }
                else
                {
                    $this->loadView('admin/add', $data);
                    echo "Serial error!";
                }
            }
            else
            {
                $this->loadView('admin/add', $data);
            }
        }

        public function viewUser()
        {
            if (!$this->session->isAuthorized(array('Developer', 'Moderator', 'Crew')))
            {
                echo 'You\'re not authorized to do this.';
                return;
            }

            $user_id = (isset($_GET['uID'])) ? $_GET['uID'] : 0;

            if ($user_id == 0)
            {
                echo 'User was not fonud!';
                return;
            }

            $data['user'] = $this->userMapper->findById($user_id);
            $data['authy'] = $this->authyMapper->getByUserID($user_id);
            $data['permissions'] = $this->userMapper->getRoleMapper()->findAll();
            if ($data['user'] instanceof User)
            {
                $this->loadView('admin/viewUser', $data);
            }
            else
            {
                echo 'User not found.';
            }
        }

        public function JSONgetUser()
        {
            if (!$this->session->isAuthorized(array('Developer', 'Moderator', 'Crew')))
            {
                $arr['success'] = false;
                $arr['error'] = 'Uautorisert';
            }

            $user_id = (isset($_GET['uID'])) ? $_GET['uID'] : 0;

            if ($user_id == 0)
            {
                $arr['success'] = false;
                $arr['error'] = 'Brukeren ble ikke funnet; Bruker ID: '.$user_id;
            }

            $data['user'] = $this->userMapper->findById($user_id);
            $data['authy'] = $this->authyMapper->getByUserID($user_id);
            if ($data['user'] instanceof User)
            {
                $arr['success'] = true;
                $arr['user'] = $data['user'];
                $arr['authhy'] = $data['authy'];
            }
            else
            {
                $arr['success'] = false;
                $arr['error'] = 'Brukeren ble ikke funnet; Bruker ID: '.$user_id;
            }
            echo $user_id;
            echo json_encode($arr);
        }

        public function JSONupdateRole()
        {
            $chked = (isset($_POST['chked'])) ? $_POST['chked'] : false;
            $role_id = (isset($_POST['value'])) ? $_POST['value'] : '';
            $user_id = (isset($_POST['user_id'])) ? $_POST['user_id'] : '';

            if (!$this->session->isAuthorized(['Developer']))
            {
                $levelSessionUser = $this->userMapper->getRoleMapper()->getLevel($this->session->getID());
                $levelUser = $this->userMapper->getRoleMapper()->getLevel($user_id);

                if ($levelSessionUser <= $levelUser)
                {
                    $arr = ['succes' => false, 'msg' => 'Du har ikke rettigheter til dette.'];
                    echo json_encode($arr);
                    return;
                }
            }

            if (!$chked)
            {
                $this->userMapper->getRoleMapper()->removeRole($user_id, $role_id);
                $arr = ['checkbox' => []];
                echo json_encode($arr);
                return;
            }
            else
            {
                $this->userMapper->getRoleMapper()->addRole($user_id, $role_id);
                $arr = ['checkbox' => []];
                echo json_encode($arr);
                return;
            }
        }

        public function JSONaddUser()
        {
            $pass2 = (isset($_POST['pass2'])) ? $_POST['pass2'] : '';

            $validator = new Validator();
            $validator->addField('firstname', [Validator::NAME, Validator::REQUIRED]);
            $validator->addField('lastname', [Validator::NAME, Validator::REQUIRED]);
            $validator->addField('email', [Validator::EMAIL, Validator::REQUIRED]);
            $validator->addField('pass1', [Validator::PASSWD, Validator::REQUIRED], ['is_equal' => $pass2]);
            $validator->addField('activated');
            $validator->addField('paid');
            $validator->validate();

            if ($this->userMapper->existsEmail($validator->getFieldValue('email')))
            {
                $validator->setError('email', 'E-posten finnes allerede.');
            }

            $errors = [];
            if ($validator->hasErrors())
            {
                foreach ($validator->getErrors() as $key => $value)
                {
                    $errors[] = ['field' => $key, 'msg' => $value];
                }
                $arr = ['success' => false, 'errors' => $errors];
                echo json_encode($arr);
                return;
            }

            $cf = new ContactInfo('', $validator->getFieldValue('email'), new Address('', new Location()));
            $user = new User(0, $validator->getFieldValue('firstname'), $validator->getFieldValue('lastname'), null, $cf);

            $user_id = $this->userMapper->insert($user);
            list($pw, $hash) = $this->createPassword($validator->getFieldValue('pass1'));
            $authy = new Authy($validator->getFieldValue('email'), $pw, $validator->getFieldValue('activated'), $user_id, $hash);

            if ($this->authyMapper->insert($authy) == 0)
            {
                $this->userMapper->getRoleMapper()->addRole($user_id, 3);
                if ($validator->getFieldValue('paid'))
                {
                    $this->userMapper->getRoleMapper()->addRole($user_id, 6);
                }
                $arr = ['success' => true, 'msg' => 'Bruker lagt til.'];
                echo json_encode($arr);
                return;
            }
            else
            {
                // Logger
                $arr = ['success' => false, 'msg' => 'Authy insert failed.'];
                echo json_encode($arr);
                return;
            }

            $arr = ['success' => false, 'msg' => 'Serial error'];
            echo json_encode($arr);

            /**
             * 1. Fetch post data                   (Check)
             * 2. Validate data                     (Check)
             * 3. Create user in usr_users
             * 4. Set correct user roles
             * 5.
             */
        }

        public function JSONgetUsers()
        {
            $users = $this->userMapper->findAll();
            if (is_array($users))
            {
                $nUsers = [];
                foreach ($users as $user)
                {
                    $nUsers[] = ['value' => $user->getUserId(), 'label' => $user->getName()];
                }

                $arr = ['success' => true, 'users' => $nUsers];
                echo json_encode($arr);
                return;
            }
            $arr = ['success' => false, 'msg' => 'Whatevs!'];
            echo json_encode($arr);
            return;
        }

        public function activate()
        {
            if (!$this->session->isAuthorized(array('Developer', 'Moderator', 'Crew')))
            {
                echo 'You\'re not authorized to do this.';
                return;
            }

            $user_id = (isset($_GET['uID'])) ? $_GET['uID'] : 0;

            if ($user_id == 0)
            {
                echo 'User was not fonud!';
                return;
            }

            $user = $this->userMapper->findById($user_id);

            if ($user instanceof User)
            {
                $levelSessionUser = $this->userMapper->getRoleMapper()->getLevel($this->session->getID());
                $levelUser = $this->userMapper->getRoleMapper()->getLevel($user_id);
                if ($levelSessionUser <= $levelUser)
                {
                    echo 'Dette kan ikke du gjøre.';
                    return;
                }
                else
                {
                    $authy = $this->authyMapper->getByUserID($user_id);
                    if ($authy->getActivated())
                    {
                        $this->authyMapper->unActivate($user_id);
                    }
                    else
                    {
                        $this->authyMapper->activate($user_id);
                    }
                    header('Location: ?m=users&act=viewUser&uID='.$user_id);
                }
            }

            echo 'User was not found.';
        }

        public function editUser()
        {

        }

        public function deleteUser()
        {
            if (!$this->session->isAuthorized(array('Developer', 'Moderator', 'Crew')))
            {
                echo 'You\'re not authorized to do this.';
                return;
            }

            $user_id = (isset($_GET['uID'])) ? $_GET['uID'] : 0;

            if ($user_id == 0)
            {
                echo 'User was not fonud!';
                return;
            }

            $user = $this->userMapper->findById($user_id);

            if ($user instanceof User)
            {
                $levelSessionUser = $this->userMapper->getRoleMapper()->getLevel($this->session->getID());
                $levelUser = $this->userMapper->getRoleMapper()->getLevel($user_id);
                if ($levelSessionUser <= $levelUser)
                {
                   // $arr = ['succes' => false, 'msg' => 'Du har ikke rettigheter til dette.'];
                    echo 'Dette kan du ikke gjøre';
                    return;
                }
                else
                {
                    $this->userMapper->deleteReservation($user_id);
                    $this->userMapper->deletePK($user_id);
                    header('Location: ?m=users');
                }
            }

            echo 'User was not found.';
        }

        public function sendActivationMail()
        {
            $mail             = new PHPMailer();

            $body             = "<div>testmail</div>";
//$body             = eregi_replace("[\]",'',$body);

            $mail->IsSMTP(); // telling the class to use SMTP
            $mail->Host       = "smtp.domeneshop.no"; // SMTP server
            $mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
            // 1 = errors and messages
            // 2 = messages only
            $mail->SMTPAuth   = false;                  // enable SMTP authentication
            $mail->Host       = "smtp.domeneshop.no"; // sets the SMTP server
            $mail->Port       = 26;                    // set the SMTP port for the GMAIL server
            $mail->Username   = "nemean4"; // SMTP account username
            $mail->Password   = "axlesenNN1";        // SMTP account password

            $mail->SetFrom('no-reply@yourdomain.com', 'No reply');


            $mail->Subject    = "PHPMailer Test Subject via smtp, basic with authentication";

            $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

            $mail->MsgHTML($body);

            $address = "ragnar.kallando@gmail.com";
            $mail->AddAddress($address, "Ragnar Kalland");

            if(!$mail->Send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
                echo "Message sent!";
            }
        }

        public function setPaid()
        {
            $user_id = (isset($_GET['uID'])) ? $_GET['uID'] : 0;

            $user = $this->userMapper->findById($user_id);

            if ($user instanceof User)
            {
                if (!$user->isInRole(array('Paid')))
                {
                    $this->userMapper->getRoleMapper()->addRole($user_id, 6);
                    echo 'User is no in role Paid';
                }
                else
                {
                    $this->userMapper->getRoleMapper()->removeRole($user_id, 6);
                    echo 'User is no longer in role Paid';
                }
            }
        }

        public function userPermissions()
        {
            $user_id = (isset($_GET['uID'])) ? $_GET['uID'] : 0;

            $user = $this->userMapper->findById($user_id);
            $data['roles'] = $user->getRoles();
            $this->loadView('admin/permissions', $data);
        }

        public function addRole()
        {
            $user_id = (isset($_GET['uID'])) ? $_GET['uID'] : 0;

            $roles = $this->userMapper->getRoleMapper()->findAll();
            $user = $this->userMapper->findById($user_id);
            $userRoles = $user->getRoles();

            $userRolesArray = array();
            foreach ($userRoles as $role)
            {
                $userRolesArray[] = $role->getRole();
            }

            $data['roles'] = array();
            $userHighestRole = $this->session->getUser()->getHighestRoleLevel();
            foreach ($roles as $role)
            {
                if (!in_array($role->getRole(), $userRolesArray) && ($role->getRoleLevel() <= $userHighestRole))
                {
                    $data['roles'][] = $role;
                }
            }

            $this->loadView('admin/addRole', $data);
        }

        public function doAddRole()
        {
            $user_id = (isset($_GET['uID'])) ? $_GET['uID'] : 0;
            $role_id = (isset($_GET['rID'])) ? $_GET['rID'] : 0;

            $this->userMapper->getRoleMapper()->addRole($user_id, $role_id);
            header('Location: ?m=users&act=view&uID='.$user_id);
        }

        public function deleteRole()
        {
            $user_id = (isset($_GET['uID'])) ? $_GET['uID'] : 0;
            $role_id = (isset($_GET['rID'])) ? $_GET['rID'] : 0;

            $role = $this->userMapper->getRoleMapper()->findById($role_id);

            if (!($this->user->getHighestRoleLevel() <= $role->getRoleLevel()))
            {
                $this->userMapper->getRoleMapper()->removeRole($user_id, $role_id);
                header('Location: ?m=users&act=view&uID='.$user_id);
            }
            else
            {
                echo 'Shoot, he is of higher rank than you!';
            }
        }


        private function createPassword($password)
        {
            $hashstring = time() . 'snaddjer';
            $hash   = sha1($hashstring);
            $saltajar = '$2a$15$o./48UhxVop0.skwzmg3oG$';
            $pw = crypt($password, $saltajar);
            return [$pw, $hash];
        }






    }

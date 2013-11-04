<?php
/**
 * User: Ragnar
 * Date: 3/25/12
 * Time: 10:26 PM
 */
    require_once MODULEPATH.'/users/classes/UserMapper.php';
    require_once MODULEPATH.'/users/classes/AuthyMapper.php';
    require_once MODULEPATH.'/users/classes/ParentsMapper.php';
    require_once MODULEPATH.'/users/classes/RoleMapper.php';
    require_once SYSPATH.'NController.php';

    class UserController extends NController implements IMainContent, ILeftContent
    {
        protected $moduleName = 'users';

        private $userMapper;
        private $autyMapper;

        public function __construct(Session $s, UserMapper $um, AuthyMapper $am)
        {
            $this->session = $s;
            $this->userMapper = $um;
            $this->autyMapper = $am;
        }
     

        public function display()
        {
            $action = isset($_GET['act']) ? $_GET['act'] : '';
            
            switch($action)
            {
                case 'edit':
                    if (!$this->session->isAuthorized(array('User', 'Developer')))
                    {
                        echo 'Illegal action!';
                        return;
                    }
                    //$this->editUser();
                    break;
                    
                case 'qReg':
                    $this->quickRegUser();
                    break;

                case 'activate':
                    $this->activateUser();
                    break;

                case 'forgot':
                    $this->forgotPassword();
                    break;

                case 'reset':
                    $this->resetPw();
                    break;

                case 'pactivate':
                    $this->activateParent();
                    break;

                default:
                    $this->viewProfile();
                    break;
            }
        }

        public function quickActions()
        {
            $act = (isset($_GET['qAct'])) ? $_GET['qAct'] : '';
            $this->removeUnactiveUsers();
            switch ($act)
            {
                case 'my_mail':
                    $this->viewMail();
                    break;

                case 'test':
                    $this->test();
                    break;
            }
            return;
        }

        public function ajaxActions()
        {
            $act = (isset($_GET['aAct'])) ? $_GET['aAct'] : '';

            switch ($act)
            {
                case 'JSONcheckEmail':
                    $this->JSONexistsEmail();
                    break;

                case 'JSONquickReg':
                    $this->JSONquickRegUser();
                    break;

                case 'JSONforgot':
                    $this->JSONsendPassword();
                    break;

                case 'JSONcompleteReg':
                    $this->JSONcompleteReg();
                    break;

                case 'JSONverifyAge':

                    $this->JSONverifyAge();
                    break;

                case 'mailtest':
                    echo $this->htmlWelcomeMail('Ragnar', 'asdff342');
                    break;

                case 'pw':
                    echo $this->passwordGenerator();
                    break;

                case 'JSONcrewApplication':

                    echo $this->JSONcrewApplication();
                    break;

            }
        }

        private function JSONcrewApplication()
        {
            $data = array();
            if(isset($_POST['firstname']))
            {
                $firstname  = isset($_POST['firstname'])    ? $_POST['firstname']   : '';
                $lastname   = isset($_POST['lastname'])     ? $_POST['lastname']    : '';
                $email      = isset($_POST['email'])        ? $_POST['email']       : '';
                $age        = isset($_POST['byear'])        ? $_POST['byear']       : '';
                $what       = isset($_POST['what'])         ? $_POST['what']        : '';
                $why        = isset($_POST['why'])          ? $_POST['why']         : '';

                $validator = new Validator();

                $validator->addField('firstname', array(Validator::REQUIRED, Validator::NAME));
                $validator->addField('lastname', array(Validator::REQUIRED, Validator::NAME));
                $validator->addField('byear', array(Validator::REQUIRED, Validator::NUMBER));
                $validator->addField('email', array(Validator::REQUIRED, Validator::EMAIL));
                $validator->addField('what', array(Validator::REQUIRED));
                $validator->addField('why', array(Validator::REQUIRED));

                $validator->validate();

                if(!$validator->hasErrors())
                {

                    $this->sendMail('kontakt@nemean.no', 'Crew application for Nemean', $this->mailApplication($firstname,$lastname, $age, $why, $what));
                    $data['success'] = true;
                    $data['msg'] = "Mail sent!!";

                }
                else{
                $data['success'] = false;
                $data['errors'] = $validator->getErrors();

                }
            }
            else
            {
                $data['success'] = false;
                $data['msg'] = "Serial error!!".var_dump($_POST);
            }

            echo json_encode($data);
        }

        public function test()
        {
            $arr = $this->userMapper->userArray();
            foreach ($arr as $a)
            {
                echo $a['fname'] . ' - ' .$a['activated']. '<br />';
            }
            exit();
        }

        public function mainContent()
        {
            $action = isset($_GET['act']) ? $_GET['act'] : '';
            switch($action)
            {
                case 'edit':
                    //$this->editUser();
                    break;

                case 'qreg':
                    $this->quickRegUser();
                    break;

                default:
                    $this->viewProfile();
                    break;
            }
        }

        public function viewProfile()
        {
            $data['user'] = $this->session->getUser();
            $this->loadView('viewProfile', $data);
        }

        public function register()
        {
            echo '<pre>';
            print_r($_POST);
            echo '</pre>';
            if (!isset($_POST['submit']))
            {
                require_once 'regUser.php';
            }
            elseif (isset($_POST['submit']))
            {
                $validator = new Validator();
                $validator->addField('firstname', array( 'isint'), array('max'=>10, 'min'=>2));
                $valid = true;
                if (empty($_POST['firstname']))
                {
                    $errors['firstname'] = 'Invalid name';
                    $valid = false;
                }

                if (!$valid)
                {
                    require_once 'regUser.php';
                }
                else
                {
                    $user = new User(0, $_POST['firstname'], '');
                    $this->userMapper->insert($user);
                    echo 'User added!';
                }
            }
        }
        
        public function editUser()
        {
            $usr_id = $this->session->getID();
            $user = $this->userMapper->findById($usr_id);
            $authy = $this->autyMapper->getByUserID($usr_id);
            $oldpw = $authy->getPassword();
            
            if (isset($_POST['submit']))
        {
            // Validate user input
                
                //Checs if new passwords are typed, if they are, and match, pw is set to new pw
                if(isset($_POST['password']) && isset($_POST['confpassword']) && $_POST['password'] === $_POST['confpassword'])
                {
                    if($_POST['password'] != '' OR empty ($_POST['password']))
                    $pw = sha1($_POST['password']);
                }
                else
                {
                    $pw = $oldpw;
                }
            
            $location   = new Location($_POST['zipcode'], $_POST['location']);
            $address    = new Address ($_POST['address'], $location);
            $contactinfo= new ContactInfo($_POST['tlfnumber'], $_POST['email'], $address);
            $parent     = new Parents($user->getParent()->getParent_id(), $_POST['ptlfnumber'], $_POST['pemail']);
            
            //Checks if old pw equals old pw input and the two new typed pw's match
            if(sha1($_POST['oldpassword']) === $authy->getPassword() && $_POST['password'] === $_POST['confpassword'])
            {
              

                $auth       = new Authy($_POST['email'], $pw, 1, $usr_id, $authy->getHash());
                $user       = new User($usr_id, $_POST['firstname'], $_POST['lastname'], $_POST['birthdate'], $contactinfo, $parent, array());



                if ($this->userMapper->update($user) != 0 || $this->autyMapper->update($auth) !=0)
                {
                    echo 'User updated!';
                }
                else
                {
                    echo 'No changes made!';
                }
            }
            
            // The old and/or new password dont match.
            else
            {   
                if(!isset($_POST['oldpassword']) OR empty ($_POST['oldpassword']))
                {
                    $auth       = new Authy($_POST['email'], $pw, 1, $usr_id, $authy->getHash());
                    $user       = new User($usr_id, $_POST['firstname'], $_POST['lastname'], $_POST['birthdate'], $contactinfo, $parent, array());



                    if ($this->userMapper->update($user) != 0 || $this->autyMapper->update($auth) !=0)
                    {
                        echo 'User updated!';
                    }
                    else
                    {
                        echo 'No changes made!';
                    }
                    
                }
                else
                {
               
                    echo "Get your password right, you Mofo!";
               
                }
                
            }
        }
        else
        {
            
            if ($usr_id == 0)
            {
                echo 'User not found!';
                return;
            }
            
            if ($user instanceof User)
            {
                $data['user'] = $user;
            }
            else
            {
                echo 'User not found!';
                return;
            }
            
            
            
            $this->loadView('editUser', $data);
        }
            
            
            
            
            
            
         }

        public function quickRegUser()
        {
            $data = array();
             if (isset($_POST['submitQReg']))
             {
                 $firstname = (isset($_POST['firstname'])) ? $_POST['firstname'] : '';
                 $lastname = (isset($_POST['lastname'])) ? $_POST['lastname'] : '';
                 $email = (isset($_POST['email'])) ? $_POST['email'] : '';
                 $pass1 = (isset($_POST['password'])) ? $_POST['password'] : '';
                 $pass2 = (isset($_POST['confpassword'])) ? $_POST['confpassword'] : '';

                 $validator = new Validator();
                 $validator->addField('firstname', array(Validator::REQUIRED, Validator::NAME));
                 $validator->addField('lastname',  array(Validator::REQUIRED, Validator::NAME));
                 $validator->addField('email',  array(Validator::REQUIRED, Validator::EMAIL));
                 $validator->addField('password', array(Validator::PASSWD));

                 if ($pass1 != $pass2)
                 {
                     $validator->setError('password', 'Passordene m&#229; v&#230;re identiske');
                 }

                 if ($this->userMapper->existsEmail($email))
                 {
                     $validator->setError('email', 'E-post eksisterer fra f&#248;r.');
                 }

                 $validator->validate();

                 if ($validator->hasErrors())
                 {
                     $arr = array('success' => false, 'errors' => $validator->getErrors());
                     echo json_encode($arr);
                     return;
                 }

                 $ci = new ContactInfo('', $email, null);
                 $user = new User(0, $firstname, $lastname, null, $ci);
                 $id = $this->userMapper->quickInsert($user);
                 $hashstring = time() . 'snaddjer';
                 $hash   = sha1($hashstring);
                 $saltajar = '$2a$15$o./48UhxVop0.skwzmg3oG$';
                 $pw = crypt($pass1, $saltajar);
                 $authy = new Authy($email, $pw, 0, $id, $hash);

                if ($this->autyMapper->insert($authy) == 0)
                {
                    $this->userMapper->getRoleMapper()->addRole($id, 3);
                    $this->sendMail($email, 'Aktiveringsmail', '<a href="http://localhost/zebra/www/index.php?m=users&act=activate&h='.$hash.'>Aktiver</a>"');
                    echo "Bruker registrert! Du vil f&#229; en aktiveringsmail p&#229; din registrerte e-post. Her m&#229; du aktivere brukeren din for &#229; kunne logge inn.";
                }
                else
                {
                    $this->loadView('register', $data);
                    echo "ID =0 or authy failed";
                }
            }
            else
            {
                $this->loadView('register', $data);
                echo "Serial error!";
            }
             $this->loadView('register', $data);
        }

        private function activateUser()
        {
            $hash = isset($_GET['h']) ? $_GET['h'] : '';
            if ($hash != '')
            {
                $authy = $this->autyMapper->findAll(array('hash' => $hash));
                $authy = $authy[0];
                if ($authy instanceof Authy)
                {
                    if (!$authy->getActivated())
                    {
                        $this->autyMapper->activate($authy->getUser_id());
                        $user = $this->userMapper->findById($authy->getUser_id());
                        $body = $this->htmlWelcomeMail($user->getName(), $hash);
                        $this->sendMail($user->getContactInfo()->getEmail(), 'Velkommen til Nemean', $body);
                        echo '<section id="main">Din brukerkonto er n&#229; aktivert!</section>';
                    }
                    else
                    {
                        echo '<section id="main">Du er allerede aktivert!</section>';
                    }
                }
                else
                {
                    echo 'Feil med aktivering!';
                }
            }
        }

        private function activateParent()
        {
            $hash = isset($_GET['h']) ? $_GET['h'] : '';
            $user_id = isset($_GET['su4d']) ? $_GET['su4d'] : '';
            if ($hash != '')
            {
                $obj = $this->userMapper->getParentMapper()->findAll(['hash' => $hash]);
                $parent = (count($obj) == 1) ? $obj[0] : null;
                if ($parent instanceof Parents)
                {
                    if (!$parent->getActivated())
                    {
                        $parent->setActivated();
                        $this->userMapper->getParentMapper()->update($parent);
                        $this->userMapper->updateReservation($user_id);
                        echo '<section id="main">Takk! Din reservasjon er nå bekreftet!.</section>';
                    }
                    else
                    {
                        echo '<section id="main">Du er allerede aktivert!</section>';
                    }
                }
                else
                {
                    echo '<section id="main">Feil med aktivering.</section>';
                }
            }
            else
            {
                echo '<section id="main">Feil med aktivering.</section>';
            }
        }

        private function resetPw()
        {
            $email = (isset($_GET['email'])) ? $_GET['email'] : '';
            $data['email'] = $email;
            if (isset($_POST['submit_reset']))
            {
                $user = $this->userMapper->findAll(array('email' => $email));
                if (count($user) > 0 && $user[0] instanceof User)
                {
                    $user = $user[0];
                    $authy = $this->autyMapper->getByUserID($user->getUserId());
                    $tmpPw = (isset($_POST['tmpPw'])) ? $_POST['tmpPw'] : '';
                    $newPw = (isset($_POST['newPw'])) ? $_POST['newPw'] : '';
                    $confNewPw = (isset($_POST['confNewPw'])) ? $_POST['confNewPw'] : '';
                    $validator = new Validator();
                    $validator->addField('tmpPw', array(Validator::REQUIRED), array('is_equal' => $authy->getHash()));
                    $validator->addField('newPw', array(Validator::REQUIRED, Validator::PASSWD), array('is_equal' => $confNewPw));
                    $validator->validate();

                    if ($validator->hasErrors())
                    {
                        $data['errors'] = $validator->getErrors();
                        $this->loadView('reset', $data);
                        return;
                    }

                    $saltajar = '$2a$15$o./48UhxVop0.skwzmg3oG$';
                    $pw = crypt($newPw, $saltajar);
                    $authy->setPassword($pw);
                    $this->autyMapper->update($authy);
                    $data['msg'] = 'Nytt passord lagret!';
                    $this->loadView('ok', $data);
                }
            }
            else
            {
                $this->loadView('reset', $data);
            }
        }

        private function forgotPassword()
        {
            $data = array();
            if (isset($_POST['submitForgot']))
            {
                $user_id  = isset($_GET['user_id']) ? $_GET['user_id'] : '';
                $tmpPass  = isset($_POST['tmpPassword']) ? $_POST['tmpPassword'] : '';
                $newPass1 = isset($_POST['password']) ? $_POST['password'] : '';
                $newPass2 = isset($_POST['confTmpPassword']) ? $_POST['confTmpPassword'] : '';

                $authy = $this->autyMapper->getByUserID($user_id);

                $validator = new Validator();
                $validator->addField('password', array(Validator::REQUIRED, Validator::PASSWD));

                if (!$this->autyMapper->checkTemporaryPassword($tmpPass, $user_id))
                {
                    $validator->setError('tmpPassword', 'Feil passord');
                }

                if ($newPass1 != $newPass2)
                {
                    $validator->setError('password', 'Passordene stemmer ikke overens');
                }

                $validator->validate();

                if ($validator->hasErrors())
                {
                    $data['errors'] = $validator->getErrors();
                    $this->loadView('admin/forgotPsw', $data);
                    return;
                }

                $authy->setPassword(sha1($newPass1));
                $this->autyMapper->update($authy);
                echo 'Pasword was reset.';
            }
            elseif (!isset($_GET['user_id']))
            {
                if (isset($_POST['submitForgot1']))
                {
                    $email = isset($_POST['email']) ? $_POST['email'] : '';
                    if ($this->userMapper->existsEmail($email))
                    {
                        // Send a new generated temporary password
                        echo 'Alt ok';
                    }
                    else
                    {
                        echo 'Eposten finnes ikke i v&#229;rt system';
                    }
                }
                $this->loadView('admin/forgotPsw1');
            }
            else
            {
                $this->loadView('admin/forgotPsw');
            }

        }

        private function removeUnactiveUsers()
        {
            $this->userMapper->removeInactiveUsers();
        }

        public function leftContent()
        {

        }

        public function JSONexistsEmail()
        {
            $email = $_POST['email'];

            $hasEmail = $this->userMapper->existsEmail($email);
            $isLegal = filter_var($email, FILTER_VALIDATE_EMAIL);

            if ($isLegal == false || $hasEmail)
            {
                $arr = array('legal' => false);
            }
            else
            {
                $arr = array('legal' => true);
            }

            echo json_encode($arr);
        }

        private function JSONquickRegUser()
        {
            $firstname      = (isset($_POST['firstname']))      ? $_POST['firstname']       : '';
            $lastname       = (isset($_POST['lastname']))       ? $_POST['lastname']        : '';
            $email          = (isset($_POST['email']))          ? $_POST['email']           : '';
            $pass1          = (isset($_POST['password']))       ? $_POST['password']        : '';
            $pass2          = (isset($_POST['confpassword']))   ? $_POST['confpassword']    : '';
            $birthdate      = (isset($_POST['birthdate']))      ? $_POST['birthdate']       : '';
            $telephone      = (isset($_POST['telephone']))      ? $_POST['telephone']       : '';
            $zipcode        = (isset($_POST['zipcode']))        ? $_POST['zipcode']         : '';
            $streetadress   = (isset($_POST['streetadress']))   ? $_POST['streetadress']    : '';
            $acceptTerms    = (isset($_POST['acceptTerms']))    ? $_POST['acceptTerms']     : '';


            $validator = new Validator();
            $validator->addField('firstname', array(Validator::REQUIRED, Validator::NAME));
            $validator->addField('lastname', array(Validator::REQUIRED, Validator::NAME));
            $validator->addField('email', array(Validator::REQUIRED, Validator::EMAIL));
            $validator->addField('password', array(Validator::PASSWD), array('is_equal' => $pass2));
            $validator->addField('birthdate', array(Validator::REQUIRED, Validator::DATE));
            $validator->addField('telephone', array(Validator::REQUIRED, Validator::TLF));
            $validator->addField('zipcode', array(Validator::REQUIRED, Validator::ZIPCODE));
            $validator->addField('streetadress', array(Validator::REQUIRED, Validator::ADDRESS));
            $validator->addField('acceptTerms', array(Validator::REQUIRED), array('checkbox' => '1'));


            if ($this->userMapper->existsEmail($email))
            {
                $validator->setError('email', 'Email already exist.');
            }

            $validator->validate();

            if ($validator->hasErrors())
            {
                $arr = array('success' => false, 'errors' => $validator->getErrors());
                echo json_encode($arr);
                return;
            }

            try
            {
            list($d, $m, $y) = explode("/", $birthdate);
            $birthdate = $m.'/'.$d.'/'.$y;
            $adress = new Address($streetadress, new Location($zipcode));
            $ci = new ContactInfo($telephone, $email, $adress);
            $user = new User(0, $firstname, $lastname, $birthdate, $ci);
            $id = $this->userMapper->insert($user);
            $hashstring = time() . 'snaddjer';
            $hash   = sha1($hashstring);
            $saltajar = '$2a$15$o./48UhxVop0.skwzmg3oG$';
            $pw = crypt($pass1, $saltajar);
            $authy = new Authy($email, $pw, 0, $id, $hash);

            if ($this->autyMapper->insert($authy) == 0)
            {
                $this->userMapper->getRoleMapper()->addRole($id, 3);
                $body = $this->htmlActivateMail($firstname, $hash);
                if ($this->sendMail($email, 'Aktiveringsmail', $body))
                {
                    $arr = array('success' => true);
                    echo json_encode($arr);
                    return;
                }
                else
                {
                    $arr = array('success' => false);
                    echo json_encode($arr);
                    return;
                }
            }
            else
            {
                $arr = array('success' => false);
                echo json_encode($arr);
                return;
            }
            }
            catch (Exception $ex)
            {
            $arr = array('success' => false, 'ex' => $ex->getMessage());
            echo json_encode($arr);
            return;
            }
        }

        public function JSONsendPassword()
        {
            $email = isset($_POST['email']) ? $_POST['email'] : '';

            if ($this->userMapper->existsEmail($email))
            {
                // Generate password and send it to users email
                $user = $this->userMapper->findAll(array('email' => $email));
                $user = $user[0];
                $authy = $this->autyMapper->getByUserID($user->getUserId());
                $pw = $this->passwordGenerator();
                $authy->setHash($pw);
                $this->autyMapper->setTemporaryPassword($authy);
                $body = $this->htmlSendPassword($user->getFirstName(), $pw, $email);
                if ($this->sendMail($email, 'Midlertidig passord', $body))
                {
                    $arr = array("success" => true, "msg" => 'E-post med midlertidig passord sendt.');
                    echo json_encode($arr);
                    return;
                }
                else
                {
                    $arr = array("success" => false, "msg" => 'Kunne ikke sende e-post.');
                    echo json_encode($arr);
                    return;
                }
            }
            else
            {
                $arr = array("success" => false, "msg" => 'E-posten finnes ikke i v&#229;rt system.');
                echo json_encode($arr);
                return;
            }
        }

        private function passwordGenerator()
        {
            $lcLetter = 'abcdefghijklmnopqrstuvwxyz';
            $ucLetter = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $numbers  = '0123456789';

            $retVal = '';
            for ($i = 1; $i <= 8; $i++)
            {
                if ($i % 3 == 0 || $i % 4 == 0)
                {
                    // Number
                    $strpos = mt_rand(1, strlen($numbers));
                    $retVal .= $numbers[$strpos - 1];
                }
                elseif ($i % 2 == 0)
                {
                    // Uppercase letter
                    $strpos = mt_rand(1, strlen($ucLetter));
                    $retVal .= $ucLetter[$strpos - 1];
                }
                else
                {
                    // Lowercase letter
                    $strpos = mt_rand(1, strlen($lcLetter));
                    $retVal .= $lcLetter[$strpos - 1];
                }
            }
            return $retVal;
        }


        public function JSONcompleteReg()
        {
            $firstname      = (isset($_POST['firstname']))      ? $_POST['firstname']       : '';
            $lastname       = (isset($_POST['lastname']))       ? $_POST['lastname']        : '';
            $email          = (isset($_POST['email']))          ? $_POST['email']           : '';
            $telephone      = (isset($_POST['telephone']))      ? $_POST['telephone']       : '';
            $seat_id        = (isset($_POST['seat_id']))        ? $_POST['seat_id']         : '';

            $validator = new Validator();
            $validator->addField('firstname', array(Validator::REQUIRED, Validator::NAME));
            $validator->addField('lastname', array(Validator::REQUIRED, Validator::NAME));
            $validator->addField('email', array(Validator::REQUIRED, Validator::EMAIL));
            $validator->addField('telephone', array(Validator::REQUIRED, Validator::TLF));

            $parent = null;
            if ($this->userMapper->existsEmail($email))
            {
                $validator->setError('email', 'E-post eksisterer i v&#229;r database. Vennligst pr&#248;v p&#229; nytt med en annen adresse');
            }
            elseif ($this->userMapper->existsParentEmail($email))
            {
                $rv = $this->userMapper->getParentMapper()->findAll(['email' => $email]);
                $parent = (count($rv) == 1) ? $rv[0] : null;
            }

            $validator->validate();

            if ($validator->hasErrors())
            {
                $arr = array('success' => false, 'errors' => $validator->getErrors());
                echo json_encode($arr);
                return;
            }

            try
            {
                if (!$parent instanceof Parents)
                {
                    $this->userMapper->makeReservation($this->session->getID(), $seat_id, 99);
                    $hashstring = time() . 'snaddjer';
                    $hash   = sha1($hashstring);
                    $parent = new Parents(0,$telephone, $email, $firstname, $lastname, $hash);
                    $parent->setParent_id($this->userMapper->getParentMapper()->insert($parent));

                    if($parent->getParent_id() != 0)
                    {
                        $user = $this->session->getUser();
                        $user->setParent($parent);
                        $this->userMapper->update($user);
                        $body = $this->htmlVerifyParentMail($firstname . ' ' . $lastname, $user->getName(), $hash, $this->session->getID());
                        if ($this->sendMail($email, 'Aktiveringsmail', $body))
                        {
                            $arr = array('success' => true, 'msg' => 'Foresatt registrert, aktiveringsmail p&#229; tur til din foresattes innbox. Din plass vil være låst i to døgn, og bekreftet når foresatt er aktivert. Hvis ikke vil reservasjonen bli slettet');
                            echo json_encode($arr);
                            return;
                        }
                        else
                        {
                            $arr = array('success' => false, 'msg' => 'Feil med sending av e-post.');
                            echo json_encode($arr);
                            return;
                        }
                    }
                    else
                    {
                        $arr = array('success' => false, 'msg' => 'Noe gikk galt.');
                        echo json_encode($arr);
                        return;
                    }
                }
                else
                {
                    $user = $this->session->getUser();
                    $user->setParent($parent);
                    $this->userMapper->update($user);
                    $arr = array('success' => true, 'msg' => 'Foresatt registrert, siden din foresatt allerede er i v&#229;r database blir det ikke sendt ut en ny aktiveringsmail.');
                    echo json_encode($arr);
                    return;
                }
            }
            catch (Exception $ex)
            {
                $arr = array('success' => false, 'ex' => $ex->getMessage());
                echo json_encode($arr);
                return;
            }
        }

        private function JSONverifyAge()
        {
            $user = $this->session->getUser();
            $d1 = new DateTime(date("Y-m-d", time()));
            $d2 = new DateTime($user->getBirthdate());
            $diff = $d2->diff($d1);
            if ($diff->y >= 18)
            {
                $arr = array("success" => true);
                echo json_encode($arr);
                return;
            }
            elseif ($user->getParent() instanceof Parents)
            {
                if ($user->getParent()->getActivated())
                {
                    $arr = ["success" => true];
                    echo json_encode($arr);
                    return;
                }
                else
                {
                    $arr = ["success" => false, "msg" => "Registrering av foresatt ikke fullf&#248;rt. Aktiveringslink er sendt til din foresattes e-post"];
                    echo json_encode($arr);
                    return;
                }
            }
            else
            {
                $arr = array("success" => false);
                echo json_encode($arr);
                return;
            }
        }

        private function JSONgetUsers()
        {
            $name = isset($_POST['name_search']);
            $users = $this->userMapper->searchUsers($name);
            echo json_encode($users);
        }

        private function sendMail($to, $subject, $body)
        {
            $mail = new PHPMailer();
            $mail->IsHTML();
            /*$mail->IsSMTP();
            $mail->SMTPDebug = 1;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'ssl';
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 465;
            $mail->Username = GMUSER;
            $mail->Password = GMPASS;*/
            $mail->SetFrom('no-reply@nemean.no', 'Nemean');
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->AddAddress($to);
            return ($mail->Send()) ? true : false;
        }

        private function viewMail()
        {
            $type = (isset($_GET['type']))  ? $_GET['type'] : '';
            $hash = (isset($_GET['h']))     ? $_GET['h']    : '';

            if ($type == 2)
            {
                $parent = $this->userMapper->getParentMapper()->findAll(array('hash' => $hash));
                $parent = $parent[0];
                $pname = $parent->getFirstname() . ' ' . $parent->getLastname();
                $user = $this->userMapper->findAll(['parent_id' => $parent->getParent_id()]);
                $uname = $user[0]->getName();
            }
            else
            {	
                $auty = $this->autyMapper->findAll(['hash' => $hash]);
                
                $auty = $auty[0];
                
                $user = $this->userMapper->findById($auty->getUser_id());
                $uname = $user->getName();
            }

            echo '<!DOCTYPE html><html><head><title>Nemean - Vis epost</title><meta http-equiv="content-type" content="text/html; charset=utf-8"  /></head><body bgcolor="#f1f1f1">';

            switch ($type)
            {
                case '0':
                    echo $this->htmlActivateMail($uname, $hash);
                    break;

                case '1':
                    echo $this->htmlWelcomeMail($uname, $hash);
                    break;

                case '2':
                    echo $this->htmlVerifyParentMail($pname, $uname, $hash);
                    break;

            }
            echo '</body></html>';

            exit();
        }

        private function htmlActivateMail($name, $hash)
        {
            $body = '<div style="font-family: Arial, sans-serif;">';
            $body .= '<center style="background: #f1f1f1; background-color: #f1f1f1; line-height: 1.2;"><br />';
            $body .= '<span style="font-size: 11px; color: #777777;">F&#229;r du ikke vist eposten skikkelig? Klikk <a href="http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].'?m=users&qAct=my_mail&type=0&h='.$hash.'" style="font-family: Arial, sans-serif; color: #777777; font-size: 11px; text-decoration: underline;">her</a></span>';
            $body .= '<table cellspacing="0" cellpadding="0" width="647" bgcolor="#FFFFFF"><tbody><tr><td colspan="5" width="647" height="175"><img src="http://nemean.no/resources/site/img/design/mail_header.png" width="647" height="175" alt="" style="display: block;" /></td></tr>';
            $body .= '<tr><td width="1" bgcolor="#ececec"></td><td width="1" bgcolor="#e2e2e2"></td>';
            $body .= '<td align="left" valign="top" width="640" bgcolor="#FFFFFF" style="font-family: Arial, sans-serif; color: #444444; font-size: 16px; line-height: 1.2;">';
            $body .= '<table><tbody><tr><td width="92" bgcolor="#FFFFFF"></td><td width="456" bgcolor="#FFFFFF" align="left" valign="top" style="font-family: Arial, sans-serif; color: #444444; font-size: 16px; line-height: 1.2;">';

            /** Epost teksten her */
            $body .= '<span style="font-size: 18px; font-weight: bold;">Hei, '.$name.'!</span><br /><br />';
            $body .= 'Du er n&#229; registrert i v&#229;rt system. For &#229; kunne logge inn m&#229; du f&#248;rst aktivere din brukerkonto. Det gj&#248;r du ved &#229; klikke <a style="font-family: Arial, sans-serif; color: #444444; font-size: 16px; text-decoration: underline;" href="http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].'?m=users&act=activate&h='.$hash.'">her</a><br /><br />';
            $body .= 'Hvis du ikke aktiverer din brukerkonto innen syv dager vil den automatisk bli slettet fra v&#229;rt system.';
            $body .= '</td><td width="92" bgcolor="#FFFFFF"></td></tr>';
            $body .= '<tr><td colspan="3" width="647" height="50"></td></tr><tr><td width="92" bgcolor="#FFFFFF"></td><td width="456" bgcolor="#FFFFFF" align="left" valign="top" style="font-family: Arial, sans-serif; color: #777777; font-size: 11px; line-height: 1.2;">';

            /** Avsluttende footer */
            $body .= 'Vennlig hilsen,<br />Nemean Crew';
            $body .= '</td><td width="92" bgcolor="#FFFFFF"></td></tr></tbody></table>';
            $body .= '</td><td width="1" bgcolor="#ececec"></td><td width="1" bgcolor="#e2e2e2"></td></tr><tr><td colspan="5" width="647" height="40"><img src="http://nemean.no/resources/site/img/design/mail_footer.png" width="647" height="40" alt="" style="display: block;" /></td></tr></tbody></table><br /></center></div>';

            return $body;
        }

        private function htmlVerifyParentMail($name, $nameUser = "Ola Normann", $hash, $user_id)
        {
            $body = '<div style="font-family: Arial, sans-serif;">';
            $body .= '<center style="background: #f1f1f1; background-color: #f1f1f1; line-height: 1.2;"><br />';
            $body .= '<span style="font-size: 11px; color: #777777;">F&#229;r du ikke vist eposten skikkelig? Klikk <a href="http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].'?m=users&qAct=my_mail&type=2&h='.$hash.'" style="font-family: Arial, sans-serif; color: #777777; font-size: 11px; text-decoration: underline;">her</a></span>';
            $body .= '<table cellspacing="0" cellpadding="0" width="647" bgcolor="#FFFFFF"><tbody><tr><td colspan="5" width="647" height="175"><img src="http://nemean.no/resources/site/img/design/mail_header.png" width="647" height="175" alt="" style="display: block;" /></td></tr>';
            $body .= '<tr><td width="1" bgcolor="#ececec"></td><td width="1" bgcolor="#e2e2e2"></td>';
            $body .= '<td align="left" valign="top" width="640" bgcolor="#FFFFFF" style="font-family: Arial, sans-serif; color: #444444; font-size: 16px; line-height: 1.2;">';
            $body .= '<table><tbody><tr><td width="92" bgcolor="#FFFFFF"></td><td width="456" bgcolor="#FFFFFF" align="left" valign="top" style="font-family: Arial, sans-serif; color: #444444; font-size: 16px; line-height: 1.2;">';

            /** Epostteksten her */
            $body .= '<span style="font-size: 18px; font-weight: bold;">Hei, '.$name.'!</span><br /><br />';

            $body .= 'Ditt barn, '.$nameUser.', &#248;nsker &#229; melde seg p&#229; Nemeans kommende LAN-party i Hemne Samfunnshus. Alt du trenger &#229; gj&#248;re for &#229; bekrefte Deres barns deltagelse,
                      er &#229; klikke <a style="font-family: Arial, sans-serif; color: #444444; font-size: 16px; text-decoration: underline;" href="http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].'?m=users&act=pactivate&h='.$hash.'&su4d='.$user_id.'">her</a>.<br /><br />';


            $body .= '<p>Vi har i &#229;r innf&#248;rt foreldresamtykke for deltagere under 18 &#229;r. For det f&#248;rste er dette en slags garanti for oss p&#229; at ditt barn har tillatelse til &#229; delta.
                          For det andre &#248;nsker vi at mer informasjon kommer ut til dere foreldre. I denne sammenheng har vi utarbeidet en egen informasjonsartikkel det kan v&#230;re greit for dere foresatte &#229; lese.
                          Denne artikkelen kan du lese
                          <a style="font-family: Arial, sans-serif; color: #444444; font-size: 16px; text-decoration: underline;" href="http://nemean.no/zebra.php?m=articles&act=view&artID=34&pID=15">her</a>.
                          I tillegg har vi n&#229; registrert din kontaktinformasjon, b&#229;de telefonnummer og epost. Dette er en sikkerhetsforanstaltning slik at vi raskt kan komme i kontakt med deg i tilfelle det blir behov for det.</p>';

            $body .= '<p>F&#248;r du bekrefter ditt barns deltagelse anbefaler vi deg &#229; lese v&#229;re
                         <a style="font-family: Arial, sans-serif; color: #444444; font-size: 16px; text-decoration: underline;" href="http://nemean.no/zebra.php?m=articles&act=view&artID=34&pID=15">betingelser</a>
                         og v&#229;rt
                         <a style="font-family: Arial, sans-serif; color: #444444; font-size: 16px; text-decoration: underline;" href="http://nemean.no/zebra.php?m=articles&act=view&artID=38&pID=15">reglement</a>.
                         Vi stenger registrering i plasskartet i god tid f&#248;r arrangementet.
                         Hvis ditt barn ikke skal delta, men likevel ikke har avregistrert seg, m&#229; full billettpris betales. I etterkant av arrangementet vil vi sende giro til de det m&#229;tte gjelde.
                         Vi &#248;nsker derfor &#229; gj&#248;re deg oppmerksom p&#229; dette. Stenging av plasskart vil bli annonsert som hovedoppslag p&#229; nettsiden v&#229;r, samt p&#229; v&#229;r Facebook-side.</p><br>';

            $body .= '<p><b>OBS!</b><br>Hvis flere barn under 18 &#229;r registrerer seg i v&#229;rt plasskart hvor du er registrert som foresatt/forelder, sender vi kun én epost med bekreftelse: Vi gj&#248;r oppmerksom p&#229; at du fremdeles st&#229;r oppf&#248;rt som kontaktperson p&#229; de respektive barna i v&#229;r database.</p> ';


            $body .= '</td><td width="92" bgcolor="#FFFFFF"></td></tr>';
            $body .= '<tr><td colspan="3" width="647" height="50"></td></tr><tr><td width="92" bgcolor="#FFFFFF"></td><td width="456" bgcolor="#FFFFFF" align="left" valign="top" style="font-family: Arial, sans-serif; color: #777777; font-size: 11px; line-height: 1.2;">';

            /** Avsluttende footer */
            $body .= 'Vennlig hilsen,<br />Nemean Crew';
            $body .= '</td><td width="92" bgcolor="#FFFFFF"></td></tr></tbody></table>';
            $body .= '</td><td width="1" bgcolor="#ececec"></td><td width="1" bgcolor="#e2e2e2"></td></tr><tr><td colspan="5" width="647" height="40"><img src="http://nemean.no/resources/site/img/design/mail_footer.png" width="647" height="40" alt="" style="display: block;" /></td></tr></tbody></table><br /></center></div>';

            return $body;
        }

        private function htmlWelcomeMail($name, $hash)
        {
            $body = '<div style="font-family: Arial, sans-serif;">';
            $body .= '<center style="background: #f1f1f1; background-color: #f1f1f1; line-height: 1.2;"><br />';
            $body .= '<span style="font-size: 11px; color: #777777;">F&#229;r du ikke vist eposten skikkelig? Klikk <a href="http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].'?m=users&qAct=my_mail&type=1&h='.$hash.'" style="font-family: Arial, sans-serif; color: #777777; font-size: 11px; text-decoration: underline;">her</a></span>';
            $body .= '<table cellspacing="0" cellpadding="0" width="647" bgcolor="#FFFFFF"><tbody><tr><td colspan="5" width="647" height="175"><img src="http://nemean.no/resources/site/img/design/mail_header.png" width="647" height="175" alt="" style="display: block;" /></td></tr>';
            $body .= '<tr><td width="1" bgcolor="#ececec"></td><td width="1" bgcolor="#e2e2e2"></td>';
            $body .= '<td align="left" valign="top" width="640" bgcolor="#FFFFFF" style="font-family: Arial, sans-serif; color: #444444; font-size: 16px; line-height: 1.2;">';
            $body .= '<table><tbody><tr><td width="92" bgcolor="#FFFFFF"></td><td width="456" bgcolor="#FFFFFF" align="left" valign="top" style="font-family: Arial, sans-serif; color: #444444; font-size: 16px; line-height: 1.2;">';

            /** Epost teksten her */
            $body .= '<span style="font-size: 18px; font-weight: bold;">Velkommen, '.$name.'!</span><br /><br />';
            $body .= '<br />';
            $body .= '<span style="font-size: 16px; font-weight: bold; color: #444444;">Nyttige lenker:</span><br />';
            $body .= '<a href="http://nemean.no/zebra.php?m=articles&act=view&artID=27&pID=15" style="font-family: Arial, sans-serif; color: #777777; font-size: 16px; text-decoration: underline;">Utstyrsliste</a> <br /> <a href="http://nemean.no/zebra.php?m=articles&act=view&artID=33" style="font-family: Arial, sans-serif; color: #777777; font-size: 16px; text-decoration: underline;">FAQ</a>';
            $body .= '</td><td width="92" bgcolor="#FFFFFF"></td></tr>';
            $body .= '<tr><td colspan="3" width="647" height="50"></td></tr><tr><td width="92" bgcolor="#FFFFFF"></td><td width="456" bgcolor="#FFFFFF" align="left" valign="top" style="font-family: Arial, sans-serif; color: #777777; font-size: 11px; line-height: 1.2;">';

            /** Avsluttende footer */
            $body .= 'Vennlig hilsen,<br />Nemean Crew';
            $body .= '</td><td width="92" bgcolor="#FFFFFF"></td></tr></tbody></table>';
            $body .= '</td><td width="1" bgcolor="#ececec"></td><td width="1" bgcolor="#e2e2e2"></td></tr><tr><td colspan="5" width="647" height="40"><img src="http://nemean.no/resources/site/img/design/mail_footer.png" width="647" height="40" alt="" style="display: block;" /></td></tr></tbody></table><br /></center></div>';

            return $body;
        }

        private function htmlSendPassword($name, $pw, $em)
        {
            $body = '<div style="font-family: Arial, sans-serif;">';
            $body .= '<center style="background: #f1f1f1; background-color: #f1f1f1; line-height: 1.2;"><br />';
            $body .= '<span style="font-size: 11px; color: #777777;"></span>';
            $body .= '<table cellspacing="0" cellpadding="0" width="647" bgcolor="#FFFFFF"><tbody><tr><td colspan="5" width="647" height="175"><img src="http://nemean.no/resources/site/img/design/mail_header.png" width="647" height="175" alt="" style="display: block;" /></td></tr>';
            $body .= '<tr><td width="1" bgcolor="#ececec"></td><td width="1" bgcolor="#e2e2e2"></td>';
            $body .= '<td align="left" valign="top" width="640" bgcolor="#FFFFFF" style="font-family: Arial, sans-serif; color: #444444; font-size: 16px; line-height: 1.2;">';
            $body .= '<table><tbody><tr><td width="92" bgcolor="#FFFFFF"></td><td width="456" bgcolor="#FFFFFF" align="left" valign="top" style="font-family: Arial, sans-serif; color: #444444; font-size: 16px; line-height: 1.2;">';

            /** Epost teksten her */
            $body .= '<span style="font-size: 18px; font-weight: bold;">Hei, '.$name.'!</span><br /><br />';
            $body .= '<br />';
            $body .= 'Det er blitt generert et midlertidig passord for din brukerkonto:<br /><br />';
            $body .= 'Passord: '.$pw;
            $body .= '<br /><br /><a href="http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].'?m=users&act=reset&email='.$em.'" style="font-family: Arial, sans-serif; color: #777777; font-size: 16px; text-decoration: underline;">Klikk her</a> for &#229; sette et nytt passord til din brukerkonto.';
            $body .= '<br /><br />Merk: Du kan fremdeles logge inn med ditt gamle passord.';
            $body .= '</td><td width="92" bgcolor="#FFFFFF"></td></tr>';
            $body .= '<tr><td colspan="3" width="647" height="50"></td></tr><tr><td width="92" bgcolor="#FFFFFF"></td><td width="456" bgcolor="#FFFFFF" align="left" valign="top" style="font-family: Arial, sans-serif; color: #777777; font-size: 11px; line-height: 1.2;">';

            /** Avsluttende footer */
            $body .= 'Vennlig hilsen,<br />Nemean Crew';
            $body .= '</td><td width="92" bgcolor="#FFFFFF"></td></tr></tbody></table>';
            $body .= '</td><td width="1" bgcolor="#ececec"></td><td width="1" bgcolor="#e2e2e2"></td></tr><tr><td colspan="5" width="647" height="40"><img src="http://nemean.no/resources/site/img/design/mail_footer.png" width="647" height="40" alt="" style="display: block;" /></td></tr></tbody></table><br /></center></div>';

            return $body;
        }

        private function mailApplication($firstname, $lastname, $age, $why, $what)
        {
            $body = '<div style="font-family: Arial, sans-serif;">';
            $body .= '<center style="background: #f1f1f1; background-color: #f1f1f1; line-height: 1.2;"><br />';
            $body .= '<span style="font-size: 11px; color: #777777;"></span>';
            $body .= '<table cellspacing="0" cellpadding="0" width="647" bgcolor="#FFFFFF"><tbody><tr><td colspan="5" width="647" height="175"><img src="http://nemean.no/resources/site/img/design/mail_header.png" width="647" height="175" alt="" style="display: block;" /></td></tr>';
            $body .= '<tr><td width="1" bgcolor="#ececec"></td><td width="1" bgcolor="#e2e2e2"></td>';
            $body .= '<td align="left" valign="top" width="640" bgcolor="#FFFFFF" style="font-family: Arial, sans-serif; color: #444444; font-size: 16px; line-height: 1.2;">';
            $body .= '<table><tbody><tr><td width="92" bgcolor="#FFFFFF"></td><td width="456" bgcolor="#FFFFFF" align="left" valign="top" style="font-family: Arial, sans-serif; color: #444444; font-size: 16px; line-height: 1.2;">';

            $body = '<h1>'.htmlentities('Crew-søknad for Nemean').'</h1><br><br>';

            $body .='<b>Navn:</b> '. ucwords(strtolower(htmlentities($firstname))) ." ". ucwords(strtolower(htmlentities($lastname))) . '<br>';
            $body .='<b>'.htmlentities('Fødselsår').':</b> '. htmlentities($age). '<br>';
            $body .='<br><br><b>Hvorfor velge meg?</b> <br><br>'. htmlentities($why);
            $body .='<br><br><b>Hva kan jeg bidra med?</b><br><br>'. htmlentities($what);


            /** Avsluttende footer */
            $body .= '<br><br>Vennlig hilsen,<br />'. ucwords(strtolower(htmlentities($firstname))). " ". ucwords(strtolower(htmlentities($lastname)));
            $body .= '</td><td width="92" bgcolor="#FFFFFF"></td></tr></tbody></table>';
            $body .= '</td><td width="1" bgcolor="#ececec"></td><td width="1" bgcolor="#e2e2e2"></td></tr><tr><td colspan="5" width="647" height="40"><img src="http://nemean.no/resources/site/img/design/mail_footer.png" width="647" height="40" alt="" style="display: block;" /></td></tr></tbody></table><br /></center></div>';


            return $body;

        }

    }
?>
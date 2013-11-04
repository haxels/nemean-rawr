<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ragnar
 * Date: 5/1/12
 * Time: 7:04 PM
 * To change this template use File | Settings | File Templates.
 */

    require_once MODULEPATH . 'users/classes/AuthyMapper.php';
    require_once MODULEPATH . 'users/classes/UserMapper.php';
    require_once MODULEPATH . 'users/classes/ParentsMapper.php';
    require_once MODULEPATH . 'users/classes/RoleMapper.php';

    class Session
    {
        private $authyMapper;
        private $userMapper;
        private $error;
        private $user;

        public function __construct(IDatabaseAdapter $adapter)
        {
            $this->authyMapper = new AuthyMapper($adapter);
            $this->userMapper = new UserMapper($adapter, new ParentsMapper($adapter), new RoleMapper($adapter));
            $this->error = '';
        }

        public function getError()
        {
            return $this->error;
        }

        public function getID()
        {
            return ($this->isAuthenticated()) ? $_SESSION['user_id'] : 0;
        }

        public function getUsername()
        {
            return ($this->isAuthenticated()) ? $_SESSION['username'] : '';
        }

        public function isAuthenticated()
        {
            return (isset($_SESSION['user_id']) && $_SESSION['user_id'] != 0);
        }

        public function getUser()
        {
            if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != 0)
            {
                if (!is_object($this->user))
                {
                    $this->user = $this->userMapper->findById($this->getID());
                }
                return $this->user;
            }
            else
            {
                $user = new User(0, 'Guest', '');
                $user->setRoles(array(new Role(0, 'Guest', 0)));
                return $user;
            }
        }

        public function getUserMapper()
        {
            return $this->userMapper;
        }

        public function isAuthorized(array $roles = array())
        {
            if (!$this->isAuthenticated())
            {
                return false;
            }
            else
            {
                $user = $this->userMapper->findById($_SESSION['user_id']);
                return $user->isInRole($roles);
            }
        }

        public function login($username, $password, array $roles = array())
        {
            $arr = [];
            $authy = $this->authyMapper->authenticate($username, $password);

            if ($authy instanceof Authy)
            {
                $user  = $this->userMapper->findById($authy->getUser_id());

                if (!$authy->getActivated())
                {
                    $this->error = 'User is not activated';
                    $arr['error'] = $this->error;
                    $arr['success'] = false;
                }
                elseif (!$user->isInRole($roles))
                {
                    $this->error = 'User not authorized';
                    $arr['error'] = $this->error;
                    $arr['success'] = false;
                }
                else
                {
                    $_SESSION['user_id'] = $authy->getUser_id();
                    $_SESSION['username'] = $authy->getUsername();
                    $this->user = $this->userMapper->findById($authy->getUser_id());
                    $this->userMapper->updateLastLoggedIn($authy->getUser_id());
                    $arr['success'] = true;
                }
            }
            else
            {
                $this->error = 'User credentials was not authenticated';
                $arr['error'] = $this->error;
                $arr['success'] = false;
            }
            echo json_encode($arr);
        }

        public function checkPassword($username, $password)
        {
            return ($this->authyMapper->authenticate($username, $password) instanceof Authy) ? true: false;
        }

        public function logout()
        {
            session_unset('user_id');
            session_unset('username');
            session_destroy();
        }

    }

<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 26.03.12
 * Time: 20:55
 * To change this template use File | Settings | File Templates.
 */
    require_once SYSPATH.'db/DataMapper.php';
    require_once 'Authy.php';

    class AuthyMapper extends DataMapper
    {
        protected $entityTable = 'usr_authy';
        protected $primaryKey = 'username';

        public function authenticate($username, $password)
        {
            $saltajar = '$2a$15$o./48UhxVop0.skwzmg3oG$';
            $pw = crypt($password, $saltajar);
            $sql = 'SELECT `username`, `password`, `activated`, `user_id`, `hash`
                    FROM `'.$this->entityTable.'`
                    WHERE `username` = :username AND `password` = :password';
            $this->adapter->prepare($sql)->execute(array($username, $pw));
            $row = $this->adapter->fetch();

            if ($this->adapter->getAffectedRows() == 1)
            {
                return $this->createEntity($row);
            }
            return false;
        }

        public function insert(Authy $authy)
        {
            return $this->adapter->insert($this->entityTable, array('username'  => $authy->getUsername(),
                                                                    'password'  => $authy->getPassword(),
                                                                    'activated' => $authy->getActivated(),
                                                                    'user_id'   => $authy->getUser_id(),
                                                                    'hash'      => $authy->getHash()));
        }

        public function update(Authy $authy)
        {
            return $this->adapter->update($this->entityTable, array('username' => $authy->getUsername(),
                                                             'password' => $authy->getPassword(),
                                                             'activated' => $authy->getActivated()),
                                          'user_id = '.$authy->getUser_id());
        }

        public function activate($user_id)
        {
            return $this->adapter->update($this->entityTable, array('activated' => 1), 'user_id = '.$user_id);
        }

        public function unActivate($user_id)
        {
            return $this->adapter->update($this->entityTable, array('activated' => 0), 'user_id = '.$user_id);
        }

        public function setTemporaryPassword(Authy $a)
        {
            return $this->adapter->update($this->entityTable, array('hash' => $a->getHash()), 'user_id = ' . $a->getUser_id());
        }

        public function checkTemporaryPassword($password, $user_id)
        {
            $this->adapter->select($this->entityTable, array('hash' => sha1($password), 'user_id' => $user_id));
            return ($this->adapter->getAffectedRows() == 1) ? true : false;
        }
        
        public function getByUserID($user_id)
        {
            
            $sql = "SELECT * FROM {$this->entityTable} WHERE user_id = {$user_id}"; 
            $this->adapter->prepare($sql)->execute();
            $row = $this->adapter->fetch();

            if ($this->adapter->getAffectedRows() == 1)
            {
                return $this->createEntity($row);
            }
            return false;
        }

        protected function createEntity(array $row)
        {
            return new Authy($row['username'], $row['password'], $row['activated'], $row['user_id'], $row['hash']);
        }

    }

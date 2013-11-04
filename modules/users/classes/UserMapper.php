<?php
/**
 * User: Ragnar
 * Date: 3/25/12
 * Time: 6:14 PM
 */
    require_once SYSPATH.'db/DataMapper.php';
    require_once SYSPATH.'Location.php';
    require_once 'Address.php';
    require_once 'ContactInfo.php';
    require_once 'User.php';

    class UserMapper extends DataMapper
    {
        protected $entityTable = 'usr_users';
        protected $primaryKey = 'user_id';

        private $parentsMapper;
        private $roleMapper;

        public function __construct(IDatabaseAdapter $adapter, ParentsMapper $pm, RoleMapper $rm)
        {
            parent::__construct($adapter);
            $this->parentsMapper    = $pm;
            $this->roleMapper       = $rm;
        }

        public function getParentMapper()
        {
            return $this->parentsMapper;
        }

        public function getRoleMapper()
        {
            return $this->roleMapper;
        }

        public function insert(User $user)
        {
            if ($user->getParent() == null)
            {
                $parent_id = NULL;
            }
            else
            {
                $parent_id =  $this->parentsMapper->insert($user->getParent());
                $this->parentsMapper->update($user->getParent());
            }
            
            
            $this->roleMapper->addRoles($user->getUserId(), $user->getRoles());

            return $this->adapter->insert($this->entityTable, array('telephone' => $user->getContactInfo()->getTelephone(),
                                                             'email'            => $user->getContactInfo()->getEmail(),
                                                             'firstname'        => $user->getFirstname(),
                                                             'lastname'         => $user->getLastname(),
                                                             'streetaddress'    => $user->getContactInfo()->getAddress()->getStreetaddress(),
                                                             'zipcode'          => $user->getContactInfo()->getAddress()->getZipLocation()->getZipCode(),
                                                             'birthdate'        => $user->getBirthdate(),
                                                             'parent_id'        => $parent_id));

        }

        public function quickInsert(User $user)
        {
            if ($user->getParent() == null)
            {
                $parent_id = NULL;
            }
            else
            {
                $parent_id =  $this->parentsMapper->insert($user->getParent());
            }

            $this->roleMapper->addRoles($user->getUserId(), $user->getRoles());

            return $this->adapter->insert($this->entityTable, array(
                                                                    'email'            => $user->getContactInfo()->getEmail(),
                                                                    'firstname'        => $user->getFirstname(),
                                                                    'lastname'         => $user->getLastname(),
                                                                    'parent_id'        => $parent_id));
        }



        public function update(User $user)
        {
            
            $this->parentsMapper->update($user->getParent());
            return $this->adapter->update($this->entityTable, array('telephone'     => $user->getContactInfo()->getTelephone(),
                                                                    'email'         => $user->getContactInfo()->getEmail(),
                                                                    'firstname'     => $user->getFirstname(),
                                                                    'lastname'      => $user->getLastname(),
                                                                    'streetaddress' => $user->getContactInfo()->getAddress()->getStreetaddress(),
                                                                    'zipcode'       => $user->getContactInfo()->getAddress()->getZipLocation()->getZipCode(),
                                                                    'birthdate'     => $user->getBirthdate(),
                                                                    'parent_id'     => $user->getParent()->getParent_id()),
                                          $this->primaryKey.' = '.$user->getUserId());
        }

        public function findAll(array $bind = array())
        {
            if ($bind)
            {
                $where = array();
                foreach ($bind as $col => $value)
                {
                    unset($bind[$col]);
                    $bind[':'.$col] = $value;
                    $where[] = $col . ' = :' . $col;
                }
            }

            $sql = 'SELECT * FROM usr_users, usr_authy WHERE usr_users.user_id = usr_authy.user_id ' . (($bind) ? 'AND '.implode(' AND ', $where) : ' ');

            $this->adapter->prepare($sql)->execute($bind);
            $rows = $this->adapter->fetchAll();
            $entities = array();
            if ($rows)
            {
                foreach ($rows as $row)
                {
                    $entities[] = $this->createEntity($row);
                }
            }
            return $entities;
        }

        public function getUsersByLevel($level = 0)
        {
            $sql = "SELECT *
                    FROM usr_users, usr_roles, usr_user_roles
                    WHERE usr_users.user_id = usr_user_roles.user_id
                        AND usr_roles.role_id = usr_user_roles.role_id
                            AND level <= ".(int)$level;

            $this->adapter->prepare($sql)->execute();
            $rows = $this->adapter->fetchAll();
            $entities = array();
            if ($rows)
            {
                foreach ($rows as $row)
                {
                    $entities[] = $this->createEntity($row);
                }
            }
            return $entities;
        }

        public function existsEmail($email)
        {
            $retVal = $this->findAll(array('email' => $email));
            return (count($retVal) >= 1) ? true : false;
        }

        public function existsParentEmail($email)
        {

            $sql = "SELECT email FROM usr_parents where email = :email";
            $this->adapter->prepare($sql)->execute(array($email));

            return ($this->adapter->getAffectedRows()>0) ? true : false;

        }

        public function makeReservation($user_id=0, $seat_id=0, $type=0)
        {
            return $this->adapter->insert('rsv_reservations', array('seat_id' => $seat_id,
                                                                    'user_id' => $user_id,
                                                                    'type' => $type));

        }

        public function updateLastLoggedIn($user_id)
        {
            return $this->adapter->update($this->entityTable, array('lastloggedin' => date("Y-m-d H:i:s", time())), $this->primaryKey.' = '.$user_id);
        }

        public function removeInactiveUsers()
        {
            $sql = 'SELECT `u`.`user_id`
                    FROM `usr_users` `u`, `usr_authy` `a`
                    WHERE
                      TO_DAYS(NOW()) - TO_DAYS(`u`.`regdate`) > 7
                    AND
                      `u`.`user_id` = `a`.`user_id`
                    AND
                      `a`.`activated` = 0';

            //$sql2 = "DELETE FROM rsv_reservations WHERE TO_DAYS(NOW()) - TO_DAYS(`date`) >= 2 AND type = 99";
            $this->adapter->prepare($sql)->execute();
            //$this->adapter->prepare($sql2)->execute();
            $rows = $this->adapter->fetchAll();
            if (count($rows) > 0)
            {
                //$ids = [];
                foreach ($rows as $row)
                {
                    $ids[] = $row['user_id'];
                }
                $ids = implode(", ", $ids);
                $sql = 'DELETE FROM `usr_users` WHERE `user_id` IN ('.$ids.');';
                $this->adapter->prepare($sql)->execute();
            }
        }

        public function userArray()
        {
            $sql = 'SELECT `u`.`firstname`, `u`.`lastname`, `a`.`activated` FROM `usr_users` `u` JOIN `usr_authy` `a` ON (`a`.`user_id` = `u`.`user_id`)';
            $this->adapter->prepare($sql)->execute();
            $rows = $this->adapter->fetchAll();
            $retVal = [];
            if (count($rows > 0))
            {
                foreach ($rows as $row)
                {
                    $retVal[] = ['fname' => $row['firstname'], 'lname' => $row['lastname'], 'activated' => $row['activated']];
                }
            }
            return $retVal;
        }

        public function updateReservation($user_id){
            $sql = sprintf('UPDATE rsv_reservations SET type = 0 WHERE user_id = %s LIMIT 1', $user_id);
            if($this->adapter->prepare($sql)->execute()){

                return true;
            }
        }

        public function searchUsers($name)
        {
            $sql = sprintf('SELECT `user_id`, `firstname`, `lastname` FROM `usr_users` WHERE `firstname` LIKE \'%%s%\' OR `lastname` LIKE \'%%s%\'', $name);
            $this->adapter->prepare($sql)->execute();
            $rows = $this->adapter->fetchAll();
            $retVal = [];
            foreach ($rows as $row)
            {
                $retVal[$row['user_id']] = $row['firstname'] . ' ' . $row['lastname'];
            }
            return $retVal;
        }

        public function deleteReservation($user_id)
        {
            return $this->adapter->delete('rsv_reservations','user_id = '.$user_id);
        }

        protected function createEntity(array $row)
        {
            $location = new Location($row['zipcode']);
            $address = new Address($row['streetaddress'], $location);
            $contactInfo = new ContactInfo($row['telephone'], $row['email'], $address);
            $parents = $this->parentsMapper->findById($row['parent_id']);
            $roles = $this->roleMapper->getByUserId($row['user_id']);
            $authy = null;
            if (isset($row['activated']))
            {
                $authy = new Authy($row['username'], $row['password'], $row['activated'], $row['user_id'], $row['hash']);
            }

            return new User($row['user_id'], $row['firstname'], $row['lastname'],$row['birthdate'], $contactInfo, $parents, $roles, $authy, $row['regdate'], $row['lastloggedin']);
        }
        
        
        
    }
?>

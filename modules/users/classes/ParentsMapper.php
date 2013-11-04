<?php
/**
 * User: Ragnar
 * Date: 3/25/12
 * Time: 8:38 PM
 */
    require_once SYSPATH.'db/DataMapper.php';
    require_once 'Parents.php';

    class ParentsMapper extends DataMapper
    {
        protected $entityTable = 'usr_parents';
        protected $primaryKey = 'parent_id';

        public function insert(Parents $parent)
        {
            return $this->adapter->insert($this->entityTable, array('telephone' => $parent->getTelephone(),
                                                                    'email'     => $parent->getEmail(),
                                                                    'firstname' => $parent->getFirstname(),
                                                                    'lastname'  => $parent->getLastname(),
                                                                    'hash'      => $parent->getHash()));
        }

        public function update(Parents $parent)
        {
            return $this->adapter->update($this->entityTable, array('telephone' => $parent->getTelephone(),
                                                                    'email'     => $parent->getEmail(),
                                                                    'firstname' => $parent->getFirstname(),
                                                                    'lastname'  => $parent->getLastname(),
                                                                    'activated' => $parent->getActivated()),
                                          $this->primaryKey.' = '.$parent->getParent_id());
        }

        protected function createEntity(array $row)
        {
            return new Parents($row['parent_id'], $row['telephone'], $row['email'], $row['firstname'], $row['lastname'], $row['hash'], $row['activated']);
        }


    }

<?php
/**
 * User: Ragnar
 * Date: 3/25/12
 * Time: 8:29 PM
 */
    require_once SYSPATH.'db/DataMapper.php';
    require_once 'Role.php';

    class RoleMapper extends DataMapper
    {
        protected $entityTable = 'usr_roles';
        protected $primaryKey = 'role_id';

        public function getByUserId($user_id)
        {
            $sql = sprintf('SELECT `usr_roles`.`role_id`, `role`, `level` FROM `usr_roles`, `usr_user_roles` WHERE `usr_user_roles`.`user_id` = %s AND `usr_user_roles`.`role_id` = `usr_roles`.`role_id`;', (int) $user_id);
            $this->adapter->prepare($sql)->execute();
            $entities = array();

            while ($row = $this->adapter->fetch())
            {
                $entities[] = $this->createEntity($row);
            }
            return $entities;
        }

        public function addRole($user_id, $role_id)
        {
            $sql = sprintf('INSERT INTO `usr_user_roles` VALUES (%s, %s);', (int) $user_id, (int) $role_id);
            $this->adapter->prepare($sql)->execute();
            return ($this->adapter->getAffectedRows() == 1) ? true : false;
        }

        public function addRoles($user_id, array $roles = array())
        {
            foreach ($roles as $role)
            {
                $this->addRole($user_id, $role->getRole_id());
            }
            return ($this->adapter->getAffectedRows() > 0) ? true : false;
        }

        public function removeRole($user_id, $role_id)
        {
            $sql = sprintf('DELETE FROM `usr_user_roles` WHERE `user_id` = %s AND `role_id` = %s LIMIT 1;', (int) $user_id, (int) $role_id);
            $this->adapter->prepare($sql)->execute();
            return ($this->adapter->getAffectedRows() == 1) ? true : false;
        }

        public function removeAllUserRoles($user_id)
        {
            $sql = sprintf('DELETE FROM `usr_user_roles` WHERE `user_id` = %s;', (int) $user_id);
            $this->adapter->prepare($sql)->execute();
            return ($this->adapter->getAffectedRows() > 0) ? $this->adapter->getAffectedRows() : false;
        }

        public function insert(Role $role)
        {
            return $this->adapter->insert($this->entityTable, array('role' => $role->getRole()));
        }

        public function update(Role $role)
        {
            return $this->adapter->update($this->entityTable, array('role' => $role->getRole()), $this->primaryKey.' = '.$role->getRole_id());
        }

        public function getLevel($user_id)
        {
            $sql = sprintf('SELECT SUM(`level`) as \'level\' FROM `usr_roles` `r`, `usr_user_roles` `ur` WHERE `r`.`role_id` = `ur`.`role_id` AND `user_id` = %s;', $user_id);
            $this->adapter->prepare($sql)->execute();
            $row = $this->adapter->fetch();
            return $row['level'];
        }

        protected function createEntity(array $row)
        {
            return new Role($row['role_id'], $row['role'], $row['level']);
        }
    }
<?php
/**
 * User: Ragnar
 * Date: 3/25/12
 * Time: 5:48 PM
 */
    require_once 'IDatabaseAdapter.php';

    abstract class DataMapper
    {
        protected $adapter;
        protected $entityTable;
        protected $primaryKey;
        protected $id;

        public function __construct(IDatabaseAdapter $adapter)
        {
            $this->adapter = $adapter;
        }

        public function getAdapter()
        {
            return $this->adapter;
        }

        public function findById($id)
        {
            $this->adapter->select($this->entityTable, array($this->primaryKey => $id));
            if (!$row = $this->adapter->fetch())
            {
                return null;
            }
            return $this->createEntity($row);
        }

        public function findAll(array $conditions = array())
        {
            $entities = array();
            $this->adapter->select($this->entityTable, $conditions);
            $rows = $this->adapter->fetchAll();
            if ($rows)
            {
                foreach ($rows as $row)
                {
                    $entities[] = $this->createEntity($row);
                }
            }
            return $entities;
        }

        public function delete($where)
        {
            return $this->adapter->delete($this->entityTable, $where);
        }

        public function deletePK($id)
        {
            return $this->adapter->delete($this->entityTable, $this->primaryKey.' = '.$id);
        }

        abstract protected function createEntity(array $row);

    }
<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ragnar
 * Date: 4/25/12
 * Time: 6:19 PM
 * To change this template use File | Settings | File Templates.
 */
    require_once 'Setting.php';

    class SettingsMapper extends DataMapper
    {
        protected $entityTable = 'settings';
        protected $primaryKey = 'name';


        public function update(Setting $s)
        {
            return $this->adapter->update($this->entityTable, array('value' => $s->getValue()),
                                          $this->primaryKey . ' = ' . '\''.$s->getName().'\'');
        }

        protected function createEntity(array $row)
        {
            return new Setting($row['type'], $row['name'], $row['value']);
        }

    }

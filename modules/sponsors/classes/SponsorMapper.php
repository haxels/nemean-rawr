<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 20.06.12
 * Time: 16:07
 * To change this template use File | Settings | File Templates.
 */
require_once MODULEPATH . 'sponsors/classes/Sponsor.php';

class SponsorMapper extends DataMapper
{
    protected $entityTable = 'sponsors';
    protected $primaryKey = 'sponsor_id';

    public function __construct(IDatabaseAdapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function insert(Sponsor $s)
    {
        return $this->adapter->insert($this->entityTable, array('name' => $s->getName(),
                                                                'image' => $s->getImage(),
                                                                'link' => $s->getLink()));
    }

    public function update(Sponsor $s)
    {
        return $this->adapter->update($this->entityTable, array('name' => $s->getName(),
                                                                'image' => $s->getImage(),
                                                                'link' => $s->getLink()),
                                      $this->primaryKey .' = ' . $s->getSponsorId());
    }

    protected function createEntity(array $row)
    {
        return new Sponsor($row['sponsor_id'], $row['name'], $row['image'], $row['link']);
    }

}

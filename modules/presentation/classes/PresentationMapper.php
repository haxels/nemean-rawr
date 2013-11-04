<?php

require_once('Slide.php');
/**
 * Created by JetBrains PhpStorm.
 * User: havardaxelsen
 * Date: 2/13/13
 * Time: 11:04 PM
 * To change this template use File | Settings | File Templates.
 */
class PresentationMapper extends DataMapper
{
    protected $entityTable = 'prs_slides';
    protected $primaryKey  = 'slide_id';

    public function __construct(IDatabaseAdapter $adapter)
    {
        parent::__construct($adapter);
    }

    public function insert(Slide $s)
    {
        return $this->adapter->insert($this->entityTable, array('title' => $s->getTitle(),
                                                                'content' => $s->getContent(),
                                                                'effects' => $s->getEffects()));

    }

    public function update(Slide $s)
    {
        return $this->adapter->update($this->entityTable, array('title' => $s->getTitle(),
                                                                'content' => $s->getContent(),
                                                                'effects' => $s->getEffects()),
            $this->primaryKey.' = '.$s->getSlideId());
    }


    protected function createEntity(array $row)
    {
        return new Slide( $row['slide_id'],
                          $row['title'],
                          $row['content'],
                          $row['effects']);
    }


}

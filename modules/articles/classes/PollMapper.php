<?php
/**
 * User: Ragnar
 * Date: 4/5/12
 * Time: 6:22 PM
 */
class PollMapper extends DataMapper
{
    protected $entityTable = 'art_polls';
    protected $primaryKey = 'poll_id';

    public function insert(Poll $poll)
    {
        return $this->adapter->insert($this->entityTable, array('question' => $poll->getQuestion(),
                                                                'duedate' => $poll->getDuedate()));
    }

    public function update(Poll $poll)
    {
        return $this->adapter->update($this->entityTable, array('qustion' => $poll->getQuestion(),
                                                                'duedate' => $poll->getDuedate()),
                                      $this->primaryKey.' = '.$poll->getPoll_id());
    }

    protected function createEntity(array $row)
    {
        return new Poll($row['poll_id'], $row['question'], $row['duedate']);
    }
}

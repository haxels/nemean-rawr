<?php
/**
 * User: Ragnar
 * Date: 4/5/12
 * Time: 6:23 PM
 */
class AnswerMapper extends DataMapper
{
    protected $entityTable = 'art_answers';
    protected $primaryKey = 'answer_id';

    public function insert(Answer $answer)
    {
        return $this->adapter->insert($this->entityTable, array('poll_id' => $answer->getPoll_id(),
                                                                 'answer' => $answer->getAnswers()));
    }

    public function update(Answer $answer)
    {
        return $this->adapter->update($this->entityTable, array('poll_id' => $answer->getPoll_id(),
                                                                 'answer' => $answer->getAnswers()),
                                      $this->primaryKey.' = '.$answer->getAnswer_id());
    }

    protected function createEntity(array $row)
    {
        return new Answer($row['answer_id'], $row['poll_id'], $row['answer']);
    }

}

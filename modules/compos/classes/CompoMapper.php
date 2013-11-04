<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 28.06.12
 * Time: 01:44
 * To change this template use File | Settings | File Templates.
 */
require_once MODULEPATH . 'compos/classes/Compo.php';
require_once MODULEPATH . 'compos/classes/Team.php';
require_once MODULEPATH . 'compos/classes/Manager.php';
require_once MODULEPATH . 'compos/classes/Leader.php';
require_once MODULEPATH . 'compos/classes/Competitor.php';

class CompoMapper extends DataMapper
{
    protected $entityTable = 'cmp_compos';
    protected $primaryKey  = 'compo_id';

    public function insert(Compo $compo)
    {
        return $this->adapter->insert($this->entityTable, array('compo_name' => $compo->getCompoName(),
                                                            'signup_start' => $compo->getSignupStart(),
                                                            'signup_due' => $compo->getSignupDue(),
                                                            'compo_manager' => $compo->getCompoManager(),
                                                            'num_competitors' => $compo->getNumCompetitors()));
    }

    public function getOpenCompos()
    {
        $sql = 'SELECT * FROM `cmp_compos` WHERE NOW() BETWEEN DATE_ADD(`signup_start`, INTERVAL -7 DAY) AND DATE_ADD(`signup_due`, INTERVAL 7 DAY)';
        $this->adapter->prepare($sql)->execute();
        $rows = $this->adapter->fetchAll();
        $retVal = [];
        foreach ($rows as $row)
        {
            $retVal[] = $this->createEntity($row);
        }
        return $retVal;
    }

    public function getUserIds()
    {
        $sql = 'SELECT `user_id` FROM `usr_users`';
        $this->adapter->prepare($sql)->execute();
        $rows = $this->adapter->fetchAll();
        $retVal = [];
        foreach ($rows as $row)
        {
            $retVal[] = $row['user_id'];
        }
        return $retVal;
    }

    public function addTeam(Team $team)
    {
        try
        {
            return $this->adapter->insert('cmp_teams', array('team_name' => $team->getTeamName(),
                                                    'leader_id' => $team->getTeamLeaderID()));
        }
        catch (RuntimeException $re)
        {
            return ($this->adapter->getAffectedRows() > 0) ? true : false;
        }
    }

    public function getTeam($team_id)
    {
        $sql = sprintf('SELECT * FROM cmp_teams t WHERE t.team_id = %s', (int) $team_id);
        $this->adapter->prepare($sql)->execute();
        $row = $this->adapter->fetch();
        $leader = $this->getLeader($row['team_id']);
        $competitors = $this->getCompetitors($row['team_id']);
        return new Team($row['team_id'], $row['team_name'], $leader, $competitors);
    }

    public function getTeams()
    {
        $sql = sprintf('SELECT * FROM cmp_teams;');
        $this->adapter->prepare($sql)->execute();
        $rows = $this->adapter->fetchAll();
        $retVal = array();
        foreach ($rows as $row)
        {
            $leader = $this->getLeader($row['team_id']);
            $competitors = $this->getCompetitors($row['team_id']);
            $retVal[] = new Team($row['team_id'], $row['team_name'], $leader, $competitors);
        }
        return $retVal;
    }

    public function getTeamCompos($team_id)
    {
        $sql = sprintf('SELECT * FROM cmp_compos c, cmp_entries e WHERE c.compo_id = e.compo_id AND e.team_id = %s', (int) $team_id);
        $this->adapter->prepare($sql)->execute();
        $rows = $this->adapter->fetchAll();
        $retVal = array();
        foreach ($rows as $row)
        {
            $retVal[] = $this->createEntity($row);
        }
        return $retVal;
    }

    public function deleteTeam($team_id)
    {
        $sql = sprintf('DELETE FROM cmp_teams WHERE team_id = %s LIMIT 1;', (int) $team_id);
        try
        {
            return ($this->adapter->prepare($sql)->execute()->getAffectedRows() > 0) ? true : false;
        }
        catch (RuntimeException $re)
        {
            return ($this->adapter->getAffectedRows() > 0) ? true : false;
        }
    }

    public function addEntry($compo_id, $team_id)
    {
        $sql = sprintf('INSERT INTO cmp_entries VALUES (%s, %s)', (int) $compo_id, (int) $team_id);
        try
        {
            return ($this->adapter->prepare($sql)->execute()->getAffectedRows() > 0) ? true : false;
        }
        catch (RuntimeException $re)
        {
            return ($this->adapter->getAffectedRows() > 0) ? true : false;
        }
    }

    public function deleteEntry($compo_id, $team_id)
    {
        $sql = sprintf('DELETE FROM cmp_entries WHERE compo_id = %s AND team_id = %s LIMIT 1;', (int) $compo_id, (int) $team_id);
        return ($this->adapter->prepare($sql)->execute()->getAffectedRows() > 0) ? true : false;
    }

    public function deleteEntries($compo_id)
    {
        $sql = sprintf('DELETE FROM cmp_entries WHERE compo_id = %s;', (int) $compo_id);
        try
        {
            return ($this->adapter->prepare($sql)->execute()->getAffectedRows() > 0) ? true : false;
        }
        catch (RuntimeException $re)
        {
            return ($this->adapter->getAffectedRows() > 0) ? true : false;
        }
    }

    public function getEntries($compo_id)
    {
        $sql = sprintf('SELECT t.* FROM cmp_teams t LEFT JOIN cmp_entries e ON (t.team_id = e.team_id) WHERE e.compo_id = %s;', (int) $compo_id);
        $this->adapter->prepare($sql)->execute();
        $retVal = array();
        $rows = $this->adapter->fetchAll();
        foreach ($rows as $row)
        {
            $leader = $this->getLeader($row['team_id']);
            $competitors = $this->getCompetitors($row['team_id']);
            $retVal[] = new Team($row['team_id'], $row['team_name'], $leader, $competitors);
        }
        return $retVal;
    }

    public function getManager($user_id)
    {
        $sql = sprintf('SELECT user_id, CONCAT(firstname, " ", lastname) AS name FROM usr_users WHERE user_id = %s', (int) $user_id);
        $this->adapter->prepare($sql)->execute();
        $row = $this->adapter->fetch();
        return new Manager($row['user_id'], $row['name']);
    }

    public function getCompetitors($team_id)
    {
        $sql = sprintf('SELECT u.user_id, CONCAT(firstname, " ", lastname) AS name FROM usr_users u, cmp_competitors c WHERE u.user_id = c.user_id AND c.team_id = %s', (int) $team_id);
        $this->adapter->prepare($sql)->execute();
        $rows = $this->adapter->fetchAll();
        $retVal = array();
        foreach ($rows as $row)
        {
            $retVal[] = new Competitor($row['user_id'], $row['name']);
        }
        return $retVal;
    }

    public function getLeader($team_id)
    {
        $sql = sprintf('SELECT t.leader_id, CONCAT(firstname, " ", lastname) AS name FROM usr_users u, cmp_teams t WHERE u.user_id = t.leader_id  AND t.team_id = %s', (int) $team_id);
        $this->adapter->prepare($sql)->execute();
        $row = $this->adapter->fetch();
        return new Leader($row['leader_id'], $row['name']);
    }

    protected function createEntity(array $row)
    {
        $entries = $this->getEntries($row['compo_id']);
        $manager = $this->getManager($row['compo_manager']);
        return new Compo($row['compo_id'], $row['compo_name'], $row['num_competitors'], $row['signup_start'], $row['signup_due'], $row['event_start'], $manager, $entries);
    }

}

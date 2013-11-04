<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 28.06.12
 * Time: 01:39
 * To change this template use File | Settings | File Templates.
 */
class Team
{
    private $team_id;
    private $team_name;
    private $leader;
    private $competitors;
    private $compo_id;

    public function __construct($team_id, $team_name, Leader $leader, array $competitors = array())
    {
        $this->team_id      = $team_id;
        $this->team_name    = $team_name;
        $this->leader       = $leader;
        $this->competitors  = $competitors;
    }

    public function getTeamID()
    {
        return $this->team_id;
    }

    public function getTeamName()
    {
        return $this->team_name;
    }

    public function getNumCompetitors()
    {
        return count($this->competitors);
    }

    public function getTeamLeader()
    {
        return $this->leader;
    }

    public function getCompoID()
    {
        return $this->compo_id;
    }

    public function setCompoID($compo_id)
    {
        $this->compo_id = (int) $compo_id;
    }

    public function setTeamID($team_id)
    {
        $this->team_id = $team_id;
    }

    public function getCompetitors()
    {
        return $this->competitors;
    }

    /**
     * Mutator methdos
     */

    public function addCompetitor(Competitor $comp)
    {
        $this->competitors[] = $comp;
        return $this->competitors;
    }

    public function addCompetitors(array $comps)
    {
        $c = count($comps);
        for ($i = 1; $i < $c; $i++)
        {
            // Check if this array index contains a team
            if (!$comps[$i] instanceof Competitor)
            {
                return false;
            }
        }
        return $this->competitors = array_merge($this->competitors, $comps);
    }

    public function setCompetitors(array $comps)
    {
        $this->competitors = $comps;
    }

    public function hasCompetitor(Competitor $competitor)
    {
        foreach ($this->competitors as $comp)
        {
            if ($comp->getCompetitorId() == $competitor->getCompetitorId())
            {
                return true;
            }
        }
        return false;
    }


}

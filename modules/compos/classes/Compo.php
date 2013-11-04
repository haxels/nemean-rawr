<?php

class Compo
{
    private $compo_id;
    private $compo_name;                // Compo name
    private $signup_start;              // Competitor enrollment start date
    private $signup_due;                // Competitor enrollment end date
    private $entries = array();         // Contains an array of teams that are competitors in this compo
    private $compo_manager;             // Person who is responsible for this compo
    private $num_competitors;           // Number of competitors the team must have to be qualified for this compo. Leader is included here.
    private $eventStart;

    public function __construct($compo_id, $compo_name, $num_competitors, $sStart, $sDue, $eStart, $manager, array $entries = array())
    {
        $this->compo_id         = $compo_id;
        $this->compo_name       = $compo_name;
        $this->num_competitors  = $num_competitors;
        $this->signup_start     = $sStart;
        $this->signup_due       = $sDue;
        $this->eventStart       = $eStart;
        $this->compo_manager    = $manager;
        $this->entries          = $entries;
    }


    public function getCompoID()
    {
        return $this->compo_id;
    }

    public function getCompoName()
    {
        return $this->compo_name;
    }

    public function getSignupStart()
    {
        return $this->signup_start;
    }

    public function getSignupDue()
    {
        return $this->signup_due;
    }

    public function getEntries()
    {
        return $this->entries;
    }

    public function getNumEntries()
    {
        return count($this->entries);
    }

    public function getEventStart()
    {
        return $this->eventStart;
    }

    public function getNumCompetitors()
    {
        return $this->num_competitors;
    }

    public function getCompoManager()
    {
        return $this->compo_manager;
    }

    /**
     * Adds one team to the entries array and returns the entries array
     *
     * @param Team
     * @return array
     */
    public function addEntry(Team $team)
    {
        $this->entries[] = $team;
        return $this->entries;
    }

    /** Adds an array of teams to the entries array and returns the entries array.
     *
     * @param array
     * @return array
     */
    public function addEntries(array $teams)
    {
        $c = count($teams);
        for ($i = 1; $i < $c; $i++)
        {
            // Check if this array index contains a team
            if (!$teams[$i] instanceof Team)
            {
                return false;
            }
        }
        // Array contains valid teams, so merge it with our entries array.
        return $this->entries = array_merge($this->entries, $teams);
    }

    public function setEntries(array $teams)
    {
        $this->entries = $teams;
    }

    public function getTimeLeft()
    {
        $now    = time();
        $start  = strtotime($this->signup_start);
        $due    = strtotime($this->signup_due);

        if ( ($start < $now) && ($now < $due) )
        {
            // Signups are open!
            $h = floor(($due - $now)/(60*60));
            $h = ($h > 0) ? $h. 'h ' : '';
            $rm = ($due - $now) % (60*60);
            $m = floor($rm/(60));

            $time = $h . $m;

            echo "Signups ending in: ". $time . ' minutes';
        }
        elseif ($now < $start)
        {
            // Signups are not open
            $h = floor(($start - $now)/(60*60));
            $h = ($h > 0) ? $h. 'h ' : '';
            $rm = ($due - $now) % (60*60);
            $m = floor($rm/(60));

            $time = $h . $m;

            echo "Singups starting in: ". $time . ' minutes';
        }
        elseif ($now > $due)
        {
            echo "Singups are over!";
        }
    }


    public function getTimeToEventStart()
    {
        $now    = time();
        $start  = strtotime($this->eventStart);

        if ( ($start < $now))
        {
            // Ongoing event!
            echo 'Ongoing event';
        }
        elseif ($now < $start)
        {
            // Event has yet to start
            $h = floor(($start - $now)/(60*60));
            $h = ($h > 0) ? $h. 'h ' : '';
            $rm = ($start - $now) % (60*60);
            $m = floor($rm/(60));

            $time = $h . $m;

            echo "Event starting in: ". $time . ' minutes';
        }
    }

    public function isSignupOpen()
    {
        $now = time();
        $start = strtotime($this->signup_start);
        $due = strtotime($this->signup_due);
        return ( ($start < $now) && ($due > $now)) ? true : false;
    }

    public function isCompetingTeam(Team $team)
    {
        foreach ($this->entries as $entry)
        {
            if ($entry->getTeamID() == $team->getTeamID())
            {
                return true;
            }
        }
        return false;
    }

    public function isCompetingCompetitor(Competitor $competitor)
    {
        foreach ($this->entries as $entry)
        {
            if ($entry->getTeamLeader()->getLeaderId() == $competitor->getCompetitorId())
            {
                return true;
            }

            foreach ($entry->getCompetitors() as $comp)
            {
                if ($comp->getCompetitorId() == $competitor->getCompetitorId())
                {
                    return true;
                }
            }
        }
        return false;
    }


}

?>
<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 12.06.12
 * Time: 23:24
 * To change this template use File | Settings | File Templates.
 */
class Map
{
    private $seats;
    private $width;
    private $aisle;
    private $inverse;
    private $reservations;
    private $locked;

    private $user;

    const REGULAR = 0;
    const LOCKED = 1;
    const AVAILABLE = 2;
    const RESERVED = 3;
    const CURRENT_USER = 4;
    const ILLEGAL = 9;

    function __construct($seats, $width = 8, $aisle = false, $inverse = true, $locked = false, array $reservations = array(), User $user)
    {
        $this->seats = $seats->getValue();
        $this->width = $width->getValue();
        $this->aisle = $aisle->getValue();
        $this->inverse = $inverse->getValue();
        $this->locked = $locked->getValue();
        $this->reservations = $reservations;
        $this->user = $user;
    }

    public function printMap(ReservationsController $rc)
    {
        $data['locked']   = ($this->locked) ? 'Locked' : 'Open';
        $data['section1'] = $this->printSection(1, 88);
        $data['section2'] = $this->printVerticalSection(89, 120, true);
        $rc->loadView('map', $data);
    }

    public function printSection($start, $end)
    {
        for ($i = $start; $i <= $end; $i++)
        {
            $this->getSeat($i);

            if ( $i % $this->width == 0)
            {
                if ( ( $i / $this->width) % 2 == 0)
                {
                    if ($i == $this->seats)
                    {
                        echo ($this->inverse) ? '<br />' : '</div>';
                    }
                    else
                    {
                        echo ($this->inverse) ? '<br />' : '</div><div class="evenDivider">';
                    }
                }
                else
                {
                    if ($i == $end)
                    {
                        echo ($this->inverse) ? '</div>' : '<br />';
                    }
                    else
                    {
                        echo ($this->inverse) ? '</div><div class="evenDivider">' : '<br />';
                    }
                }
            }
            elseif ($i % ($this->width / 2) == 0 && $this->aisle)
            {
                echo '&nbsp;&nbsp;&nbsp;&nbsp;';
            }
        }
    }

    public function printVerticalSection($start, $end, $inverse)
    {
        for ($i = $start; $i <= $end; $i++)
        {
            $this->getSeat($i);

            if ( $i % $this->width == 0)
            {
                if ( ( $i / $this->width) % 2 == 0)
                {
                    if ($i == $this->seats)
                    {
                        echo ($inverse) ? '<br />' : '</div>';
                    }
                    else
                    {
                        echo ($inverse) ? '<br />' : '</div><div class="mEven2">';
                    }
                }
                else
                {
                    if ($i == $end)
                    {
                        echo ($inverse) ? '</div>' : '<br />';
                    }
                    else
                    {
                        echo ($inverse) ? '</div><div class="mEven2">' : '<br />';
                    }
                }
            }
            elseif ($i % ($this->width / 2) == 0 && $this->aisle)
            {
                echo '&nbsp;&nbsp;&nbsp;&nbsp;';
            }
        }
    }


    /**
     * Generate and display reservation map
     */
    public function printMap2($divname="evenDivider")
    {
        echo ($this->locked) ? 'Locked' : 'Open';
        echo '<div class="'.$divname.'">';

        for ($i = 1; $i <= $this->seats; $i++)
        {
            $this->getSeat($i);

            if($i < 88)
            {
                if ( $i % $this->width == 0)
                {
                    if ( ($i / $this->width) % 2 == 0)
                    {
                        if ($i == $this->seats)
                        {
                            echo ($this->inverse) ? '<br />' : '</div>';
                        }
                        else
                        {
                            echo ($this->inverse) ? '<br />' : '</div><div class="'.$divname.'">';
                        }
                    }
                    else
                    {
                        if ($i == $this->seats)
                        {
                            echo ($this->inverse) ? '</div>' : '<br />';
                        }
                        else
                        {
                            echo ($this->inverse) ? '</div><div class="'.$divname.'">' : '<br />';
                        }
                    }
                }
                elseif ($i % ($this->width / 2) == 0 && $this->aisle)
                {
                    echo '&nbsp;&nbsp;&nbsp;&nbsp;';
                }
            }
            else
            {
                if ( $i % $this->width == 0)
                {
                    if ( ($i / $this->width) % 2 == 0)
                    {
                        if ($i == $this->seats)
                        {
                            echo ($this->inverse) ? '<br />' : '</div>';
                        }
                        else
                        {
                            echo ($this->inverse) ? '<br />' : '</div><div class="minisal" >';
                        }
                    }
                    else
                    {
                        if ($i == $this->seats)
                        {
                            echo ($this->inverse) ? '</div>' : '<br />';
                        }
                        else
                        {
                            echo ($this->inverse) ? '</div><div class="minisal">' : '<br />';
                        }
                    }
                }
                elseif ($i % ($this->width / 2) == 0 && $this->aisle)
                {
                    echo '&nbsp;&nbsp;&nbsp;&nbsp;';
                }
            }

        }
    }

    /**
     * Helper method for printMap
     * @param $seat_id
     */
    private function getSeat($seat_id)
    {
        $link = '';
        if ($this->isLocked())
        {
            // Deactivate links
            $link = '#';
        }
        else
        {
            //$link = '?m=reservations&act=viewSeat&sID='.$seat_id;
            $link = '#';
        }

        switch ($this->checkSeat($seat_id))
        {
            case Map::AVAILABLE:
                $this->printAvailable($seat_id);
                break;

            case Map::RESERVED:
                echo '<a class="mapReserved" href="'.$link.'" alt="">&nbsp;&nbsp;<span class="info"><h2>Plass '.$seat_id.'</h2><p>'.$this->reservations[$seat_id]['user']->getName().'</p></span></a>';
                break;

            case Map::CURRENT_USER:
                include "removeRsvForm.php";
                break;

            case Map::LOCKED:
                echo '<a class="mapLocked" href="'.$link.'" alt="">&nbsp;&nbsp;<span class="info"><h2>Plass '.$seat_id.'</h2><p>Locked</p></span></a>';
                break;

        }
    }

    /**
     * Check what seat we are dealing with
     *
     * @param $seat_id
     * @return int
     */
    public function checkSeat($seat_id)
    {
        if (!$this->isLegalSeat($seat_id))
        {
            return Map::ILLEGAL;
        }

        if ($this->isReserved($seat_id))
        {
            if ($this->getSeatType($seat_id) != 0)
            {
                return Map::LOCKED;
            }

            if ($this->isUsersSeat($seat_id))
            {
                return Map::CURRENT_USER;
            }
            else
            {
                return Map::RESERVED;
            }
        }
        else
        {
            return Map::AVAILABLE;
        }
    }

    /**
     * Check if seat has any kind of reservations
     *
     * @param $seat_id
     * @return bool
     */
    private function isReserved($seat_id)
    {
        return (array_key_exists($seat_id, $this->reservations)) ? true : false;
    }

    /**
     * Check if seat is reserved to the logged in user
     *
     * @param $seat_id
     * @return bool
     */
    private function isUsersSeat($seat_id)
    {
	// var_dump($this->reservations[1]); return;
        return ($this->reservations[$seat_id]['user']->getUserId() == $this->user->getUserId()) ? true : false;
    }

    private function isSeated()
    {
        foreach ($this->reservations as $reservation)
        {
            if ($reservation['user'] instanceof User)
            {
                if ($this->user->getUserId() == $reservation['user']->getUserId())
                {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Check if seat is within the limits of the map boundaries <br />
     * 0 < Sn <= Smax
     *
     * @param $seat_id
     * @return bool
     */
    private function isLegalSeat($seat_id)
    {
        return ($seat_id > 0 && $seat_id <= $this->seats) ? true : false;
    }

    /**
     * Check user permissions and decide if map should be locked
     *
     * @return bool
     */
    public function isLocked()
    {
        return ($this->user->isInRole(array('Guest')) || $this->locked) && (!$this->user->isInRole(array('Developer', 'Moderator')));
    }

    /**
     * Get what type of seat
     * @param $seat_id
     * @return int
     */
    private function getSeatType($seat_id)
    {
        return ($this->reservations[$seat_id]['reservation']->getType());
    }

    /**
     * Get reservation for seat if there are any
     *
     * @param $seat_id
     * @return mixed
     */
    public function getReservation($seat_id)
    {
        return ($this->reservations[$seat_id]);
    }

    private function printAvailable($seat_id)
    {
        if ($this->user->isInRole(array('Developer', 'Moderator', 'Crew')))
        {
            echo '<a class="mapAvailable btn-popup" href="#regReservation" id="'.$seat_id.'">&nbsp;&nbsp;<span class="info"><h2>Plass '.$seat_id.'</h2><p>Admin</p></span></a>';
            //echo '<a class="mapAvailable" href="?m=reservations&act=viewSeat&sID='.$seat_id.'">&nbsp;&nbsp;<span class="info"><h2>Plass '.$seat_id.'</h2><p>Admin</p></span></a>';
        }
        else if ($this->user->isInRole(array('User')) && $this->isLocked())
        {
            echo '<a class="mapAvailable" href="#">&nbsp;&nbsp;<span class="info"><h2>Plass '.$seat_id.'</h2><p>Plasskartet er stengt</p></span></a>';
        }
        else if ($this->user->isInRole(array('User')) && !$this->isLocked())
        {
            if (!$this->isSeated())
            {
                include "reserveForm.php";
            }
            else
            {
                echo '<a id="a'.$seat_id.'" class="mapAvailable" href="">&nbsp;&nbsp;<span class="info"><h2>Plass '.$seat_id.'</h2></span></a>';
            }
            //echo '<a id="a'.$seat_id.'" class="mapAvailable" href="?m=reservations&act=viewSeat&sID='.$seat_id.'">&nbsp;&nbsp;<span class="info"><h2>Plass '.$seat_id.'</h2><p><button id="'.$seat_id.'" class="cRegBtn">Reserver</button></p></span></a>';
        }
        else if ($this->isLocked())
        {
            echo '<a class="mapAvailable" href="#">&nbsp;&nbsp;<span class="info"><h2>Plass '.$seat_id.'</h2><p>Gjest</p></span></a>';
        }
    }

    private function printSeat($seat_id, $class, $text)
    {
        if ($this->user->isInRole(array('Developer', 'Moderator')))
        {
            echo '<a class="'.$class.'" href="?m=reservations&act=viewSeat&sID='.$seat_id.'">&nbsp;&nbsp;<span class="info"><h2>Plass '.$seat_id.'</h2><p>Admin</p></span></a>';
        }
        else if ($this->user->isInRole(array('User')) && $this->isLocked())
        {
            echo '<a class="'.$class.'" href="#">&nbsp;&nbsp;<span class="info"><h2>Plass '.$seat_id.'</h2><p>Plasskartet er stengt</p></span></a>';
        }
        else if ($this->user->isInRole(array('User')) && !$this->isLocked())
        {
            echo '<a class="'.$class.'" href="#">&nbsp;&nbsp;<span class="info"><h2>Plass '.$seat_id.'</h2><p>User</p></span></a>';
            //echo '<a class="'.$class.'" href="?m=reservations&act=viewSeat&sID='.$seat_id.'">&nbsp;&nbsp;<span class="info"><h2>Plass '.$seat_id.'</h2><p>User</p></span></a>';
        }
        else if ($this->user->isInRole(array('Guest')))
        {
            echo '<a class="'.$class.'" href="#">&nbsp;&nbsp;<span class="info"><h2>Plass '.$seat_id.'</h2><p>Gjest</p></span></a>';
        }
    }

    public function getSeats()
    {
        return $this->seats;
    }

    public function getFreeSeats()
    {
        return $this->seats - count($this->reservations);
    }

    public function getNumReservations()
    {
        return count($this->reservations);
    }
}

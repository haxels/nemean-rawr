<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 14.06.12
 * Time: 22:29
 * To change this template use File | Settings | File Templates.
 */
require_once MODULEPATH . 'users/classes/UserMapper.php';
require_once MODULEPATH . 'users/classes/AuthyMapper.php';
require_once MODULEPATH . 'users/classes/ParentsMapper.php';
require_once MODULEPATH . 'users/classes/RoleMapper.php';
require_once MODULEPATH . 'reservations/classes/ReservationsMapper.php';
require_once MODULEPATH . 'reservations/classes/Map.php';
require_once SYSPATH . 'NController.php';

class ReservationsController extends NController implements ILeftContent
{
    protected $moduleName = 'reservations';
    private $userMapper;
    private $reservationsMapper;
    private $settings;

    public function __construct(Session $s, array $settings, ReservationsMapper $rm, UserMapper $um)
    {
        $this->session              = $s;
        $this->userMapper           = $um;
        $this->reservationsMapper   = $rm;
        $this->settings             = $settings;
    }

    public function leftContent()
    {
        $reservations = $this->reservationsMapper->findAll();

        $r = array();
        foreach ($reservations as $reservation)
        {
            $r[$reservation->getSeatId()]['reservation'] = $reservation;
            $r[$reservation->getSeatId()]['user'] = $this->userMapper->findById($reservation->getUserId());
        }

        $data['map'] = new Map($this->settings['seats'], $this->settings['width'], $this->settings['aisle'], $this->settings['inverse'], $this->settings['locked'], $r, $this->session->getUser());
        //$this->loadView('leftContent', $data);
    }

    public function display()
    {
        $act = (isset($_GET['act'])) ? $_GET['act'] : '';

        switch ($act)
        {
            case 'viewSeat':
                $this->viewSeat();
                break;

            default:
                $this->viewMap();
                break;
        }
    }

    public function quickActions()
    {
        $act = (isset($_GET['dAct'])) ? $_GET['dAct'] : '';

        switch ($act)
        {
            case 'dReserveSeat':
                $this->reserveSeat();
                break;
        }
    }

    public function ajaxActions()
    {
        $act = (isset($_GET['aAct'])) ? $_GET['aAct'] : '';

        switch ($act)
        {
            case 'JSONreserveSeat':
                $this->JSONreserveSeat();
                break;

            case 'JSONremoveReservation':
                $this->JSONremoveReservation();
                break;
        }
    }

    private function viewMap()
    {
        $reservations = $this->reservationsMapper->findAll();

        $r = array();
        foreach ($reservations as $reservation)
        {
            $r[$reservation->getSeatId()]['reservation'] = $reservation;
            $r[$reservation->getSeatId()]['user'] = $this->userMapper->findById($reservation->getUserId());
        }

        $data['map'] = new Map($this->settings['seats'], $this->settings['width'], $this->settings['aisle'], $this->settings['inverse'], $this->settings['locked'], $r, $this->session->getUser());
        //$data['map']->printMap($this);
        $this->loadView('viewMap', $data);

    }

    public function viewSeat()
    {
        if ($this->session->getUser()->isInRole(array('Guest')))
        {
            echo 'You\' not authorized.';
            return;
        }

        $seat_id = (isset($_GET['sID'])) ? $_GET['sID'] : 0;
        $reservation = $this->reservationsMapper->findById($seat_id);
        $r = array();
        if ($reservation instanceof Reservation)
        {
            $r[$reservation->getSeatId()]['reservation'] = $reservation;
            $r[$reservation->getSeatId()]['user'] = $this->userMapper->findById($reservation->getUserId());
        }
        $map = new Map($this->settings['seats'], $this->settings['width'], $this->settings['aisle'], $this->settings['inverse'], $this->settings['locked'], $r, $this->session->getUser());

        $data['seat_id'] = $seat_id;

        if ($map->isLocked())
        {
            $this->loadView('illegal', $data);
            return;
        }

        switch ($map->checkSeat($data['seat_id']))
        {
            case Map::AVAILABLE:
                $this->loadView('available', $data);
                break;

            case Map::RESERVED:
                $data['reservation'] = $reservation;
                $data['user'] = $r[$seat_id]['user'];
                $this->loadView('reserved', $data);
                break;

            case Map::CURRENT_USER:
                $data['reservation'] = $reservation;
                $data['user'] = $r[$seat_id]['user'];
                $this->loadView('currentUser', $data);
                break;

            case Map::LOCKED:
                $this->loadView('locked', $data);
                break;

            case Map::ILLEGAL:
                $this->loadView('illegal', $data);
                break;
        }
    }

    public function reserveSeat()
    {
        if ($this->session->getUser()->isInRole(array('Guest')))
        {
            echo 'You\' not authorized.';
            return;
        }

        $seat_id = (isset($_GET['sID'])) ? $_GET['sID'] : 0;
        $reservation = $this->reservationsMapper->findById($seat_id);
        echo $this->reservationsMapper->isSeated($this->session->getID());
        if ($reservation instanceof Reservation || $this->reservationsMapper->isSeated($this->session->getID()))
        {
            echo 'Illegal action!';
            return;
        }

        $this->reservationsMapper->insert(new Reservation($seat_id, $this->session->getID(), time(), 0));
        header('Location: ?m=reservations');
    }

    public function JSONreserveSeat()
    {
        $username   = $this->session->getUsername();
        $psw        = (isset($_POST['psw'])) ? $_POST['psw'] : '';
        $seatID     = (isset($_POST['seatID'])) ? $_POST['seatID'] : '';
        $userID     = $this->session->getID();

        if (!$this->session->isAuthorized(array('User')))
        {
            $arr = array("success" => false, 'error' => 'Ugyldig operasjon');
            echo json_encode($arr);
            return;
        }

        $reservation = $this->reservationsMapper->findById($seatID);
        if ($reservation instanceof Reservation || $this->reservationsMapper->isSeated($userID))
        {
            $arr = array("success" => false, 'error' => 'Du er allerede plassert.');
            echo json_encode($arr);
            return;
        }

        if ($this->session->checkPassword($username, $psw))
        {
            $this->reservationsMapper->insert(new Reservation($seatID, $userID, time(), 0, ''));
            $arr = array("success" => true);
            echo json_encode($arr);
            return;
        }
        else
        {
            $arr = array("success" => false, 'error' => 'Feil med autentisering.');
            echo json_encode($arr);
            return;
        }
    }

    public function JSONremoveReservation()
    {
        $username   = $this->session->getUsername();
        $psw        = (isset($_POST['psw'])) ? $_POST['psw'] : '';
        $seatID     = (isset($_POST['seatID'])) ? $_POST['seatID'] : '';
        $userID     = $this->session->getID();

        if (!$this->session->isAuthorized(array('User')))
        {
            $arr = array("success" => false, 'error' => 'Ugyldig operasjon');
            echo json_encode($arr);
            return;
        }

        $reservation = $this->reservationsMapper->findById($seatID);

        if ($reservation instanceof Reservation || $this->reservationsMapper->isSeated($userID))
        {
            if ($this->session->checkPassword($username, $psw))
            {
                $this->reservationsMapper->deletePK($seatID);
                $arr = array("success" => true);
                echo json_encode($arr);
                return;
            }
            else
            {
                $arr = array("success" => false, 'error' => 'Feil med autentisering');
                echo json_encode($arr);
                return;
            }
        }
        else
        {
            $arr = array("success" => false, 'error' => 'Ugyldig operasjon');
            echo json_encode($arr);
            return;
        }
    }

}

<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 12.06.12
 * Time: 21:01
 * To change this template use File | Settings | File Templates.
 */


class AdminController extends NController
{
    protected $moduleName = 'reservations';

    private $userMapper;
    private $reservationsMapper;
    private $settings;

    public function __construct(Session $s, array $settings, UserMapper $um, ReservationsMapper $rm)
    {
        $this->session              = $s;
        $this->userMapper           = $um;
        $this->reservationsMapper   = $rm;
        $this->settings             = $settings;
    }

    public function display()
    {
        if (!$this->session->isAuthorized(array('Developer', 'Moderator', 'Crew')))
        {
            echo 'You\'re not authorized to do this.';
            return;
        }

        $act = (isset($_GET['act'])) ? $_GET['act'] : '';

        switch ($act)
        {
            case 'view':
                $this->viewMap();
                break;

            case 'viewSeat':
                $this->viewSeat();
                break;

            case 'delete':
                $this->deleteReservation();
                break;

            case 'lockSeat':
                $this->lockSeat();
                break;

            case 'reserveSeat':
                $this->reserveSeat();
                break;

            case 'settings':
                $this->viewSettings();
                break;

            default:
                $this->listReservations();
                break;
        }
        $this->loadView('admin/popups');
        $this->viewMap();
    }

    public function quickActions()
    {
        $act = (isset($_GET['qAct'])) ? $_GET['qAct'] : '';
        switch($act)
        {
            case 'emptyReservations':
                $this->emptyReservations();
                break;
        }

    }

    public function ajaxActions()
    {
        $act = (isset($_GET['aAct'])) ? $_GET['aAct'] : '';
        switch($act)
        {
            case 'print':
                $this->printReservations();
                break;

            case 'JSONpay':
                $this->JSONpay();
                break;

            case 'JSONregisterGuest':
                $this->JSONregisterGuest();
                break;

            case 'JSONremoveReservation':
                $this->JSONremoveReservation();
                break;

            case 'JSONaddReservation':
                $this->JSONaddReservation();
                break;

            case 'JSONactivateReservation':
                $this->JSONactivateReservation();
                break;

            case 'JSONgetSettings':
                $this->JSONviewSettings();
                break;
        }

    }


    public function listReservations()
    {
        $paid = (isset($_GET['paid'])) ? $_GET['paid'] : 0;
        $data['reservations'] = array();
        $data['reservations'] = $this->reservationsMapper->findAll();
        $data['guests'] = $this->reservationsMapper->getNumGuests();

        $data['users'] = array();
        foreach ($data['reservations'] as $reservation)
        {
            $data['users'][$reservation->getSeatId()] = $this->userMapper->findById($reservation->getUserId());

        }
        $data['users'] = $this->sortPaid($data['users'], $paid);

        $list = [];
        foreach ($data['reservations'] as $reservation)
        {
            if ($reservation->getType() == 0)
            {
                $user = (isset($data['users'][$reservation->getSeatID()])) ? $data['users'][$reservation->getSeatID()] : null;
                if ($user instanceof User && $paid && $user->isInRole(['Paid']))
                {
                    // Liste med betalte
                    $list[] = $reservation;
                }
                elseif ($user instanceof User && !$paid && !$user->isInRole(['Paid']))
                {
                    // Liste med ikke betalte
                    $list[] = $reservation;
                }
            }
            else
            {
                if (!$paid)
                {
                    $list[] = $reservation;
                }
            }
        }
        $data['reservations'] = $list;
        $this->loadView('admin/list', $data);
    }

    private function sortPaid($list, $paid)
    {
        $retVal = [];
        foreach ($list as $key => $user)
        {
            if ($user instanceof User)
            {
                if ($paid && $user->isInRole(['Paid']))
                {
                    // Liste med betalte brukere
                    $retVal[$key] = $user;
                }
                elseif (!$paid && !$user->isInRole(['Paid']))
                {
                    // Liste med ikke betalte brukere
                    $retVal[$key] = $user;
                }
            }
            else
            {
                if (!$paid)
                {
                    $retVal[$key] = $user;
                }
            }
        }
        return $retVal;
    }

    public function deleteReservation()
    {
        $seat_id = (isset($_GET['sID'])) ? $_GET['sID'] : 0;

        if ($seat_id > 0)
        {
            $this->reservationsMapper->deletePK($seat_id);

        }
    }

    public function lockSeat()
    {
        $seat_id = (isset($_GET['sID'])) ? $_GET['sID'] : 0;
        $this->reservationsMapper->reserveLockedSeat($seat_id);
        echo 'Reservation was made';
    }

    public function reserveSeat()
    {
        $seat_id = (isset($_GET['sID'])) ? $_GET['sID'] : 0;
        $data['seat_id'] = $seat_id;
        if (isset($_GET['uID']))
        {
            $user = $this->userMapper->findById($_GET['uID']);
            if ($this->reservationsMapper->isSeated($user->getUserId()))
            {
                echo 'User is already seated!';
                return;
            }

            $r = new Reservation($seat_id, $user->getUserId(), time(), 0, '');
            $this->reservationsMapper->insert($r);
            echo 'Reservation was made';
        }
        else
        {
            $data['users'] = $this->userMapper->getUsersByLevel(3);
            $this->loadView('admin/listUsers', $data);
        }
    }

    public function viewSeat()
    {
        $seat_id = (isset($_GET['sID'])) ? $_GET['sID'] : 0;
        $reservation = $this->reservationsMapper->findById($seat_id);
        $r = array();
        if ($reservation instanceof Reservation)
        {
            $r[$reservation->getSeatId()]['reservation'] = $reservation;
            $r[$reservation->getSeatId()]['user'] = $this->userMapper->findById($reservation->getUserId());
        }
        $map = new Map($this->settings['seats'], $this->settings['width'], $this->settings['aisle'], $this->settings['inverse'], $this->settings['locked'], $r, $this->userMapper->findById($this->session->getID()));
        $data['seat_id'] = $seat_id;

        switch ($map->checkSeat($data['seat_id']))
        {
            case Map::AVAILABLE:
                $this->loadView('admin/available', $data);
                break;

            case Map::RESERVED:
                $data['reservation'] = $reservation;
                $data['user'] = $r[$seat_id]['user'];
                $this->loadView('admin/reserved', $data);
                break;

            case Map::CURRENT_USER:
                $data['reservation'] = $reservation;
                $data['user'] = $r[$seat_id]['user'];
                $this->loadView('admin/currentUser', $data);
                break;

            case Map::LOCKED:
                $this->loadView('admin/locked', $data);
                break;

            case Map::ILLEGAL:
                $this->loadView('admin/illegal', $data);
                break;
        }
    }

    public function viewMap()
    {
        $r = $this->getReservations();
        $data['map'] = new Map($this->settings['seats'], $this->settings['width'], $this->settings['aisle'], $this->settings['inverse'], $this->settings['locked'], $r, $this->userMapper->findById($this->session->getID()));
        $this->loadView('admin/viewMap', $data);
    }

    public function viewSettings()
    {
        $data = $this->settings;
        $this->loadView('admin/settings', $data);
    }

    public function printReservations()
    {
       //include("../mpdf/mpdf.php");
        $data['reservations'] = $this->getReservations();
        $mpdf=new mPDF('UTF-8', 'A4');

        ob_start();
        $this->loadView('admin/pdfprint', $data);
        $html = ob_get_contents();

        ob_end_clean();
        $mpdf->WriteHTML($html);
        $mpdf->Output();
        exit();
    }

    private function getReservations()
    {
        $reservations = $this->reservationsMapper->findAll();

        $r = array();
        foreach ($reservations as $reservation)
        {
            $r[$reservation->getSeatId()]['reservation'] = $reservation;
            $r[$reservation->getSeatId()]['user'] = $this->userMapper->findById($reservation->getUserId());
        }
        return $r;
    }

    public function JSONpay()
    {
        $user_id = (isset($_POST['user_id'])) ? $_POST['user_id'] : 0;
        $type = (isset($_POST['type'])) ? $_POST['type'] : false;       // Type = 1 -> Reg payment; Type = 0 - > Unpay
        $user = $this->userMapper->findById($user_id);
        if ($user instanceof User)
        {
            if ($type)
            {
                $this->userMapper->getRoleMapper()->addRole($user_id, 6);
                $arr = ['success' => true, 'msg' => '<b>'.$user->getName().'</b> er nå registrert som betalt.'];
            }
            else
            {
                $this->userMapper->getRoleMapper()->removeRole($user_id, 6);
                $arr = ['success' => true, 'msg' => '<b>'.$user->getName().'</b> er nå registrert som <b>ikke</b> betalt.'];
            }
        }
        else
        {
            $arr = ['success' => false, 'msg' => 'Fant ikke bruker med brukerID: '.$user_id];
        }
        echo json_encode($arr);
        return;
    }

    public function JSONregisterGuest()
    {
        $name = (isset($_POST['name'])) ? $_POST['name'] : '';

        $validator = new Validator();
        $validator->addField('name', $name, [Validator::NAME, Validator::REQUIRED]);
        $validator->validate();

        if ($validator->hasErrors())
        {
            $errors = [];
            foreach ($validator->getErrors() as $key => $value)
            {
                $errors[] = ['field' => $key, 'msg' => $value];
            }
            $arr = ['success' => false, 'errors' => $errors];
            echo json_encode($arr);
            return;
        }

        $guest = new Guest(0, $name, '');
        $this->reservationsMapper->registerGuest($guest);
        $numGuests = $this->reservationsMapper->getNumGuests();
        $arr = ['success' => true, 'msg' => 'Gjest, <b>'.$name.'</b> registrert.', 'html' => $numGuests, 'type' => 'update', 'updateSelector' => '#guestAmount'];

        echo json_encode($arr);
        return;
    }

    public function JSONremoveReservation()
    {
        $seat_id = (isset($_POST['seat_id'])) ? $_POST['seat_id'] : 0;
        $seat = $this->reservationsMapper->findById($seat_id);
        if ($seat instanceof Reservation)
        {
            $this->reservationsMapper->deletePK($seat_id);
            $arr = ['success' => true, 'msg' => 'Reservasjonen for plass nummer <b>'.$seat_id.'</b> er blitt slettet'];
        }
        else
        {
            $arr = ['success' => false, 'msg' => 'Noe galt skjedde med sletting av plass nummer <b>'.$seat_id.'</b>'];
        }
        echo json_encode($arr);
    }

    public function JSONactivateReservation()
    {
        $user_id = (isset($_POST['user_id'])) ? $_POST['user_id'] : 0;
        // 1. Check if seat is a valid seat
        // 2. Check if seat is reserved
        $seats = $this->reservationsMapper->findAll(['user_id' => $user_id]);
        $seat = (count($seats) == 1) ? $seats[0] : null;
        if (!$seat instanceof Reservation)
        {
            $arr = ['success' => false, 'msg' => 'Noe galt skjedde'];
            echo json_encode($arr);
            return;
        }
        else
        {
            $seat->setType(0);
            $this->reservationsMapper->update($seat);
            $arr = ['success' => true, 'msg' => 'Plass nummer <b>'.$seat->getSeatId().'</b> er nå aktivert.'];
            echo json_encode($arr);
            return;
        }
        // 3. Update type to 0
    }

    public function JSONaddReservation()
    {
        $seat_id = (isset($_POST['seat_id'])) ? $_POST['seat_id'] : 0;
        $user_id = (isset($_POST['user_id'])) ? $_POST['user_id'] : 0;
        $validator = new Validator();
        $validator->addField('seat_id', [Validator::NUMBER], ['min_max_num' => [1, 224]]);
        $validator->validate();

        $seat = $this->reservationsMapper->findById($seat_id);
        if ($seat instanceof Reservation)
        {
            $validator->setError('seat_id', 'Plass nummer <b>'.$seat_id.'</b> er allerede reservert.');
        }

        $seat = $this->reservationsMapper->findAll(['user_id' => $user_id]);
        $seat = (is_array($seat)) ? $seat[0] : $seat;
        if ($seat instanceof Reservation)
        {
            $validator->setError('user_id', 'Bruker med brukerID <b>'.$user_id.'</b> er allerede plassert.');
        }

        if ($validator->hasErrors())
        {
            $errors = [];
            foreach ($validator->getErrors() as $key => $value)
            {
                $errors[] = ['field' => $key, 'msg' => $value];
            }
            $arr = ['success' => false, 'errors' => $errors];
            echo json_encode($arr);
            return;
        }

        // 2. Check if seat is taken by someone else

        $r = new Reservation($seat_id, $user_id, '', 0, '');
        $this->reservationsMapper->insert($r);
        $arr = ['success' => true, 'msg' => 'Plass nummer <b>'.$seat_id.'</b> er nå reservert til <b>'.$user_id.'.'];
        echo json_encode($arr);
        return;
    }

    public function emptyReservations()
    {
        if ($this->session->isAuthorized(['AwesomeDeveloper']))
        {
            $this->reservationsMapper->deleteGuests();
            $this->reservationsMapper->deleteReservations();
        }
        else
        {
            echo 'Not yours to decide';
        }
    }

    public function JSONviewSettings()
    {
        $data['settings'] = $this->settings;
        $this->loadView('admin/settings', $data);
    }


}

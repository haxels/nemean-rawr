<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 5/7/12
 * Time: 9:52 PM
 * To change this template use File | Settings | File Templates.
 */
    require_once MODULEPATH . 'reservations/classes/Reservation.php';

    class ReservationsMapper extends DataMapper
    {
        protected $entityTable = "rsv_reservations";
        protected $primaryKey  = 'seat_id';

        public function insert(Reservation $r)
        {
            return $this->adapter->insert($this->entityTable, array('seat_id' => $r->getSeatId(),
                                                             'user_id' => $r->getUserId(),
                                                             'date' => $r->getDate(),
                                                             'type' => $r->getType(),
                                                             'name' => $r->getName()));
        }

        public function deleteReservations()
        {
            return $this->adapter->delete($this->entityTable);
        }

        public function deleteGuests()
        {
            return $this->adapter->delete('rsv_guests');
        }

        public function reserveLockedSeat($seat_id)
        {
            return $this->adapter->insert($this->entityTable, array('seat_id' => $seat_id,
                                                                    'user_id' => 0,
                                                                    'date' => time(),
                                                                    'type' => 1));
        }

        public function isSeated($user_id)
        {
            $this->adapter->select($this->entityTable, array('user_id' => $user_id));
            return ($this->adapter->getAffectedRows() > 0) ? true : false;
        }

        public function update(Reservation $r)
        {
            return $this->adapter->update($this->entityTable, array('seat_id' => $r->getSeatId(),
                                                                    'user_id' => $r->getUserId(),
                                                                    'date' => $r->getDate(),
                                                                    'type' => $r->getType(),
                                                                    'name' => $r->getName())
                                                            , 'user_id = '.$r->getUserId());
        }

        public function delete($where)
        {
            return $this->adapter->delete($this->entityTable, $where);
        }

        public function getReservations()
        {
            $sql = sprintf('SELECT `r`.*, `u`.`firstname`, `u`.`lastname` FROM `rsv_reservations` `r` LEFT JOIN `usr_users` `u` ON (`r`.`user_id` = `u`.`user_id`)');
            $this->adapter->prepare($sql)->execute();
            $rows =  $this->adapter->fetchAll();
            $retVal = [];
            foreach ($rows as $row)
            {
                $retVal[] = $this->createEntity($row);
            }
            return $retVal;
        }

        public function registerGuest(Guest $g)
        {
            return $this->adapter->insert('rsv_guests', array('name' => $g->getName()));
        }

        public function getNumGuests()
        {
            $this->adapter->select('rsv_guests', []);
            return count($this->adapter->fetchAll());
        }

        protected function createEntity(array $row)
        {
            $name = (isset($row['name'])) ? $row['name'] : '';
            return new Reservation($row['seat_id'], $row['user_id'], $row['date'], $row['type'], $name); //$row['firstname'] . ' ' . $row['lastname']);
        }

    }
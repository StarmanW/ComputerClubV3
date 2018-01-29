<?php
/**
 * User: StarmanW
 * Date: 28-Jan-18
 * Time: 10:33 PM
 */

require_once 'DB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ComputerClub/application/includes/entity/Event.php';

class EventService extends DB {

    //Constructor method
    public function __construct() {
        parent::__construct();
    }

    //Method to find event
    private function getEvent($eventID) {
        $eventExist = $this->em->getRepository('Event')->findOneBy(array('eventID' => $eventID));
        return $eventExist === null ? 0 : 1;
    }

    //Method to retrieve a specific event
    public function getEventByID($eventID) {
        $eventID = $this->em->getRepository('Event')->findOneBy(array('eventID' => $eventID));
        return $eventID === null ? 0 : $eventID;
    }

    //Method to retrieve all Events
    public function getAllEvents() {
        $events = $this->em->getRepository('Event')->findAll();
        return $events === null ? 0 : $events;
    }

    //Method to create new event record
    public function createEvent($event) {
        $successInsert = false;

        if ($this->getEvent($event->getEventID())) {
            $successInsert = -1;        //-1 for duplicated record
        } else {
            try {
                $this->em->beginTransaction();
                $this->em->persist($event);
                $this->em->commit();
                $this->em->flush();
                $successInsert = true;
            } catch (\Doctrine\ORM\OptimisticLockException $e) {
                $this->em->rollback();
            }
        }
        return $successInsert;
    }

    //Method to update event record
    public function updateEvent($event) {
        $successUpdate = false;

        if ($this->getEvent($event->getEventID())) {
            try {
                $this->em->beginTransaction();
                $this->em->merge($event);
                $this->em->commit();
                $this->em->flush();
                $successUpdate = true;
            } catch (Exception $e) {
                $this->em->rollback();
            }
        }
        return $successUpdate;
    }

    //Method to delete event
    public function deleteEvent($event) {
        $successDelete = false;

        if ($this->getEvent($event->getEventID())) {
            try {
                $this->em->beginTransaction();
                $this->em->remove($event);
                $this->em->commit();
                $this->em->flush();
                $successDelete = true;
            } catch (Exception $e) {
                $this->em->rollback();
            }
        }
        return $successDelete;
    }
}
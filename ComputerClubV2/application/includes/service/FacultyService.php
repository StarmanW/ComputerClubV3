<?php
/**
 * User: StarmanW
 * Date: 25-Jan-18
 * Time: 8:38 PM
 */
require_once 'DB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/entity/Faculty.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/entity/Programme.php';

class FacultyService extends DB {

    //Constructor method
    public function __construct() {
        parent::__construct();
    }

    //Method to retrieve a specific faculty
    public function getFacultyByID($facultyID) {
        $faculty = $this->em->getRepository(Entity\Faculty::class)->findOneBy(array('facultyID' => $facultyID));
        return $faculty === null ? 0 : $faculty;
    }

    //Method to retrieve all Faculties
    public function getAllFaculties() {
        return $this->em->getRepository(Entity\Faculty::class)->findAll();
    }

    //Method to create new faculty record
    public function createFaculty($faculty) {
        $successInsert = false;

        if ($this->getFacultyByID($faculty->getFacultyID()) !== 0) {
            $successInsert = -1;        //-1 for duplicated record
        } else {
            try {
                $this->em->beginTransaction();
                $this->em->persist($faculty);
                $this->em->commit();
                $this->em->flush();
                $successInsert = true;
            } catch (\Doctrine\ORM\OptimisticLockException $e) {
                $this->em->rollback();
            }
        }
        return $successInsert;
    }

    //Method to update faculty record
    public function updateFaculty($faculty) {
        $successUpdate = false;

        if ($this->getFacultyByID($faculty->getFacultyID()) !== 0) {
            try {
                $this->em->beginTransaction();
                $this->em->merge($faculty);
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
    public function deleteEvent($faculty) {
        $successDelete = false;

        if ($this->getFacultyByID($faculty->getFacultyID()) !== 0) {
            try {
                $this->em->beginTransaction();
                $this->em->remove($faculty);
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
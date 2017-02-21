<?php
include_once 'C:\wamp\www\ADSS-Prototype\help_functions.php';

class Patient {

    /**
     * get all patients in db
     * @return array $result - all patients
     */
    public static function getPatients() {
        $db = new Database();
        $q = 'SELECT * FROM patients';
        $result = $db->createQuery($q);
        return $result;
    }

    /**
     * get all patients ids in db
     * @return array $result - all patients ids
     */
    public static function getPatientsId() {
        $db = new Database();
        $q = 'SELECT id FROM patients';
        $result = $db->createQuery($q);
        return $result;
    }
}

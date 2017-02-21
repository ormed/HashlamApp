<?php
class Physician extends Person {
    private $password;

    private function getPassword() {
        return $this->password;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function getSelection() {
        // TODO - Fill this function
    }
}
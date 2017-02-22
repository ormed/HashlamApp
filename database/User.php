<?php

class User {

    /**
     * function to check if form was submitted ok
     * return errors if found any
     */
    public static function testSignIn() {
        $value = array("status" => 404, "title" => 1);
        if ((empty($_REQUEST['userId'])) || (empty($_REQUEST['password']))) {
            // One of the fields is empty
        } else {
            $result = User::getUser($_REQUEST['userId']);
            // check if user was found in database
            if ($result) {
                $hash = $result[0]['password'];
                $password = $_REQUEST['password'];
                //check if password match
                if (!password_verify($password, $hash)) {
                    // Wrong password
                } else {
                    $value = array("status" => 200, "title" => $result[0]['title']);
                }
            } else {
                //"User was not found";
            }
        }
        return $value;
    }

    /**
     * get user params from post
     */
    public static function newUser($userId, $password, $title, $regId) {
        $password = password_hash($password, PASSWORD_BCRYPT);;
        return User::insertUser($userId, $password, $title, $regId);
    }

    /**
     * update a new user to database
     */
    public static function insertUser($userId, $password, $title, $regId) {
        $db = new Database();
        $q = "INSERT INTO `Tusers` (`userId`, `password`, `title`, `regId`) VALUES ('{$userId}','{$password}', '{$title}', '{$regId}');";
        return $db->createQuery($q);
    }

    /**
     * get user from database
     * return false if was not found
     * @param array $user - a userId to search for
     * @return array $result - found user
     */
    public static function getUser($user) {
        $db = new Database();
        $q = "SELECT userId, title FROM `Tusers` WHERE userId='{$user}'";
        $result = $db->createQuery($q);
        if (count($result) > 0) {
            return $result;
        } else {
            return FALSE;
        }
    }

    /**
     * get all users from db
     * @return array $result - all users
     */
    public static function getUsers() {
        $db = new Database();
        $q = "SELECT userId, title FROM `Tusers`";
        $result = $db->createQuery($q);
        return $result;
    }
}

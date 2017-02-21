<?php
@session_start();
include_once 'C:\wamp\www\ADSS-Prototype\help_functions.php';

class Notification {


    /**
     * insert new notification to database
     * get notification params from post
     */
    public static function insertNotification($content) {
        // Set date to current hospital location
        date_default_timezone_set('Asia/Tel_Aviv'); // Tel Aviv location
        $currentTime = new DateTime();
        // Get the date from DateTime object
        $dateString = date_format($currentTime, 'Y-m-d H:i:s');

        $db = new Database();

        if(empty($_POST['alert_name'])) {
            $q = "SELECT `AUTO_INCREMENT` as id FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='adss' AND TABLE_NAME='notification'";
            $result = $db->createQuery($q);
            $lastId = $result[0]['id'];
            $_POST['alert_name'] = "Alert #".$lastId;
        }
        $q = "INSERT INTO `adss`.`notification` (`author`, `created_time`, `title`, `content`) VALUES
             ('{$_SESSION['name']}', '{$dateString}', '{$_POST['alert_name']}', '{$content}');";
        $db->createQuery($q);
    }

    /**
     * get all ids selected in Notification window
     * $_POST[check] contains all the ids
     * @return string of ids with comma (,) between them (e.g: "5,17,35")
     */
    public static function getIds() {
        if(!isset($_POST['check']))
            return FALSE;
        $idsString = "id:";
        foreach($_POST['check'] as $key=>$id) {
            $idsString .= $id.",";
        }
        return rtrim($idsString, ",");
    }

    /**
     * get all constraints added in Notification window
     * $_POST[input_*] contains all the constraints
     * @return string of constraints with dot (.) between them (e.g: "MAP>5for-24h.VAP<14for-48h.")
     */
    public static function getConstraints() {
        $constraintsString = "constraints:";
        $i = 1;
        while(isset($_POST['input_'.$i])) {
            $constraint = $_POST['input_'.$i];
            $const_arr = explode(" ",$constraint);
            if(!in_array($const_arr[4], array("24h", "48h", "72h"), true)) { // == "&infin") {
                $const_arr[4] = "inf";
            }
            $constraintsString .= $const_arr[0].$const_arr[1].$const_arr[2]."for-".$const_arr[4].".";
            $i++;
        }
        return $constraintsString;
    }

    /**
     * delete Notification by id
     * @param $id - the Notification id
     * @return FALSE if something went wrong
     */
    public static function deleteNotification($id) {
        $db = new Database();
        $q = "DELETE FROM notification WHERE id='{$id}'";
        $result = $db->createQuery($q);
        return $result;
    }


    /**
     * get notification from database
     * return false if was not found
     * @param array $id - notification id to search for
     * @return array $result - found notification
     */
    public static function getNotification($id) {
        $db = new Database();
        $q = "SELECT * FROM notification WHERE id='{$id}'";
        $result = $db->createQuery($q);
        if (count($result) > 0) {
            return $result;
        } else {
            return FALSE;
        }
    }

    /**
     * get all notifications in db
     * @return array $result - all notifications
     */
    public static function getNotifications() {
        $db = new Database();
        $q = "SELECT * FROM notification ORDER BY created_time DESC";
        $result = $db->createQuery($q);
        return $result;
    }

}

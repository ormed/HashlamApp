<?php

class Attendance
{
    /**
     * get a user attendance from db
     */
    public static function getUserAttendance($userId, $date)
    {
        $db = new Database();
        $q = "SELECT `date`, `start` FROM `Tattendance` WHERE `userId` = '{$userId}' and `date` = '{$date}' ORDER BY `date`,`start` ASC";
        $result = $db->createQuery($q);
        return $result;
    }


}
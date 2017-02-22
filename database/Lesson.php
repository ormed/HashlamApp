<?php
require_once('Database.php');

class Lesson
{
    /**
     * get lessons from db
     */
    public static function getLessonsByDate($date) {
        $db = new Database();
        $q = "SELECT * FROM `Tlesson` WHERE `date` = '{$date}' ORDER BY `start` ASC";
        $result = $db->createQuery($q);
        return $result;
    }

    /**
     * Create new lesson in db
     */
    public static function insertLesson($date, $start, $end, $title, $description, $class) {
        $db = new Database();
        $q = "INSERT INTO `Tlesson` (`date`, `start`, `end`, `title`, `description`, `class`) VALUES ('{$date}','{$start}', '{$end}', '{$title}', '{$description}', '{$class}');";
        $result = $db->createQuery($q);
    }

    /**
     * Update lesson
     */
    public static function updateLesson($date, $start, $end, $title, $description, $class)
    {
        $db = new Database();
        $q = "UPDATE `Tlesson` SET `date`='{$date}', `start`='{$start}', `end`='{$end}',
              `title`='{$title}', `description`='{$description}', `class`='{$class}'
               WHERE `date`=$date AND `start`=$start";
        $result = $db->createQuery($q);
    }
}
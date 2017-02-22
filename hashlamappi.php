<?php
require_once('database/Database.php');
require_once('database/User.php');
require_once('database/Lesson.php');
require_once('database/Attendance.php');
?>

<?php

// NEW USER
for($i=12; $i<=19; $i++) {
    User::newUser($i, "1234", "1", "");
}

//method that clean the input from things we dont want
//return clean data
function cleanInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// This is the API to possibility show the user list, and show a specific user by action.

// Get a user by his userId
function get_user_by_id($id)
{
    $db = new Database();
    $q = "SELECT * FROM `Tusers` where userId='{$id}'";
    $user_info = $db->createQuery($q);
    return json_encode($user_info);
}

// Login check - userId & pw correct
function login()
{
    $user_info = User::testSignIn();
    return json_encode($user_info);
}

/*
 * Retrieve all calendar date from db
 * $date - the date to get data
 * @return JSON of all the lessons occurs in the given $date
 */
function get_calendar($date)
{
    $result = Lesson::getLessonsByDate($date);
    return json_encode($result);
}

/*
 * Insert new lesson to database
 * Get data from the POST request
 * 
 */
function insert_lesson()
{
    Lesson::insertLesson($_REQUEST['date'], $_REQUEST['start'], $_REQUEST['end'],
                $_REQUEST['title'], $_REQUEST['description'], $_REQUEST['class']);
}

/*
 * Update lesson in database
 * Change lesson details from POST request
 */
function update_lesson()
{
    Lesson::updateLesson($_REQUEST['date'], $_REQUEST['start'], $_REQUEST['end'],
        $_REQUEST['title'], $_REQUEST['description'], $_REQUEST['class']);
}

/*
 * Update lesson in database
 * Change lesson details from POST request
 */
function create_attendance()
{
    $result = User::getUsers();
    return json_encode($result);
}

/*
 * Get user attendance by his userId and date
 * returns - JSON contains all data of user's missing lessons
 */
function get_user_attendance($userId, $date)
{
    $result = Attendance::getUserAttendance($userId, $date);
    return json_encode($result);
}

// array of the actions in api
$possible_url = array("login", "get_calendar", "insert_lesson", "update_lesson", "get_user_attendance", "create_attendance");

// returns error if action not found
$value = "An error has occurred";

// Check POST request and action to do
if (isset($_REQUEST) && in_array($_REQUEST["action"], $possible_url))
{
    switch ($_REQUEST["action"])
    {
        case "login":
            $value = login();
            break;
        case "get_calendar":
            $value = get_calendar($_REQUEST["date"]);
            break;
        case "insert_lesson":
            insert_lesson();
            break;
        case "update_lesson":
            update_lesson();
            break;
        case "create_attendance":
            $value = create_attendance();
            break;
        case "get_attendance":
            $value = get_user_attendance();
            break;
    }
}

exit($value);

?>
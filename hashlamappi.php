<?php require_once('database/Database.php'); ?>

<?php

/*$db = new Database();
$q = "Select * from 'Tusers'";
$user_info = $db->createQuery($q);
echo $user_info;*/

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

function get_user_list()
{
    $user_list = array(array("id" => 1, "name" => "Simon"), array("id" => 2, "name" => "Zannetie"), array("id" => 3, "name" => "Carbonnel")); // call in db, here I make a list of 3 users.

    return $user_list;
}

// NEW USER
// $password = password_hash($pass, PASSWORD_BCRYPT);;

function login()
{
    $db = new Database();
    $_REQUEST['username'] = cleanInput($_REQUEST['username']);
    $_REQUEST['password'] = cleanInput($_REQUEST['password']);
    $q = "Select * from `Tusers` where username='{$_REQUEST['username']}' and password='{$_REQUEST['password']}'";
    $user_info = $db->createQuery($q);
    echo $user_info;
}

// array of the actions in api
$possible_url = array("login", "get_user");

// returns error if action not found
$value = "An error has occurred";

if (isset($_REQUEST) && in_array($_REQUEST["action"], $possible_url))
{
    switch ($_REQUEST["action"])
    {
        case "login":
            $value = login();
            break;
        case "get_user":
            if (isset($_GET["id"]))
                $value = get_user_by_id($_GET["id"]);
            else
                $value = "Missing argument";
            break;
        
    }
}

exit($value);

?>
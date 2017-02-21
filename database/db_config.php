<?php

/*
 * All database connection variables
 */

define('DB_USER', "u217473412_socia"); // db user
define('DB_PASSWORD', "6938705"); // db password
define('DB_DATABASE', "u217473412_socia"); // database name
define('DB_SERVER', "mysql.hostinger.co.il"); // db server

// Google Cloud Messaging API Key
// Place your Google API Key
define("GOOGLE_API_KEY", "AIzaSyDka8dLN3iWaWPPN4MiuTSZwFaXUz0rYN0");


//ACTIONS
define("ACTION_LOGIN", "login");
define("ACTION_REGISTER", "register");
define("ACTION_ADD_FRIEND", "add_friend");
define("ACTION_ADD_FRIEND_GET", "add_friend_get");
define("ACTION_SEND_MESSAGE", "send_message");
define("ACTION_GET_MESSAGE", "get_message");
define("ACTION_REFRESH_TOKEN", "refreshToken");
define("ACTION_ADD_FRIEND_CANCEL", "add_friend_cancel");
define("ACTION_ADD_FRIEND_REJECT", "add_friend_reject");
define("ACTION_ADD_FRIEND_ACCEPT", "add_friend_accept");
define("ACTION_UPLOAD_IMAGE", "upload_image");



//Utilities
define("USER_NAME_FROM", "user_name_from");
define("USER_NAME_TO", "user_name_to");
define("MESSAGE", "message");
define("FRIEND", "friend");


//RETURN CODES
define("SUCCESS_LOGIN", "0");
define("FAILED_LOGIN", "1");
define("SUCCESS_REGISTRATION", "2");
define("USERNAME_EXISTS", "3");
define("FCM_ID_EXISTS", "4");
define("USER_NAME_IS_IN_DB", "5");
define("USER_NAME_IS_NOT_IN_DB", "6");

define("MISSING_IMAGE", "missing_image");
define("ONLINE", "online");
define("OFFLINE", "offline");

?>
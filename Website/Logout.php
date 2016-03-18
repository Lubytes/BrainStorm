<?php
//ends the session and logs the user out
session_name('project');  
session_start();


$_SESSION = array();

session_unset();

session_destroy();

//redirects
header("location: Login.php");

?>
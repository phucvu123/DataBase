<?php
session_start();
$_SESSION = array();
session_destroy();
header("Location: http://www.databaseteam12.x10host.com/"); 
?>
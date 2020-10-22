<?php

require_once("session_start.php");

$_SESSION = array();
session_destroy();

header("Location: login.php");
?>
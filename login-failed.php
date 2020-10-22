<?php

require_once("session_start.php");

if(isset($_SESSION['failed']))
{
    echo($_SESSION['failed']);
    unset($_SESSION['failed']);
}

if (isset($_SESSION['errors']))
{
    if($_SESSION['errors']=="empty")
    {
        echo "Fyll i alla fält innan du skickar";
    }
    unset($_SESSION['errors']);
}
?>
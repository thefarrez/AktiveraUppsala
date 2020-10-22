<?php

if(isset($_POST['username']) && isset($_POST['password']) && !empty($_POST['username']) && !empty($_POST['password'])) {

    require("connect.php");
    require_once("session_start.php");

    $username = mysqli_real_escape_string($db, strip_tags($_POST['username']));
    $password = mysqli_real_escape_string($db, strip_tags($_POST['password']));

    $username = trim($username);
    $password = trim($password);

    $sql = "SELECT salt FROM Kund WHERE anvandarnamn='$username'";
    $result = mysqli_query($db, $sql);
    $getID = mysqli_fetch_assoc($result);
    $salt = $getID['salt'];

    $password = md5($password . 'mYrAnd0Mst4tiCs4Lt' . $salt);

    $sql = "SELECT losenord FROM Kund WHERE anvandarnamn='$username'";
    $result = mysqli_query($db, $sql);
    $getID = mysqli_fetch_assoc($result);
    $pwDb = $getID['losenord'];

    if ($password == $pwDb)
    {
        $_SESSION['username']=$username;
    }
    else
    {
        $_SESSION['failed']="Fel lösenord" . "<br>" . mysqli_error($db);
    }

    header("Location: login.php");

    mysqli_close($db);
}
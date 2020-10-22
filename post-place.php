<?php
require_once("session_start.php");

function valid_email($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function replaceChars($str)
{
    $str = str_replace("Å", "&Aring", $str);
    $str = str_replace("å", "&aring", $str);
    $str = str_replace("Ä", "&Auml", $str);
    $str = str_replace("ä", "&auml", $str);
    $str = str_replace("Ö", "&Ouml", $str);
    return str_replace("ö", "&ouml", $str);
}

require("connect.php");

if (!$db) {
    echo "<p>Felkod: " . mysqli_connect_errno() . "</p>";
    echo "<p>Felmeddelande: " . mysqli_connect_error() . "</p>";
    die();
}

if (isset($_POST['namn']) && isset($_POST['adress']) && isset($_POST['url']) && isset($_POST['telenr'])) {

    $namn = mysqli_real_escape_string($db, strip_tags($_POST['namn']));
    $adress = mysqli_real_escape_string($db, strip_tags($_POST['adress']));
    $url = mysqli_real_escape_string($db, strip_tags($_POST['url']));
    $telenr = mysqli_real_escape_string($db, strip_tags($_POST['telenr']));

    $namn = replaceChars($namn);
    $adress = replaceChars($adress);
    $url = urlencode(trim($url));

    $namn = trim($namn);
    $adress = trim($adress);
    $url = trim($url);


    if ($namn == "" || $adress == "" || $url == "" || $telenr == "") {
        header("Location: add-place.php");
    }

    $sql = "INSERT INTO Traningsanlaggning (namn, hemsida_url, tel_nr, adress) VALUES ('" . $namn . "', '" . $url
        . "',  '" . $telenr . "',  '" . $adress . "')";

    $result = mysqli_query($db, $sql);

    if (!$result) {
        // queryn misslyckades, visar fel
        echo "<p>Felkod: " . mysqli_errno($db) . "</p>";
        echo "<p>Felmeddelande: " . mysqli_error($db) . "</p>";
    }

    mysqli_close($db);

    if ($result) {
        header("Location: create-session.php");
    }

} else {
    echo "Error :(";
}
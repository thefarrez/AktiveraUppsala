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
    // Förresten var uppmärksam att funktionerna är olika, ena är errno, som i error number
    // och den andra är error, för felmeddelandet.
    echo "<p>Felkod: " . mysqli_connect_errno() . "</p>";
    echo "<p>Felmeddelande: " . mysqli_connect_error() . "</p>";

    // Man måste inte skicka in en text till die() om man inte vill.
    die();
}

// isset() gör som det låter, den kollar om en variabel är satt/om den existerar. Så om inget har skickats så kommer
// sidan inte att försöka posta en kommentar.
if (isset($_POST['activity']) && isset($_POST['price']) && isset($_POST['agegroup']) && isset($_POST['title'])
    && isset($_POST['article']) && isset($_SESSION['username']) && isset($_POST['place'])) {

    $activityNum = mysqli_real_escape_string($db, strip_tags($_POST['activity']));
    $price = mysqli_real_escape_string($db, strip_tags($_POST['price']));
    $agegroupNum = mysqli_real_escape_string($db, strip_tags($_POST['agegroup']));
    $title = mysqli_real_escape_string($db, strip_tags($_POST['title']));
    $article = mysqli_real_escape_string($db, strip_tags($_POST['article']));
    $ta_id = mysqli_real_escape_string($db, strip_tags($_POST['place']));

    $title = replaceChars($title);
    $article = replaceChars($article);

    //nu blir det inga mellanslag före och efter en kommentar i databasen
    switch (intval(trim($activityNum))) {
        case 0:
            $activity = "Kondition";
            break;
        case 1:
            $activity = "Styrketr&auml;ning";
            break;
        case 2:
            $activity = "R&ouml;rlighet";
            break;
        case 3:
        default:
            $activity = "Sport";
    }
    $price = intval(trim($price));
    switch (intval(trim($agegroupNum))) {
        case 1:
            $agegroup = "teenager";
            break;
        case 2:
            $agegroup = "child";
            break;
        case 0:
        default:
            $agegroup = "adult";
    }
    $title = trim($title);
    $article = trim($article);
    /*$year = strftime(%G,time());
    $month = strftime(%e,time());
    $day = strftime(%d,time());
    $time = strftime(%R,time());*/
    //om förvirringen kring datum slår till så :https://www.w3schools.com/php/func_date_strftime.asp


    if ($activity == "" || $agegroup == "" || $title == "" || $article == "") {
        header("Location: create-session.php");
    }

    $sql = "INSERT INTO Traningspass (anvandarnamn, kategori, pris, aldersgrupp, rubrik, artikel, ar, manad, dag, tid, ta_id) VALUES ('"
        . $_SESSION['username'] . "', '" . $activity . "',  " . $price . ",  '" . $agegroup . "',  '" . $title
        . "',  '" . $article . "', " . date("Y") . ", " . date("n") . ", " . date("j") . ", '"
        . date("H:i") ."', " . $ta_id . ")";

    $result = mysqli_query($db, $sql);

    if (!$result) {
        // queryn misslyckades, visar fel
        echo "<p>Felkod: " . mysqli_errno($db) . "</p>";
        echo "<p>Felmeddelande: " . mysqli_error($db) . "</p>";
    }

    if ($result) {
        header("Location: view-session.php?id=" . mysqli_insert_id($db));
        mysqli_close($db);
    }

} else {
    echo "Error :(";
}
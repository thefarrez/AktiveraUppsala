<?php
require_once("session_start.php");
require("connect.php");

$username = mysqli_real_escape_string($db, $_SESSION['username']);
$tp_id = mysqli_real_escape_string($db, $_GET['id']);
$sql = "SELECT typ_id FROM Kund WHERE anvandarnamn = '" . $username . "'";
$result = mysqli_query($db, $sql);

if (!$result) {
    // queryn misslyckades, visar fel
    echo "<p>Felkod: " . mysqli_errno($db) . "</p>";
    echo "<p>Felmeddelande: " . mysqli_error($db) . "</p>";
} else {
    if (mysqli_fetch_assoc($result)['typ_id'] == 1) {
        $sql = "DELETE FROM Traningspass WHERE tp_id = " . $tp_id;
        $result = mysqli_query($db, $sql);
        if (!$result) {
            // queryn misslyckades, visar fel
            echo "<p>Felkod: " . mysqli_errno($db) . "</p>";
            echo "<p>Felmeddelande: " . mysqli_error($db) . "</p>";
        } else {
            header("Location: ./");
        }
    }
}
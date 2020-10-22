<?php
require_once("session_start.php");
require("connect.php");

if (isset($_SESSION['username']) && isset($_POST['comment']) && !empty($_POST['comment']) && isset($_GET['id'])) {
    $username = mysqli_real_escape_string($db, $_SESSION['username']);
    $comment = mysqli_real_escape_string($db, $_POST['comment']);
    $tp_id = mysqli_real_escape_string($db, $_GET['id']);

    $sql = "INSERT INTO Kommentarer (anvandarnamn, kommentar, ar, manad, dag, tid, tp_id) VALUES "
        . "('" . $username . "', '" . $comment . "', '" . date("Y") . "', '" . date("n") . "', '"
        . date("j") . "', '" . date("H:i") . "', " . $tp_id . ")";
    $result = mysqli_query($db, $sql);

    if (!$result) {
        // queryn misslyckades, visar fel
        echo "<p>Felkod: " . mysqli_errno($db) . "</p>";
    } else {
        header("Location: view-session.php?id=".$tp_id);
    }

}
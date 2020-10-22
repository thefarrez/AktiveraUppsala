<?php
require_once("session_start.php");

function checkError($db) {
    if(!$db) {
        die("Ett fel inträffade!<br>Felkod: " . mysqli_errno($db) . "<br>Felmeddelande: " . mysqli_error($db));
    }
}

require("connect.php");

if (!$db) {
    die("Anslutningen misslyckades!");
}

$sql = "SELECT * FROM Kommentarer";

$result = mysqli_query($db, $sql);

checkError($db);

// Vi hämtar alla rader som vi SELECT:ade en rad i taget, while loopen slutar när den hämtat ut alla rader.
// Varje rad innehåller en array med kolumner, det vi gör här är att vi tar ut en rad i taget så vi har en
// array med kolumner. t.ex $row['namn'] ger Pontus om du inte ändrade det i förra lektionen.
while ($row = mysqli_fetch_assoc($result)) {
    echo "<div class=\"ltr\"><div class=\"ltd\"><div class=\"smal\"><b>" . $row['namn'] . "</b> säger: </div></div></div>";
    echo "<div class=\"ltr\"><div class=\"ltd\"><div class=\"smal\">" . $row['kommentar'] . "</div><hr></div></div>";
}

mysqli_close($db);

?>


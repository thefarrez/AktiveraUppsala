<?php

function saltGenerator()
{
    $length = 15;
    $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@?_-+"), 0, $length);
    return $randomString;
}

function valid_email($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}


if (isset($_POST['email']) && isset($_POST['username']) && isset($_POST['password']) && !empty($_POST['email']) && !empty($_POST['username']) && !empty($_POST['password'])) {

    $salt = saltGenerator();
    //$password = ($salt . $password . $salt);

    require("connect.php");
    require_once("session_start.php");

    if (!$db) {
        // Förresten var uppmärksam att funktionerna är olika, ena är errno, som i error number
        // och den andra är error, för felmeddelandet.
        echo "<p>Felkod: " . mysqli_connect_errno() . "</p>";
        echo "<p>Felmeddelande: " . mysqli_connect_error() . "</p>";

        // Man måste inte skicka in en text till die() om man inte vill.
        die();
    }

    /*if(($_POST['email']) == ""|| ($_POST['username']) == ""|| ($_POST['password']) =="")
    {
        $_SESSION['errors']="empty";
        header("Location: register.php");
    }*/

    $email = mysqli_real_escape_string($db, strip_tags($_POST['email']));
    $username = mysqli_real_escape_string($db, strip_tags($_POST['username']));
    $password = mysqli_real_escape_string($db, strip_tags($_POST['password']));

//nu blir det inga mellanslag före och efter en kommentar i databasen
    $email = trim($email);
    $username = trim($username);
    $password = trim($password);

    $password = md5($password . 'mYrAnd0Mst4tiCs4Lt' . $salt);


    if (valid_email($email)) {
        if ($username == "") {
            $_SESSION['check'] = "Fyll i användarnamnet.";
        } else {
            $checkEmail = ("SELECT * FROM Kund WHERE epost='" . $email . "'");
            $result = mysqli_query($db, $checkEmail);
            $num_rows = mysqli_num_rows($result);
            if ($num_rows >= 1) {
                $_SESSION['check'] = "Den e-mail du angav är upptagen. Försök igen.";
                header("Location: register.php");
                exit();
            }

            //Då den inte tillåter att lägga in om vi inte har med foreign key typ_id också har jag slängt in den tills vidare
            //Första inlägget i tabellen går inte att radera såvida man inte helt och hållet tar bort foreign key-relationen först, av någon anledning
            $sql = "INSERT INTO Kund (epost, anvandarnamn, losenord, salt, typ_id) VALUES ('" . $email . "', '" . $username . "', '" . $password . "', '" . $salt . "', '" . 2 . "')";
            $result = mysqli_query($db, $sql);

            if (!$result) {
                // queryn misslyckades, visar fel
                echo mysqli_error($db);
                mysqli_close($db);
                $_SESSION['check'] = "Det användarnamn du angav är upptaget. Försök igen.";
            } else {
                $_SESSION['user'] = $username;
                mysqli_close($db);
            }
        }
    } else {
        $_SESSION['check'] = "Ange en korrekt e-mail.";
    }

    header("Location: register.php");
}




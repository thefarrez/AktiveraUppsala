<?php
require_once("session_start.php");
?>
<html>
<head>
    <?php
    include("header.php");
    ?>
</head>
<body>
<div id="top">
    <?php include("menu.php") ?>
</div>
<div id="form">
    <form action="skicka-registrering.php" method="post">
        <div class="box">
        <h1 class="center dark">Registrera dig</h1>
        <table id="regTable center">
            <tr>
                <td><input class="postinputs" id="emailInput" name="email" type="text" placeholder="E-mail"
                           required="required"></td>
            </tr>
            <tr>
                <td><input class="postinputs" type="text" name="username" placeholder="Användarnamn"
                           required="required"></td>
            </tr>
            <tr>
                <td><input class="postinputs" id="pwInput" name="password" type="password" placeholder="Lösenord"
                           required="required"></td>
            </tr>
            <tr>
                <td><input class="redbtn" id="regbtn" name="register_btn" type="submit" value="Fortsätt"></td>
            </tr>
            <tr>
                <td><a class="reglink" href="login.php">Redan medlem?</a></td>
            </tr>
        </table>
        <div class="info"><?php

            if (isset($_SESSION['user'])) {
                unset($_SESSION['user']);
                header("Location: login.php");
                //$_SESSION = array();
                //session_destroy();
            } elseif (isset($_SESSION['check'])) {
                echo($_SESSION['check']);
                unset($_SESSION['check']);
            }

            ?></div>
        </div>
    </form>
</div>
<?php include("footer.php"); ?>
</body>
</html>
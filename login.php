<?php
require_once("session_start.php");
include("login-process.php");
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    //$_SESSION = array();
    //session_destroy();
}
?>
<html>
<head>
    <?php include("header.php") ?>
</head>
<body>
<div id="top">
    <?php include("menu.php") ?>
</div>
<div id="form">
    <form action="login-process.php" method="post">
        <div class="box">
            <h1 class="center dark">Logga in</h1>
            <table>
                <tr>
                    <td><input class="postinputs" name="username" type="text" placeholder="Användarnamn"
                               required="required"></td>
                </tr>
                <tr>
                    <td><input class="postinputs" id="pwInput" name="password" type="password" placeholder="Lösenord"
                               required="required"></td>
                </tr>
                <tr>
                    <td><p class="redandnice">
                            <?php
                            include("login-failed.php")
                            ?>
                        </p></td>
                </tr>
                <tr>
                    <td><input type="submit" value="Logga in" class="redbtn" id="loginbtn">
                </tr>
                </td>
                <tr>
                    <td><a class="reglink" href="register.php">Inte medlem än?</a></td>
                </tr>
            </table>
        </div>
    </form>
</div>
<?php include("footer.php") ?>
</body>
</html>
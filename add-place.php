<?php require_once("session_start.php") ?>
<!DOCTYPE html>
<html>
<head>
    <?php include("header.php") ?>
</head>
<body>
<div id="top">
    <?php include("menu.php") ?>
</div>
<div id="main">
    <form method="post" action="post-place.php">
        <h2 class="center">Lägg till ny träningsanläggning</h2>
        <div class="box force-center">
        <table>
            <tr>
                <td><input type="text" class="postinputs" name="namn" placeholder="Namn" required></td>
            </tr>
            <tr>
                <td><input type="text" class="postinputs" name="adress" placeholder="Adress" required></td>
            </tr>
            <tr>
                <td><input type="text" class="postinputs" name="url" placeholder="Hemsida" required></td>
            </tr>
            <tr>
                <td><input type="text" class="postinputs" name="telenr" placeholder="Telefonnr" required></td>
            </tr>
            <tr>
                <td><input type="submit" class="redbtn" value="Lägg till"></td>
            </tr>
        </table>
        </div>
    </form>
</div>
<?php include("footer.php") ?>
</body>
</html>

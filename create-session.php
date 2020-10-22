<?php
require_once("session_start.php");

//Redirect så att man inte ska kunna skriva en artikel utan att vara inloggad
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}
?>
<html>
<head>
    <title>Skriv träningspass</title>
    <?php include("header.php") ?>
</head>
<body>
<div id="top">
    <?php include("menu.php") ?>
</div>
<div id="main">
    <form action="post-session.php" method="post">
        <h1 class="first">Skriv om träningspass</h1>
        <div class="box">
            <table id="regTable">
                <tr>
                    <td>
                        <select class="postinputs" name="place" id="place" required>
                            <option value="" disabled selected>Vart var du?</option>
                            <?php
                            require_once("connect.php");

                            $sql = "SELECT * FROM Traningsanlaggning ORDER BY namn ASC";

                            $result = mysqli_query($db, $sql);

                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<option value="' . $row['ta_id'] . '">' . $row['namn'] . '</option>';
                            }
                            ?>
                            <option value="add" class="bold" onfocus="alert('sup')">+ Lägg till ny anläggning</option>
                        </select>
                    </td>
                    <td>
                        <select class="postinputs" name="activity" required>
                            <option value="" disabled selected>Vad gjorde du?</option>
                            <option value="0">Kondition</option>
                            <option value="1">Styrketräning</option>
                            <option value="2">Rörlighet</option>
                            <option value="3">Sport</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <select class="postinputs" name="agegroup" required="required">
                            <option value="" disabled selected>Åldersgrupp</option>
                            <option value="0">Vuxen</option>
                            <option value="1">Tonåring</option>
                            <option value="2">Barn</option>
                        </select>
                    </td>
                    <td><input class="postinputs" name="title" type="text" placeholder="Rubrik"
                               required="required"></td>
                </tr>
                <tr class="alright">
                    <td><label for="price"> Kostnad: </label></td>
                    <td><input id="price" class="postinputs" name="price" type="number"
                               required="required"> kr
                    </td>
                </tr>
            </table>

            <textarea class="postcomment" id="comment" name="article" cols="100" rows="25"
                      aria-required="true" required="required"
                      placeholder="Dela med dig av din upplevelse!" disabled title="Välj plats först!"></textarea>
            <input name="postBtn" class="redbtn" type="submit" value="Publicera">
        </div>
    </form>
</div>
<?php include("footer.php"); ?>
</body>
<script>
    var place = $("#place");
    var newPlace = $("#newPlace");
    place.change(function () {
        var placeSelection = place.find("option:selected");
        if (placeSelection.val().localeCompare("add") === 0) {
            window.location.href = "add-place.php";
        } else {
            $("#comment").removeAttr("disabled").removeAttr("title");
        }
    });
</script>
</html>
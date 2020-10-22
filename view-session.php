<?php
require_once("session_start.php");
if (empty($_GET['id'])) {
    header("Location: ./");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Träningspass</title>
    <?php include("header.php") ?>
    <link rel="stylesheet" href="assets/css/session.css"/>
</head>
<body>
<div id="top">
    <?php include("menu.php") ?>
</div>
<div id="main">
    <?php
    require("connect.php");
    $tp_id = mysqli_real_escape_string($db, $_GET['id']);
    $sql = "SELECT * FROM Traningspass tp JOIN Traningsanlaggning AS ta ON ta.ta_id = tp.ta_id WHERE tp_id = " . $tp_id;
    $result = mysqli_query($db, $sql);
    if (!$result) {
        // queryn misslyckades, visar fel
        echo "<p>Felkod: " . mysqli_errno($db) . "</p>";
        echo "<p>Felmeddelande: " . mysqli_error($db) . "</p>";
    } else {
        if (mysqli_num_rows($result) === 0) {
            header("Location: ./");
        }
    }
    $data = mysqli_fetch_assoc($result);
    ?>
    <div class="box">
        <h2 class="dark small center"><?= $data['rubrik'] ?></h2>
        <hr>
        <p class="small"><?= $data['artikel'] ?></p>
        <p class="discreet"><i>- <?= $data['anvandarnamn'] ?>, #<?= $data['kategori'] ?></i></p>
        <hr>
        <p class="small discreet">
            Träningsanläggning: <?= $data['namn'] ?>
        </p>
        <p class="small discreet">
            Adress: <a
                    href="https://www.google.se/maps/search/<?= urlencode($data['adress']) ?>?hl=sv&source=opensearch"
                    target="_blank"><?= $data['adress'] ?></a>
        </p>
        <p class="small discreet">
            Telefon: <a href="tel:<?= $data['tel_nr'] ?>"><?= $data['tel_nr'] ?></a>
        </p>
        <p class="small discreet">
            Hemsida: <a href="<?= $data['hemsida_url'] ?>" target="_blank"><?= urldecode($data['hemsida_url']) ?></a>
        </p>
        <?php
        if (isset($_SESSION['username'])) {
            $username = mysqli_real_escape_string($db, $_SESSION['username']);
            $sql = "SELECT typ_id FROM Kund WHERE anvandarnamn = '" . $username . "'";
            $result = mysqli_query($db, $sql);
            if (!$result) {
                // queryn misslyckades, visar fel
                echo "<p>Felkod: " . mysqli_errno($db) . "</p>";
                echo "<p>Felmeddelande: " . mysqli_error($db) . "</p>";
            } else {
                if (mysqli_fetch_assoc($result)['typ_id'] == 1) {
                    echo '<p class="small discreet"><a href="delete-session.php?id='.$data['tp_id'].'" class="dangerous">Radera inlägg</a></p>';
                }
            }
        }
        ?>

    </div>
    <h2>Kommentarer</h2>
    <div class="box">
        <?php
        if (isset($_SESSION['username'])) {
            echo '<div class="comment-write"><form method="post" action="post-comment.php?id=' . $data['tp_id'] . '"><textarea name="comment" required></textarea><br>'
                . '<input type="submit" class="redbtn small" value="Kommentera"></form></div>';
        } else {
            echo '<div class="discreet">Du måste <a href="login.php">logga in</a> för att kommentera.</div>';
        }
        ?>

        <?php
        $sql = "SELECT * FROM Kommentarer WHERE tp_id = " . $tp_id . " ORDER BY kommentar_id DESC";
        $result = mysqli_query($db, $sql);
        if (!$result) {
            // queryn misslyckades, visar fel
            echo "<p>Felkod: " . mysqli_errno($db) . "</p>";
            echo "<p>Felmeddelande: " . mysqli_error($db) . "</p>";
        } else {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '</div><div class="box"><div class="comment">';
                echo '<div class="comment-author">';
                echo $row['anvandarnamn'];
                echo '<div class="comment-date">' . $row['ar'] . '-' . $row['manad'] . '-' . $row['dag']
                    . ' Kl: ' . $row['tid'] . '</div>';
                echo '</div>';
                echo '<p>' . $row['kommentar'] . '</p>';
                echo '</div>';
            }
            if (mysqli_num_rows($result) === 0) {
                echo '<hr><div class="comment">';
                echo '<div class="discreet">Det finns inga kommentarer än...</div>';
                echo '</div>';
            }
        }
        ?>
    </div>
</div>
<?php include("footer.php") ?>
</body>
</html>

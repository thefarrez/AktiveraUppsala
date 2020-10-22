<?php
require_once("session_start.php");
$filterSet = (isset($_GET['category']) && (!empty($_GET['category']) || $_GET['category'] == "0")) ||
    (isset($_GET['q']) && (!empty($_GET['q'] || $_GET['q'] == "0")));

function replaceChars($str)
{
    $str = str_replace("Å", "&Aring", $str);
    $str = str_replace("å", "&aring", $str);
    $str = str_replace("Ä", "&Auml", $str);
    $str = str_replace("ä", "&auml", $str);
    $str = str_replace("Ö", "&Ouml", $str);
    return str_replace("ö", "&ouml", $str);
}

$title = "";

if (!$filterSet) {
    $title .= "Välkommen till Aktivera Uppsala";
} else {
    if (isset($_GET['category'])) {
        $title .= "Visar ";
        if ($_GET['category'] == "1") {
            $title .= "styrketränings";
        } elseif ($_GET['category'] == "2") {
            $title .= "rörlighets";
        } elseif ($_GET['category'] == "3") {
            $title .= "sport";
        } else {
            $title .= "konditions";
        }
        $title .= "inlägg.";
    } elseif (isset($_GET['q'])) {
        $title .= 'Visar inlägg med "' . $_GET['q'] . '" i titeln.';
    }

}

?>
<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
    <?php include("header.php") ?>
    <link rel="stylesheet" href="assets/css/home.css"/>
</head>
<body>
<div id="top">
    <?php include("menu.php") ?>
</div>
<div id="main">
    <h2><?= $title ?></h2>
    <div>
        <div id="peek-posts-title">Inspiration för träning</div>
        <div id="peek-posts">
            <?php
            require("connect.php");

            $filter = null;

            if ($filterSet && isset($_GET['category'])) {
                switch (intval($_GET['category'])) {
                    case 1:
                        $filter = "Styrketr&auml;ning";
                        break;
                    case 2:
                        $filter = "R&ouml;rlighet";
                        break;
                    case 3:
                        $filter = "Sport";
                        break;
                    case 0:
                    default:
                        $filter = "Kondition";
                }

                $filter = " WHERE kategori='" . mysqli_real_escape_string($db, $filter) . "'";
            } elseif ($filterSet && isset($_GET['q'])) {
                $filter = " WHERE rubrik LIKE '%" . mysqli_real_escape_string($db, replaceChars($_GET['q'])) . "%'";
            }

            if ($filter === null) {
                $sql = "SELECT * FROM Traningspass ORDER BY tp_id DESC LIMIT 0, 10";
            } else {
                $sql = "SELECT * FROM Traningspass" . $filter . " ORDER BY tp_id DESC";
            }

            $antal = 0;
            $result = mysqli_query($db, $sql);
            if (!$result) {
                // queryn misslyckades, visar fel
                echo "<p>Felkod: " . mysqli_errno($db) . "</p>";
                echo "<p>Felmeddelande: " . mysqli_error($db) . "</p>";
            } else {
                while ($row = mysqli_fetch_assoc($result)) {
                    $antal++;
                    echo '<div class="post"><div class="title">' . $row['rubrik'] . '</div><div class="category"><i>'
                        . $row['kategori'] . '</i></div><div class="story">' . substr($row['artikel'], 0, 200)
                        . '</div><a class="viewSession" href="view-session.php?id=' . $row['tp_id'] . '">Läs inlägget >></a></div>';
                }
                if ($antal === 0) {
                    echo '<div class="post"><div class="title">Hoppsan!</div><div class="story">Det finns tyvärr inga '
                        . 'inlägg inom kriterierna.</div></div>';
                }
            }
            ?>
        </div>
    </div>
</div>
<?php include("footer.php") ?>
</body>
</html>

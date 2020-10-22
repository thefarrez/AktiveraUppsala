<!--Vi måste lägga till en 'Skapa Artikel'-knapp någonstans på headern. Har skapat sidan create_article.php-->
<?php
require_once("session_start.php");
?>
<div id="header">
    <div id="nav">
        <div id="nav_wrapper">
            <form method="get" action="./">
                <ul>
                    <li><a class="headerlink" href="index.php">Hem</a>
                    </li>
                    <li><a class="headerlink" href="#">Kategorier</a>
                        <ul>
                            <li><a class="headerlink" href="./?category=0">Kondition</a></li>
                            <li><a class="headerlink" href="./?category=1">Styrketräning</a></li>
                            <li><a class="headerlink" href="./?category=2">Rörlighets</a></li>
                            <li><a class="headerlink" href="./?category=3">Sport</a></li>
                        </ul>
                    </li>
                    <?php
                    if (!isset($_SESSION['username'])) {
                        echo '<li><a class="headerlink" href="login.php">Login</a></li>';
                        echo '<li><a class="headerlink" href="register.php">Register</a></li>';
                    } else {
                        echo '<li><a class="headerlink" href="create-session.php">Skriv om träningspass</a></li>';
                        echo '<li><a class="headerlink" href="logout-process.php">Logga ut</a></li>';
                    }
                    ?>
                    <li class="search"><input type="text" name="q" placeholder="Sök..."
                                              class="searchfield"> <input type="submit" value="Sök" class="buttom">
                    </li>
                </ul>
            </form>
        </div>
    </div>
</div>
<!-- Nav end -->
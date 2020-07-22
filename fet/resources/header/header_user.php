<div id="header_main">
    <div id="header_grid">
        <div id="header_left">
            <img src="./Picture/pin.png" alt="pin" class="pin">
            <div id="header_left_main">CS:GO Turniere</div>
            <div id="header_left_main_big">
                <div id="titel">Counter Strike Global Offensive</div>
                <div id="titel_sub">Finde alle Turniere</div>
                <div class="header_bar"></div>
                <div class="header_bar"></div>
                <div class="header_bar"></div>
                <div class="header_bar"></div>
            </div>
        <?php
            include_once "./resources/datenbank.php";
            $logo = getUserLogo($_SESSION['user']);
            echo '
            </div>
            <div id="profil">
                <a id="header_login" href="userprofile.php">
                    <img id="profile_picture" src="./picture/'.$logo.'" alt="profil_picture">
                </a>
            </div>';
        ?>
    </div>
    <nav id="nav_main">
        <ul>
            <li><a  href="home.php">Home</a></li>
            <li><a  href="tournaments.php">Turniere</a></li>
            <li><a  href="feedback.php">Feedback</a></li>
            <li><a  href="blog.php">Blog</a></li>
            <li><span>Mehr</span>
                <ul class="nav_sub">
                    <li class="nav_sub"><a  href="impressum.php">Impressum</a></li>
                    <li class="nav_sub"><a  href="picture_gallery.php">Bilder</a></li>
                    <li class="nav_sub"><a  href="logout.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <a href="javascript:void(0);" class="icon" onclick="nav(this)">
        <div class="bar1"></div>
        <div class="bar2"></div>
        <div class="bar3"></div>
    </a>
</div>
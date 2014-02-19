<div id="headerWrapper">
    <div id="header">
        <div id="logo"><a href="<?= $config[site][url] ?>"><img src="templates/<?= $config[site][template] ?>/images/logo.jpg" alt="" width="210" height="117" /></a></div>
        <?
        if ($_SESSION[loggedin] == 1) {
            echo '<div id="tagline">Welcome ' . ucwords($_SESSION[username]) . '&nbsp;&nbsp<a href="?p=logout">[Logout]</a></div>';
        } else {
            echo '<div id="tagline"><a href="?p=login">Click here to Login</a></div>';
        }
        ?>
        <div id="nav">
            <ul>
                <!-- To make the current page menu item highlighted, use the id="active" for the current page -->
                <li<?
                if (!$_GET[p]) {
                    echo ' id="active"';
                }
                ?>><a href="<?= $config[site][url] ?>">Top</a></li>
                    <?
                    if ($_SESSION[active] == 1) {
                        echo '<li ';
                        if ($_GET[p] == 'desktop') {
                            echo 'id="active"';
                        }
                        echo '><a href="?p=desktop">My Desktop</a></li>';
                    }
                    ?>
                <li<?
                if ($_GET[p] == 'news') {
                    echo ' id="active"';
                }
                ?>><a href="?p=news">News</a></li>
                <li<?
                if ($_GET[p] == 'faq') {
                    echo ' id="active"';
                }
                ?>><a href="?p=faq">FAQ</a></li>
                <li<?
                if ($_GET[p] == 'about') {
                    echo ' id="active"';
                }
                ?>><a href="?p=about">About</a></li>
                <li<?
                if ($_GET[p] == 'contact') {
                    echo ' id="active"';
                }
                ?>><a href="?p=contact">Contact</a></li>
                <li<?
                if ($_GET[p] == 'stores') {
                    echo ' id="active"';
                }
                ?>><a href="?p=stores">Stores</a></li>
            </ul>
        </div>
    </div>
</div>
<?
if ($_GET[p]) {
    echo '<div id="featureWrapper" class="class3">';
} else {
    echo '<div id="featureWrapper" class="class2">';
}
?>
<div id="feature"> <img src="templates/<?= $config[site][template] ?>/images/feature-product2.jpg" alt="Initial Banner" width="534" height="233" usemap="#Map" style="float: right;"/>
    <map name="Map" id="Map">
        <area shape="rect" coords="425,163,533,240" href="?p=login" alt="Get Started!" />
    </map>
    <p class="feature-title">Swap Old Stuff for New Stuff!</p>
    <p class="feature-text">Trade in your old games, electronics, books, clothes and more for something you really want.</p>
    <ol>
        <li>Make a list of items you have that you no longer want</li>
        <li>Search for things you want or are looking for</li>
        <li>Contact other users and offer to trade or buy their stuff</li>
        <li>Arrange a location and time and swap it!</li>
    </ol>
</div>

<div id="outerWrapper">
    <div id="contentWrapper">
        <div id="leftColumn1">
            <div id="leftColumnContent"> <strong>Main Menu</strong>
                <ul>
                    <li><a href="<?= $config[site][url] ?>">Home</a></li>
                    <li><a href="?p=browse&pageID=1">Browse All</a></li>
                    <?
                    if (!$_SESSION[loggedin]) {
                        echo '<li><a href="?p=login">Login</a> </li>';
                    } else {
                        echo '<li><a href="?p=desktop">My Desktop</a></li>';
                    }
                    ?>
                    <li><a href="?p=news">News</a></li>
                    <li><a href="?p=search">Search</a></li>
                    <li>
                        <?
                        if ($_GET[cat]) {
                            echo '<a href="rss.php?cat=' . input_filter(INPUT_GET, 'cat') . '">RSS</a>';
                        } else {
                            echo '<a href="rss.php">RSS</a>';
                        }
                        ?>
                    </li>
                    <?
                    if (!$_SESSION[access]) {
                        echo '<li><a href="?p=register">Register</a></li>';
                    }
                    ?>
                    <?
                    if (isset($_SESSION[active]) && $_SESSION[active] == 0) {
                        echo '<li><a href="?p=confirm">Confirm your Account</a></li>';
                    }
                    ?>
                    <?
                    if ($_SESSION[access] == 100) {
                        echo '<li><a href="?p=admin">Site Admin</a></li>';
                    }
                    ?>
                    <?
                    if ($_SESSION[loggedin]) {
                        echo '<li><a href="?p=logout">Log Out</a> </li>';
                    }
                    ?>
                </ul>
                <? if ($_GET[p]) { ?>
                    <!-- Sidebar Search Box -->
                    <div class="sidebarbox">
                        <div class="sidebarboxtop">
                            <p>Search:</p>
                            <p><form id="search" name="search" method="post" action="?p=search">
                                <input type="text" name="keyword" />&nbsp;<input type="submit" value="Find It" />
                            </form>
                        </div>
                        <div class="sidebarboxbottom"></div>
                    </div>
                    <!-- End Sidebar Search -->
                <? } ?>
                <? if (!$_SESSION[loggedin]) { // Only display ads to guests  ?>
                    <!-- Google AdSense -->
                    <script type="text/javascript">
                        <!--
                        google_ad_client = "pub-3241540974826144";
                        /* Okinawa Swap 160x600 */
                        google_ad_slot = "8524004201";
                        google_ad_width = 160;
                        google_ad_height = 600;
    //-->
                    </script>
                    <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
                    <!-- End Google AdSense -->
                <? } ?>
                <div class="sidebarbox">
                    <div class="sidebarboxtop">
                        <p><strong>Featured Categories</strong></p>
                        <p>&nbsp;</p>
                        <a href="?p=browse&cat=15&pageID=1">Used Cars</a><br />
                        <a href="?p=browse&cat=free&pageID=1">Free Stuff</a><br />

                    </div>
                    <div class="sidebarboxbottom"></div>
                </div>
                <? if ($_SESSION[loggedin]) { ?>
                    <p class="sidebardk"><strong>Statistics</strong><br />
                        <br />
                        My Feedback Score: <a href="?p=my_feedback"><?= $feedback->get_feedback_num($_SESSION[id]) ?></a><br />
                        I have <?= $items->get_my_item_count() ?> items to Swap<br />
                        I have <?= $items->count_my_wanted($_SESSION[id]) ?> wanted items<br />
                        Registered Users: <?= $users->total_users() ?><br />
                        Items Available: <?= $items->count_available() ?><br />
                        <br />
                    </p>
                <? } else { ?>
                    <p class="sidebardk"><strong>Site Statistics</strong><br />
                        <br />
                        Registered Users: <?= $users->total_users() ?><br />
                        Items Available: <?= $items->count_available() ?><br />
                        <br />
                    </p>
                <? } ?>
                <p class="sidebarlt"><strong>Other Websites</strong><br />
                    <br />
                    <a href="http://www.init.sh" target="_blank" >init.sh</a><br />
                    <a href="http://www.owh.net" target="_blank">Owh Links</a><br />
                    <a href="http://www.touchmi.jp" target="_blank">TouchMi</a><br />
                    <br />
                </p>

            </div>
        </div>
        <!-- End Header -->
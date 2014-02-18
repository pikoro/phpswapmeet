<?php
//$currentTimeoutInSecs = ini_get(’session.gc_maxlifetime’);
// Change the session timeout value to 30 minutes
//ini_set(’session.gc_maxlifetime’, 60*60);
session_start();
//$currentTimeoutInSecs = ini_get(’session.gc_maxlifetime’);
require('includes/config.php');
require('includes/functions.php');
require('classes/listings.php');
require('classes/feedback.php');
require('classes/items.php');
require('classes/users.php');
require('classes/swap.php');
require('classes/news.php');
require('classes/messages.php');
require('classes/log.php');
include_once("fckeditor/fckeditor.php");

// Check if someone is accessing a subdomain and redirect to their store if so:
$domain = explode('.', filter_input(INPUT_SERVER, 'HTTP_HOST'));
if ($domain[0] != 'www') {
    /* @var $domain string */
    switch ($domain[0]) {
        case 'usedcars':
            header('Location: ' . $config[site][url] . '/?p=browse&cat=15&pageID=1');
            break;
        case 'okitrader':
            header('Location: ' . $config[site][url]);
            break;
        default:
            header('Location: ' . $config[site][url] . '/?p=store&name=' . $domain[0]);
            break;
    }
}

$feedback = new feedback();
$listings = new listings();
$items = new items();
$users = new user();
$swap = new swap();
$log = new logger();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="robots" content="index,follow"/>
        <meta name="Keywords" content="<?= $config[site][keywords] ?>"/>
        <meta name="Description" content="<?= $config[site][tagline] ?>"/>
        <meta name="Author" content="Aaron Anderson"/>
        <meta name="Copyright" content="2009"/>

        <!-- <link type="text/css" rel="stylesheet" title="Default" href="templates/<?= $config[site][template] ?>/screen.css" media="screen" />
        <link type="text/css" rel="stylesheet" title="Mobile" href="templates/<?= $config[site][template] ?>/handheld.css" media="handheld" />
        -->
        <link rel='stylesheet' media='screen and (min-width: 1081px)' href='templates/<?= $config[site][template] ?>/screen.css' />
        <link rel='stylesheet' media='screen and (min-width: 300px) and (max-width: 1080px)' href='templates/<?= $config[site][template] ?>/handheld.css' />
        
        <title><?= $config[site][name] ?></title>
        <?php
        if (filter_input(INPUT_GET, 'cat', FILTER_VALIDATE_INT)) {
            $cat = filter_input(INPUT_GET, 'cat', FILTER_VALIDATE_INT);
            echo '<link rel="alternate" type="application/rss+xml" title="RSS - ' . $config[site][name] . '" href="' . $config[site][url] . '/rss.php?cat=' . $cat . '">';
        } else {
            echo '<link rel="alternate" type="application/rss+xml" title="RSS - ' . $config[site][name] . '" href="' . $config[site][url] . '/rss.php">';
        }
        ?>

    </head>

    <body>
        <div id="construction" 
        <? if ($config[site][debug] == 1) {
            echo 'style="display:block"';
        } ?>
             >Thank you for expressing your interest in <?= $config[site][name] ?>.  This site is still in beta.  We expect the site to be live on <?= $config[site][livedate] ?>.<br/>
            For Information about this site, send an email to <a href="mailto:<?= $config[site][contact] ?>?subject=Question%20about%20<?= $config[site][short_name_enc] ?>"><?= $config[site][contact] ?></a> Current Timeout in Seconds: <?= $currentTimeoutInSecs; ?></div>
            <? include('templates/' . $config[site][template] . '/header.php'); ?>
        <!-- Begin Content -->
        <div id="content">
            <?
            if (filter_input(INPUT_GET,'p')) {
                if (!is_file('templates/' . $config[site][template] . '/' . filter_input(INPUT_GET,'p') . '.php')) {
                    echo '<h2>We\'re Sorry, the page you are trying to access does not exist.</h2></div>';
                } else {
                    include('templates/' . $config[site][template] . '/' . filter_input(INPUT_GET,'p') . '.php');
                }
            } else {
                include('templates/' . $config[site][template] . '/main.php');
            }
            ?>

        </div>
        <!-- End Content -->
<? include('templates/' . $config[site][template] . '/footer.php'); ?>
        <!-- End Container -->
    </body>
</html>

<?php
// start a session for session variables and set the time zone for specials and stats
session_start();
date_default_timezone_set('America/Thunder_Bay');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link href="styles.css" type="text/css" rel="stylesheet" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Just the Menu Plz 3.29
    </title>
</head>

<body>
    <?php
    // Load the top navigation bar
    include "navigation.html";
    // And then standard html to set up the main panel border
    ?>
    <div style="background-color: white; margin-left: auto; margin-right: auto; padding: 10px; width: 98%;">
        <div style="border-color: black; border-style: solid; border-width: 1px; padding: 10px;">
            <a href="https://www.shaelina.com">
                <img height="90vw" src="favicon.ico" style="float: right;" width="90vw" class="zoomableright">
            </a>
            <h1>
                <a href="index.php">Welcome to JUSTTHEMENU.CA</a>
            </h1>
            <form method="GET" style="display: flex; width: 80%;">
                <input id="searchBox" name="search" placeholder="Search term" required="required"
                    style="flex-grow: 1; margin-right: 10px; font-size: xx-large;" title="Enter your search term(s)"
                    type="text" value="">
                <input id="searchButton" title="Click to search" type="submit" value="Search">
            </form>
            <div style="margin: 20px auto;">
                <?php
                include "eaterymanifest.php";
                // Load the relevant panel where all the content resides
                if (isset($_GET['id'])) {
                    if (isset($_GET['edit'])) {
                        include "editeatery.php";
                    } else {
                        include "eatery.php";
                    }
                } elseif (isset($_GET['search'])) {
                    include "search.php";
                } elseif (isset($_GET['stats'])) {
                    include "stats.php";
                } elseif (isset($_GET['specialsedit'])) {
                    include "editspecials.php";
                } elseif (isset($_GET['promotionsedit'])) {
                    include "editpromotions.php";
                } elseif (isset($_GET['sponsorsedit'])) {
                    include "editsponsors.php";
                } else {
                    include "panel.php";
                }
                // Load the code to record this visit
                include "statsappend.php";
                ?>
            </div>
        </div>
    </div>
</body>

</html>
<?php
// Find and display random sponsorship images with links
$folderDump = glob('sponsors/*.webp'); // dump of all the images
$sponsorURLs = array_map('basename', $folderDump); // strip out the paths
if (count($folderDump)) {
    echo "<div class = 'card' style = 'text-align: center'>";
    echo "<h2>Our Sponsors</h2>";
    $sponsor = $sponsorURLs[array_rand($sponsorURLs)];
    $sponsor = str_replace(".webp", "", $sponsor);
    echo "<a href='https://" . htmlspecialchars($sponsor) . "' target = '_blank'>";
    echo "<img src = 'sponsors/" . htmlspecialchars($sponsor) . ".webp' style = 'width: 90%; margin: 10px auto;'>";
    echo "</a>";
    echo "</div>";
}
?>
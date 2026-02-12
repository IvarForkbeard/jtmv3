<?php
// This code displays the eatery information
$eateryId = isset($_GET["id"]) ? trim($_GET["id"]) : '';// sanitise the id field
$eateryId = preg_replace('/[^a-zA-Z0-9\s]/', '', $eateryId);
$deprecated = false;
if (isset($_GET['deprecated'])) {
    $deprecated = true;
}
$name = $eateryId; // Failsafe name for display purposes
$jsonPath = "eateries/$eateryId/$eateryId.json"; // Load all the JSON into eateryData
if (file_exists($jsonPath)) {
    $rawData = file_get_contents($jsonPath);
    $eateryData = json_decode(preg_replace('/[\r\n]/', '', $rawData), true);
} else {
    $eateryData = null;
}
// Populate all the relevant variables starting with name
echo "<div class = 'eatery'>"; // Set eatery class for link transformations in CSS
if (isset($eateryData['name']) && !empty($eateryData['name'])) {
    $name = $eateryData['name'];
}
if (isset($eateryData['status'])) {
    $status = $eateryData['status'];
    switch ($status) {
        case "tc":
            $name = "<span class = 'statustc'>$name (Temporarily Closed)</span>";
            break;
        case "cs":
            $name = "<span class = 'statuscs'>$name (Coming Soon!)</span>";
            break;
        case "pc":
            $name = "<span class = 'statuspc'>$name (Permanently Closed!)</span>";
            break;
        case "nw":
            $name = "<span class = 'statusnw'>$name</span>";
            break;
    }
}
if (isset($eateryData['link'])) {
    $link = htmlspecialchars($eateryData['link']);
    $name = "<a href = '$link'>" . htmlspecialchars($name) . "</a>";
}
echo "<span style = 'font-size: 24pt'>" . $name . "</span>" . PHP_EOL;
echo "<div style = 'font-size: 18pt'>"; // reduce font size for rest of text
if (isset($eateryData['hours'])) {
    echo "Hours: " . htmlspecialchars($eateryData['hours']);
    echo "<br>" . PHP_EOL;
}
if (isset($eateryData['tel'])) {
    $link = htmlspecialchars($eateryData['tel']);
    echo "Telephone: <a href = 'tel:" . htmlspecialchars($link) . "'>";
    echo htmlspecialchars($eateryData['tel']);
    echo "</a>";
    echo "<br>" . PHP_EOL;
}
if (isset($eateryData['sms']) && !empty($eateryData['sms'])) {
    $link = $eateryData['sms'];
    echo "SMS: <a href = 'sms:" . htmlspecialchars($link) . "'>";
    echo htmlspecialchars($eateryData['sms']);
    echo "</a>";
    echo "<br>" . PHP_EOL;
}
if (isset($eateryData['address'])) {
    $address = $eateryData['address'];
    if (isset($eateryData['map'])) {
        $map = $eateryData['map'];
        echo "Address: <a href = '" . htmlspecialchars($map) . "'>";
        echo htmlspecialchars($eateryData['address']);
        echo "</a>";
        echo "<br>" . PHP_EOL;
    } else {
        echo "Address: " . htmlspecialchars($address);
        echo "<br>" . PHP_EOL;
    }
}
if (isset($eateryData['text'])) {
    echo "<details><summary>Text Menu</summary>";
    echo htmlspecialchars_decode(nl2br(htmlspecialchars($eateryData['text'])));
    echo "</details>" . PHP_EOL;
}
// Now insert any menu pictures
echo "<div class='image-card' style = 'display: flex; flex-wrap: wrap; justify-content: space-between; width: 100%'>";
$images = glob("eateries/$eateryId/*.webp");
foreach ($images as $image) {
    echo "<img src='" . htmlspecialchars($image) . "' alt='menu image' style = 'width: 45%; margin: 10px;'>" . PHP_EOL;
}
echo "</div>";
// Now add the citation
if (isset($eateryData['updated'])) {
    echo "<div style = 'text-align: right'>Updated: ";
    echo htmlspecialchars($eateryData['updated']);
    echo "</div>" . PHP_EOL;
}
if (isset($eateryData['courtesy'])) {
    echo "<div style = 'text-align: right'>Courtesy: ";
    echo htmlspecialchars($eateryData['courtesy']);
    echo "</div>" . PHP_EOL;
}
// Show deprecated pictures if set in URL
if ($deprecated) {
    echo "<div class='image-card' style = 'display: flex; flex-wrap: wrap; justify-content: space-between; width: 100%'>";
    $images = glob("eateries/$eateryId/deprecated/*.webp");
    foreach ($images as $image) {
        echo "<img src='" . htmlspecialchars($image) . "' alt='menu image' style = 'width: 45%; margin: 10px;'>" . PHP_EOL;
    }
    echo "</div>";
}
echo "</div></div>"; // Close the div for the eatery text
include "footer.php";
?>
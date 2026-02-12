<?php
// Show current images with boxes for treatment
echo "<br>";
echo "<label>Current Images:</label>";
echo "<hr>";
echo "<div class='image-card' style = 'display: flex; flex-wrap: wrap; justify-content: space-between; width: 100%'>";
$images = glob("eateries/$eateryId/*.webp");
foreach ($images as $image) {
    echo "<div style='width: 45%; text-align: center; margin: 10px; border-width: 2px; border-style: solid; padding: 10px'>";
    echo "<label><input type='checkbox' name='toDeprecate[]' value='" . basename(htmlspecialchars($image)) . "'> Deprecate</label>";
    echo "<img src='" . htmlspecialchars($image) . "' alt='menu image' style = 'width: 100%; margin: 10px;'>" . PHP_EOL;
    echo "</div>";
}
echo "</div>";
echo "<label>Deprecated Images:</label>";
echo "<hr>";
// Show deprecated images and give option to delete
echo "<div class='image-card' style = 'display: flex; flex-wrap: wrap; justify-content: space-between; width: 100%'>";
if (is_dir("eateries/$eateryId/deprecated/")) {
    $images = glob("eateries/$eateryId/deprecated/*.webp");
    foreach ($images as $image) {
        echo "<div style='width: 45%; text-align: center; margin: 10px; border-width: 2px; border-style: solid; padding: 10px'>";
        echo "<label><input type='checkbox' name='toDelete[]' value='" . basename(htmlspecialchars($image)) . "'> Delete</label>";
        echo "<img src='" . htmlspecialchars($image) . "' alt='menu image' style = 'width: 100%; margin: 10px;'>" . PHP_EOL;
        echo "</div>";
    }
}
echo "</div>";
echo "</div>";
?>
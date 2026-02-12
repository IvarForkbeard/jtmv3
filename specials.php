<?php
// Process specials and display them as cards
function isOpen($day)
{
    if (strtolower($day) == strtolower(date(format: "l"))) {
        return " open";
    } else {
        return "";
    }
}
// First the special case of "dailyspecials.json"
$file = "specials/dailyspecials.json";
if (file_exists($file)) {
    $rawData = file_get_contents($file);
    $specialsManifest = json_decode(preg_replace('/[\r\n]/', '', $rawData), true);
    echo "<div class = 'card'>";
    echo "<h2>Daily Specials</h2>";
    $days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    foreach ($days as $day) {
        echo "<details" . isOpen($day) . "><summary>" . $day . "</summary><div class = 'card'>";
        foreach ($specialsManifest[strtolower($day)] as $special) {
            $status = "";
            if (isset($eateryManifest[$special["id"]]["status"])) {
                $status = $eateryManifest[$special["id"]]["status"];
            }
            if ($status != "tc" && $status != "pc") {
                echo "<div class = 'card'>";
                echo "<details>";
                echo "<summary>" . htmlspecialchars($special['title']);
                echo "</summary>";
                echo htmlspecialchars($special['description']);
                echo "</details>";
                echo "<span style = 'display: block; text-align: right; margin-right: 10px'><a href = 'index.php?id=" . $special["id"] . "'> @ ";
                echo htmlspecialchars($eateryManifest[$special["id"]]["name"]) . "</a></span></div>";
            }
        }
        echo "</div></details>";
    }
    echo "</div>";
}
// Now display promotions if there are any
$file = "specials/promotions.json";
if (file_exists($file)) {
    $rawData = file_get_contents($file);
    $promotionsManifest = json_decode(preg_replace('/[\r\n]/', '', $rawData), true);
    echo "<div class = 'card'>";
    echo "<h2>Promotions</h2>";
    $promotions = array_keys($promotionsManifest);
    foreach ($promotions as $promotionId) {
        echo "<details open><summary>" . htmlspecialchars($promotionId) . "</summary><div class = 'card'>";
        foreach ($promotionsManifest[$promotionId] as $special) {
            echo "<div class = 'card'>";
            echo "<details>";
            echo "<summary>" . htmlspecialchars($special['title']);
            echo "</summary>";
            echo htmlspecialchars($special['description']);
            echo "</details>";
            echo "<span style = 'display: block; text-align: right; margin-right: 10px;'><a href = 'index.php?id=" . $special["id"] . "'> @ ";
            echo htmlspecialchars($eateryManifest[$special["id"]]["name"]) . "</a></span></div>";
        }
        echo "</div></details>";
    }
    echo "</div>";
}
?>
<div class="ubercard">
    <?php
    // First create cards of "cards"
    $letterCards = [
        'AB' => ['a', 'b'],
        'CD' => ['c', 'd'],
        'EF' => ['e', 'f'],
        'GH' => ['g', 'h'],
        'IJ' => ['i', 'j'],
        'KL' => ['k', 'l'],
        'MN' => ['m', 'n'],
        'OP' => ['o', 'p'],
        'QR' => ['q', 'r'],
        'ST' => ['s', 't'],
        'UV' => ['u', 'v'],
        'WX' => ['w', 'x'],
        'YZ' => ['y', 'z'],
        '09' => ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9']
    ];
    // Specials card(s) goes here.
    if (file_exists("specials.php")) {
        include "specials.php";
    }
    // Sponsors card(s) goes here.
    if (file_exists("sponsors.php")) {
        include "sponsors.php";
    }
    // Now to iterate through this array to create and populate the letter cards.
    foreach ($letterCards as $card => $letters) {
        echo "<div id='$card' class ='card'>" . PHP_EOL;
        echo "<h2>$card</h2>" . PHP_EOL;
        echo "<ul>";
        // Now to check every entry in the $eateryManifest to see if it belongs on this card
        foreach (array_keys($eateryManifest) as $eateryId) {
            $eateryData = $eateryManifest[$eateryId];
            if (in_array($eateryId[0], $letters)) {
                $displayText = $eateryId; // Just populate the display with the eateryId as default.
                if (!isset($eateryData['status'])) {
                    $eateryData['status'] = ""; // Set a default status no matter what.
                }
                if (isset($eateryData['name'])) {
                    $name = $eateryData['name'];
                    $displayText = "<a href = 'index.php?id=" . htmlspecialchars($eateryId) . "'>" . htmlspecialchars($name); // Set the display to the eatery name.
                }
                switch ($eateryData['status']) {
                    case 'tc': // Strikethrough if temporarily closed.
                        $displayText = "<span class = 'statustc'>$displayText</span> (Temporarily Closed)";
                        break;
                    case 'cs': // Thin text if coming soon.
                        $displayText = "<span class = 'statuscs'>$displayText</span> (Coming
                             Soon!)";
                        break;
                    case 'nw': // Blink if new.  (class details in CSS)
                        $displayText = "<span class = 'blink'>$displayText</span> (New!)";
                        break;
                }
                if ($eateryData['status'] != "pc") { // If it's not permanently closed, then show it.
                    echo "<li class = 'zoomablelight'>$displayText</a></li>" . PHP_EOL;
                }
            }
        }
        echo "</ul>";
        echo "</div>";
    }
    include "footer.php";
    ?>
</div>
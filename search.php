<div class="panel">
    <?php
    // This is the search panel
    $searchTerm = isset($_GET["search"]) ? trim($_GET["search"]) : ''; // sanitise the search field
    $searchTerm = preg_replace('/[^a-zA-Z0-9\s]/', '', $searchTerm);
    $searchResults = [];
    foreach ($eateryManifest as $eatery) {
        if (is_array($eatery) && (!isset($eatery["status"]) || $eatery["status"] !== "pc")) {
            foreach ($eatery as $data) {
                $position = stripos($data, $searchTerm);
                if ($position !== false) {
                    $searchResults[] = $eatery;
                    break;
                }
            }
        }
    }
    shuffle($searchResults);
    foreach ($searchResults as $searchHit) {
        if (isset($searchHit['name'])) {
            $class = "class = 'card'";
            $isclosed = false;
            if (isset($searchHit['status'])) {
                if ($searchHit['status'] == "tc") {
                    $isclosed = true;
                    $class = "class = 'card temporarily-closed'";
                }
            }
            echo "<div $class>";
            if ($isclosed) {
                echo "<s>";
            }
            echo "<a href = 'index.php?id=" . htmlspecialchars($searchHit['id']) . "'>" . htmlspecialchars($searchHit['name']) . "</a>";
            if ($isclosed) {
                echo " (Temporarily Closed)</s>";
            }
            foreach ($searchHit as $key => $data) {
                $data = strip_tags($data); // sanitise the data from html tags or else things break
                $position = stripos($data, $searchTerm);
                if ($position !== false) {
                    $startHighlight = max(0, $position - 128);
                    $lengthHighlight = strlen($searchTerm) + 256;
                    $highlight = str_ireplace($searchTerm, "<b class = 'blink'>" . htmlspecialchars($searchTerm) . "</b>", substr($data, $startHighlight, $lengthHighlight));
                    echo "<div>$highlight</div>" . PHP_EOL;
                }
            }
            echo "</div>";
        }
    }
    include "footer.php";
    ?>
</div>
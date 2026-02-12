<?php
// load in all the stats.csv data to an array called $statsData
$statsData = [];
if (($filePointer = fopen('stats.csv', 'r')) !== false) {
    while (($statsLine = fgetcsv($filePointer, 1000, ',', '"', 3)) !== false) {
        $statsData[] = $statsLine;
    }
    fclose($filePointer);
}
echo "<div class = 'ubercard'>";

// count up the hits per year
$yearHits = [];
foreach ($statsData as $statsDataRow) {
    $year = substr($statsDataRow[0], 0, 4);
    if (strlen($year > 3)) {
        if (isset($yearHits[$year])) {
            $yearHits[$year]++;
        } else {
            $yearHits[$year] = 1;
        }
    }
}
krsort($yearHits, SORT_NUMERIC);
echo "<div class ='card'>" . PHP_EOL;
echo "<h2>Year</h2>" . PHP_EOL;
foreach ($yearHits as $year => $hits) {
    echo "<table style = 'width:100%'><tr><td>$year</td><td style = 'text-align:right'>$hits Hits</td></tr></table>" . PHP_EOL;
}
// count up the hits per month of the current year
$monthHits = [];
$currentDate = date('Y');
foreach ($statsData as $statsDataRow) {
    $date = $statsDataRow[0];
    if (substr($date, 0, 4) == $currentDate) {
        $month = substr($date, 5, 2);
        if (isset($monthHits[$month])) {
            $monthHits[$month]++;
        } else {
            $monthHits[$month] = 1;
        }
    }
}
krsort($monthHits, SORT_NUMERIC);
echo "</div>";
echo "<div class ='card'>" . PHP_EOL;
echo "<h2>Month ($currentDate)</h2>" . PHP_EOL;
foreach ($monthHits as $month => $hits) {
    echo "<table style = 'width:100%'><tr><td>$month</td><td style = 'text-align:right'>$hits Hits</td></tr></table>" . PHP_EOL;
}
// count up the hits per day of the current month
$dayHits = [];
$currentDate = date('Y-m');
foreach ($statsData as $statsDataRow) {
    $date = $statsDataRow[0];
    if (substr($date, 0, 7) == $currentDate) {
        $day = substr($date, 8, 2);
        if (isset($dayHits[$day])) {
            $dayHits[$day]++;
        } else {
            $dayHits[$day] = 1;
        }
    }
}
krsort($dayHits, SORT_NUMERIC);
echo "</div>";
echo "<div class ='card'>" . PHP_EOL;
echo "<h2>Day ($currentDate)</h2>" . PHP_EOL;
foreach ($dayHits as $day => $hits) {
    echo "<table style = 'width:100%'><tr><td>$day</td><td style = 'text-align:right'>$hits Hits</td></tr></table>" . PHP_EOL;
}

// count up the hits per referral of the current month
$referrerHits = [];
$currentDate = date('Y-m');
foreach ($statsData as $statsDataRow) {
    if (strpos($statsDataRow[0], $currentDate) === 0) {
        if (isset($statsDataRow[2])) {
            $referrer = $statsDataRow[2];
            if (strpos($referrer, 'justthemenu.ca') === false && strpos($referrer, 'localhost') === false && strpos($referrer, 'NULL') === false) {
                if (isset($referrerHits[$referrer])) {
                    $referrerHits[$referrer]++;
                } else {
                    $referrerHits[$referrer] = 1;
                }
            }
        }
    }
}
arsort($referrerHits, SORT_NUMERIC);
echo "</div>";
echo "<div class = 'card'>" . PHP_EOL;
echo "<h2>Referrers ($currentDate)</h2>";
foreach ($referrerHits as $referrer => $hits) {
    echo "<table style = 'width:100%'><tr><td>" . htmlspecialchars($referrer) . "</td><td style = 'text-align:right'><span style='white-space:nowrap;'>$hits Hits</span></td></tr></table>" . PHP_EOL;
}
// count up the hits per platform of the current month
$platformHits = [];
$currentDate = date('Y-m');
foreach ($statsData as $statsDataRow) {
    if (strpos($statsDataRow[0], $currentDate) === 0) {
        if (isset($statsDataRow[3])) {
            $currentUserAgent = $statsDataRow[3];
        } else {
            $currentUserAgent = "NULL";
        }
        if (strpos($currentUserAgent, 'Mobile') !== false || strpos($currentUserAgent, 'Android') !== false || strpos($currentUserAgent, 'iPhone') !== false) {
            $platform = 'Mobile';
        } else {
            $platform = 'Desktop';
        }

        if (isset($platformHits[$platform])) {
            $platformHits[$platform]++;
        } else {
            $platformHits[$platform] = 1;
        }
    }
}
echo "</div>";
echo "<div class = 'card'>" . PHP_EOL;
echo "<h2>Platforms ($currentDate)</h2>";
foreach ($platformHits as $platform => $hits) {
    echo "<table style = 'width:100%'><tr><td>$platform</td><td style = 'text-align:right'><span style='white-space:nowrap;'>$hits Hits</span></td></tr></table>" . PHP_EOL;
}
// count up the hits per eatery of the current month
$eateryHits = [];
$currentDate = date('Y-m-d');
foreach ($statsData as $statsDataRow) {
    if (strpos($statsDataRow[0], $currentDate) === 0) {
        if (strpos($statsDataRow[1], '?id=') !== false) {
            preg_match('/\?id=([^&]+)/', $statsDataRow[1], $match);
            if (isset($match[1])) {
                $eatery = $match[1];
            } else {
                $eatery = "index";
            }
        } elseif (strpos($statsDataRow[1], '?search') !== false) {
            $eatery = "search";
        } elseif (strpos($statsDataRow[1], '?stats') !== false) {
            $eatery = "stats";
        } else {
            $eatery = "index";
        }
        if ($eatery == 'search' || $eatery == 'stats' || $eatery == 'index' || in_array($eatery, $eateryIds)) {
            if (isset($eateryHits[$eatery])) {
                $eateryHits[$eatery]++;
            } else {
                $eateryHits[$eatery] = 1;
            }
        }
    }
}
arsort($eateryHits, SORT_NUMERIC);
echo "</div>";
echo "<div class ='card'>" . PHP_EOL;
echo "<h2>Eateries ($currentDate)</h2>" . PHP_EOL;
foreach ($eateryHits as $eatery => $hits) {
    echo "<table style = 'width:100%'><tr><td>" . htmlspecialchars($eatery) . "</td><td style = 'text-align:right'><span style='white-space:nowrap;'>$hits Hits</span></td></tr></table>" . PHP_EOL;
}
echo "</div>";
// write out the total visitor count
file_put_contents('visitorcount.txt', count($statsData) . "\n", LOCK_EX);
// show the footer
include "footer.php";
echo "</div>";
?>
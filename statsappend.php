<?php
// get the date
$currentDate = date('Y-m-d_H-i-s');
// get the current page
$currentURL = "//";
if (isset($_SERVER['HTTP_HOST'])) {
    $currentURL .= $_SERVER['HTTP_HOST'];
}
// get the current parameters passed to the domain (to create a full URL)
if (isset($_SERVER['REQUEST_URI'])) {
    $currentURL .= $_SERVER['REQUEST_URI'];
}
// get the referring page
$currentReferrer = "NULL";
if (isset($_SERVER['HTTP_REFERER'])) {
    $currentReferrer = $_SERVER['HTTP_REFERER'];
}
// get the user agent string
$currentUserAgent = "NULL";
if (isset($_SERVER['HTTP_USER_AGENT'])) {
    $currentUserAgent = $_SERVER['HTTP_USER_AGENT'];
}
//concatenate the entry
$logLine = "$currentDate, $currentURL, $currentReferrer, $currentUserAgent";
// write a new line to the stats.csv file
file_put_contents('stats.csv', $logLine . "\n", FILE_APPEND | LOCK_EX);
// backup the stats.csv file
$currentDate = date('Y-m-d');
$backupPath = 'statsbackups/' . $currentDate . '.csv';
if (!file_exists($backupPath)) {
    copy('stats.csv', $backupPath);
}
?>
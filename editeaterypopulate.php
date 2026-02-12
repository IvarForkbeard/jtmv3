<?php
// This populates the eatery information with defaults
$eateryId = isset($_GET["id"]) ? trim($_GET["id"]) : '';// sanitise the id field
$eateryId = preg_replace('/[^a-zA-Z0-9\s]/', '', $eateryId);
$name = $eateryId; // Failsafe data for display purposes
$status = '';
$link = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$hours = '(Sunday - Saturday: 00:00 - 12:00)';
$tel = '807-555-1212';
$sms = '807-555-1212';
$address = '123 Fake Street';
$map = '';
$text = '';
$courtesy = 'Justin Menu';
$updated = date('Y - m - d');
$jsonPath = "eateries/$eateryId/$eateryId.json";
if (file_exists($jsonPath)) {
    $rawData = file_get_contents($jsonPath);
    $eateryData = json_decode(preg_replace('/[\r\n]/', '', $rawData), true);
} else {
    $eateryData = null;
}
// Populate all the relevant variables starting with name
if (isset($eateryData['name']) && !empty($eateryData['name'])) {
    $name = $eateryData['name'];
}
if (isset($eateryData['status'])) {
    $status = $eateryData['status'];
}
if (isset($eateryData['link'])) {
    $link = $eateryData['link'];
}
if (isset($eateryData['hours'])) {
    $hours = $eateryData['hours'];
}
if (isset($eateryData['tel'])) {
    $tel = $eateryData['tel'];
}
if (isset($eateryData['sms'])) {
    $sms = $eateryData['sms'];
}
if (isset($eateryData['address'])) {
    $address = $eateryData['address'];
}
if (isset($eateryData['map'])) {
    $map = $eateryData['map'];
}
if (isset($eateryData['text'])) {
    $text = $eateryData['text'];
}
if (isset($eateryData['updated'])) {
    $updated = $eateryData['updated'];
}
if (isset($eateryData['courtesy'])) {
    $courtesy = $eateryData['courtesy'];
}
?>
<?php
// Here begins the loading of the data from the eateries/ folder.
$folderDump = glob('eateries/*', GLOB_ONLYDIR); // dump of all the eateries
$eateryIds = array_map('basename', $folderDump); // strip out the paths
$eateryManifest = [];
foreach ($eateryIds as $id) { // iterate through and create new array with id as key, and data as
    // value
    $jsonPath = "eateries/$id/$id.json";
    if (file_exists($jsonPath)) {
        $rawData = file_get_contents($jsonPath);
        $data = json_decode(preg_replace('/[\r\n]/', '', $rawData), true);
        $data['id'] = $id;
    } else {
        $data = null;
    }
    $eateryManifest[$id] = $data; // write back into the eateryManifest any .JSON data
}
?>
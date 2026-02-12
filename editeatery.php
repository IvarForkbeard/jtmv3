<?php
// Ensure eateryID is defined before anything, just in case this is a write cycle
$eateryId = isset($_GET["id"]) ? trim($_GET["id"]) : '';// sanitise the id field
$eateryId = preg_replace('/[^a-zA-Z0-9\s]/', '', $eateryId);
// Write out the new data if verification is passed and new data is present
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include('editeaterypost.php');
}
include('editeaterypopulate.php');
?>
<form method="POST" style="width: 80%;" enctype="multipart/form-data">
    <label>Name:</label>
    <input id="name" name="name" placeholder="Eatery Name" required="required" class="edit" title="Eatery Name"
        type="text" value="<?= $name ?>">
    <label>Status:</label>
    <input id="status" name="status" placeholder="Eatery Status" class="edit" title="Eatery Status" type="text"
        value="<?= $status ?>">
    <label>Link:</label>
    <input id="link" name="link" placeholder="Eatery Link" class="edit" title="Eatery Link" type="url"
        value="<?= $link ?>">
    <label>Hours:</label>
    <input id="hours" name="hours" placeholder="Eatery Hours" class="edit" title="Eatery Hours" type="text"
        value="<?= $hours ?>">
    <label>Tel:</label>
    <input id="tel" name="tel" placeholder="Eatery Telephone" class="edit" title="Eatery Telephone" type="tel"
        value="<?= $tel ?>">
    <label>SMS:</label>
    <input id="sms" name="sms" placeholder="Eatery SMS" class="edit" title="Eatery SMS" type="tel" value="<?= $sms ?>">
    <label> Address:</label>
    <input id="address" name="address" placeholder="Eatery Address" class="edit" title="Eatery Hours" type="text"
        value="<?= $address ?>">
    <label>Map Link:</label>
    <input id="map" name="map" placeholder="Eatery Map Link" class="edit" title="Eatery Map Link" type="url"
        value="<?= $map ?>">
    <label> Text:</label>
    <textarea id="text" name="text" placeholder="Eatery Menu Text" class="edit" title="Eatery Menu Text" type="text"
        rows="16"><?= str_replace(['<br>', '<br/>', '<br />'], "\n", $text) ?></textarea>
    <label>Updated:</label>
    <input id="updated" name="updated" placeholder="Eatery Updated" class="edit" title="Eatery Updated" type="date"
        value="<?= $updated ?>">
    <label> Courtesy:</label>
    <input id="courtesy" name="courtesy" placeholder="Eatery Courtesy" class="edit" title="Eatery Courtesy" type="text"
        value="<?= $courtesy ?>">
    <label> Verification Code:</label>
    <input id="verification" name="verification" placeholder="Code" class="edit" title="Verification Code" type="text">
    <input id="update" title="Click to update" type="submit" value="Update">
    <br><br>
    <label> Upload New Images:</label>
    <input id="images" name="images[]" class="edit" type="file" accept=".webp" multiple>
    <?php
    include('editeaterydisplayimages.php');
    ?>
</form>
<?php
// Check the verification first
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userVerification = $_POST['verification'];
    include "passwordverification.php";
    if (verified($userVerification)) {
        $specialsManifest = $_POST['specials'];
        // redact empty entries
        foreach ($specialsManifest as $day => $specials) {
            foreach ($specials as $index => $entry) {
                if (empty($entry['id'])) {
                    unset($specialsManifest[$day][$index]);
                }
            }
        }
        $json = json_encode($specialsManifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $check = file_put_contents("specials/dailyspecials.json", $json, LOCK_EX);
        if (!$check) {
            echo "Something went amiss, please try again";
        }
    }
}
// Now display the form in a usable form
$file = "specials/dailyspecials.json";
if (file_exists($file)) {
    $rawData = file_get_contents($file);
    $specialsManifest = json_decode(preg_replace('/[\r\n]/', '', $rawData), true);
}
$days = ["sunday", "monday", "tuesday", "wednesday", "thursday", "friday", "saturday"];
foreach ($days as $day) {
    if (!isset($specialsManifest[$day])) {
        $specialsManifest[$day] = [];
    }
    $specialsManifest[$day][] = ['id' => '', 'title' => '', 'description' => ''];
}
?>
<form method="POST">
    <?php
    foreach ($days as $day) { ?>
        <details>
            <summary><?= ucfirst($day) ?></summary>
            <?php foreach ($specialsManifest[$day] as $index => $special) { ?>
                <div style="margin-bottom: 10px; padding: 10px; border: 2px solid; display: flex;">
                    <div style="width: 20%;">
                        <label>Title:<br></label>
                        <input type=" text" name="specials[<?= $day ?>][<?= $index ?>][title]"
                            value="<?= htmlspecialchars($special['title']) ?>" style="width: 100%;">
                    </div>
                    <div style="width: 50%;">
                        <label>Description:<br></label>
                        <textarea name="specials[<?= $day ?>][<?= $index ?>][description]"
                            style="width: 100%;"><?= htmlspecialchars($special['description']) ?></textarea>
                    </div>
                    <div style="width: 20%;">
                        <label>Eatery ID:<br></label>
                        <input type=" text" name="specials[<?= $day ?>][<?= $index ?>][id]"
                            value="<?= htmlspecialchars($special['id']) ?>" style="width: 100%;">
                    </div>
                </div>
            <?php } ?>
        </details>
    <?php } ?>
    <!-- This is to enter the verification code and submit -->
    <label> Verification Code:</label>
    <input class="edit" id="verification" name="verification" placeholder="Code" required title="Verification Code"
        type="text">
    <input id="update" title="Click to update" type="submit" value="Update">
</form>
<?php
$file = "specials/promotions.json";
$promotionsManifest = [];
// Process POST Request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userVerification = $_POST['verification'];
    include "passwordverification.php";
    if (verified($userVerification)) {
        if (isset($_POST['promotions'])) {
            $rawPromotions = $_POST['promotions'];
        } else {
            $rawPromotions = [];
        }
        $cleanedManifest = [];
        foreach ($rawPromotions as $item) {
            if (isset($item['promotionName'])) {
                $name = trim($item['promotionName']);
            } else {
                $name = '';
            }
            if (empty($name))
                continue;
            $entries = [];
            foreach ($item as $key => $entry) {
                // Skip the name field, look only at numeric entries
                if (is_numeric($key) && !empty($entry['id'])) {
                    $entries[] = [
                        'id' => trim($entry['id']),
                        'title' => trim($entry['title']),
                        'description' => trim($entry['description'])
                    ];
                }
            }
            if (!empty($entries)) {
                $cleanedManifest[$name] = $entries;
            }
        }
        $json = json_encode($cleanedManifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        if (!file_put_contents($file, $json, LOCK_EX)) {
            echo "Something went amiss, please try again.";
        } else {
            echo "Update successful.";
        }
    }
}
// Load Data for Display
if (file_exists($file)) {
    $rawData = file_get_contents($file);
    $promotionsManifest = json_decode($rawData, true) ?: [];
}
// Add blank entries for the UI
$promotionsManifest[''] = [['id' => '', 'title' => '', 'description' => '']];
foreach ($promotionsManifest as $name => $list) {
    if ($name !== '') {
        $promotionsManifest[$name][] = ['id' => '', 'title' => '', 'description' => ''];
    }
}
?>
<form method="POST">
    <?php
    $i = 0;
    foreach ($promotionsManifest as $promotionName => $entries) { ?>
        <details <?= empty($promotionName) ?>>
            <summary>
                <input type="text" name="promotions[<?= $i ?>][promotionName]"
                    value="<?= htmlspecialchars($promotionName) ?>" placeholder="New Promotion Name" style="width: 50%;">
            </summary>
            <?php foreach ($entries as $j => $entry) { ?>
                <div style="margin-bottom: 10px; padding: 10px; border: 1px solid; display: flex;">
                    <div style="width: 20%">
                        <label>Title:</label><br>
                        <input type="text" name="promotions[<?= $i ?>][<?= $j ?>][title]"
                            value="<?= htmlspecialchars($entry['title']) ?>" style="width: 100%;">
                    </div>
                    <div style="width: 50%">
                        <label>Description:</label><br>
                        <textarea name="promotions[<?= $i ?>][<?= $j ?>][description]"
                            style="width: 100%;"><?= htmlspecialchars($entry['description']) ?></textarea>
                    </div>
                    <div style="width: 20%;">
                        <label>Eatery ID:</label><br>
                        <input type="text" name="promotions[<?= $i ?>][<?= $j ?>][id]"
                            value="<?= htmlspecialchars($entry['id']) ?>" style="width: 100%;">
                    </div>
                </div>
            <?php } ?>
        </details>
        <?php $i++;
    } ?>
    <label>Verification Code:</label>
    <input name="verification" type="password" required>
    <input type="submit" value="Update Specials">
</form>
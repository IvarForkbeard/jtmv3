<?php
$userVerification = $_POST['verification'];
include 'passwordverification.php';
if (verified($userVerification)) {
    $eateryData = [
        'name' => $_POST['name'],
        'status' => $_POST['status'],
        'link' => $_POST['link'],
        'hours' => $_POST['hours'],
        'tel' => $_POST['tel'],
        'sms' => $_POST['sms'],
        'address' => $_POST['address'],
        'map' => $_POST['map'],
        'text' => preg_replace('/\R\R+/', "\n", $_POST['text']),
        'updated' => $_POST['updated'],
        'courtesy' => $_POST['courtesy']
    ];
    $json = json_encode($eateryData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    if (!is_dir("eateries/$eateryId")) {
        mkdir("eateries/$eateryId", 0777, true);
    }
    $check = file_put_contents("eateries/$eateryId/$eateryId.json", $json, LOCK_EX);
    if (!$check) {
        echo "Something went amiss, please try again";
    }
    // upload new images
    if (isset($_FILES['images'])) {
        foreach ($_FILES['images']['tmp_name'] as $temp => $temporaryName) {
            if ($_FILES['images']['error'][$temp] === UPLOAD_ERR_OK) {
                $fileName = "eateries/$eateryId/" . basename($_FILES['images']['name'][$temp]);
                if (!move_uploaded_file($temporaryName, $fileName)) {
                    echo "Error while uploading: " . htmlspecialchars($_FILES['images']['name'][$temp]);
                }
            }
        }
    }
    // deprecate flagged images
    if (isset($_POST['toDeprecate'])) {
        foreach ($_POST['toDeprecate'] as $image) {
            $oldFilePath = "eateries/$eateryId/$image";
            $newFilePath = "eateries/$eateryId/deprecated/$image";
            if (!is_dir("eateries/$eateryId/deprecated")) {
                mkdir("eateries/$eateryId/deprecated", 0777, true);
            }
            rename($oldFilePath, $newFilePath);
        }
    }
    // delete flagged images
    if (isset($_POST['toDelete'])) {
        foreach ($_POST['toDelete'] as $image) {
            unlink("eateries/$eateryId/deprecated/$image");
        }
    }
}
?>
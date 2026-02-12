<?php
// Check the verification first
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userVerification = $_POST['verification'];
    include 'passwordverification.php';
    if (verified($userVerification)) {
        // deprecate checked images
        if (isset($_POST['toDeprecate'])) {
            $toDeprecate = $_POST['toDeprecate'];
            foreach ($toDeprecate as $sponsor) {
                rename("sponsors/$sponsor", "sponsors/deprecated/$sponsor");
            }
        }
        // upload new images
        if (isset($_FILES['sponsor'])) {
            if ($_FILES['sponsor']['error'] === 0) {
                $sponsor = $_FILES['sponsor'];
                if (!move_uploaded_file($sponsor['tmp_name'], "sponsors/" . basename($sponsor['name']))) {
                    echo "Something went amiss, please try again";
                }
            }
        }
    }
}
?>
<form method="post" enctype="multipart/form-data">
    <div class='image-card' style='display: flex; flex-wrap: wrap; justify-content: space-between; width: 100%'>
        <?php
        // Show current images with boxes for treatment
        $images = glob("sponsors/*.webp");
        foreach ($images as $image) {
            echo "<div style='width: 45%; text-align: center; margin: 10px; border-width: 2px; border-style: solid; padding: 10px'>";
            echo "<label><input type='checkbox' name='toDeprecate[]' value='" . basename(htmlspecialchars($image)) . "'> Deprecate</label>";
            echo "<img src='" . htmlspecialchars($image) . "' alt='menu image' style = 'width: 100%; margin: 10px;'>" . PHP_EOL;
            echo "</div>";
        }
        ?>
    </div>
    <!-- upload an image -->
    <div>
        <label> Upload New Sponsor:</label>
        <input type="file" name="sponsor" accept=".webp">
    </div>
    <!-- This is to enter the verification code and submit -->
    <div>
        <label> Verification Code:</label>
        <input id="verification" name="verification" placeholder="Code" class="edit" title="Verification Code"
            type="text">
        <input id="update" title="Click to update" type="submit" value="Update">
    </div>
</form>
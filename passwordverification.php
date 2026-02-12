<?php
function verified($userVerification)
{
    if (is_file('.verification')) {
        $hash = trim(file_get_contents('.verification'));
        if (isset($_SESSION['previousCheck'])) {
            if (isset($_SESSION['coolOffPeriod'])) {
                $_SESSION['coolOffPeriod'] += 5;
            } else {
                $_SESSION['coolOffPeriod'] = 5;
            }
            $elapsedTime = time() - $_SESSION['previousCheck'];
            if ($elapsedTime < $_SESSION['coolOffPeriod']) {
                return false;
            }
        }
        $verified = password_verify($userVerification, $hash);
        if ($verified) {
            unset($_SESSION['previousCheck']);
            unset($_SESSION['coolOffPeriod']);
        } else {
            $_SESSION['previousCheck'] = time();
        }
    }
    return $verified;
}
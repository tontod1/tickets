<?php 

date_default_timezone_set('America/New_York');
require_once 'facebook/Facebook/autoload.php'; use Facebook\FacebookSession;
include 'facebook/helper.php';


function loggedIn() {

    if (!empty($_SESSION['loggedin']) && $_SESSION['loggedin']) {
        return true;
    }
    return false;
}

if (!loggedIn()) {
    $email = getEmailAddress();
    $fid = getId();
    if ((stripos($email, 'm_tonto@hotmail.com') !== false) ||
        (stripos($email, 'vcastagna@gmail.com') !== false) ||
        (stripos($email, 'chestnut7589@hotmail.com') !== false) ||
        (stripos($fid, '10156083651649717') !== false) ||
        (stripos($fid, '10156044755343928') !== false)) {
        
            $_SESSION['loggedin'] = true;
    }
} 

if (!loggedIn()) {
    
    die("You are not logged in. Email Address (" . getEmailAddress() . ") Or ID (". getId() .") is not recognized.");
}

//Baggio77!

?>
<?php 
session_start();
date_default_timezone_set('America/New_York');

include '../db.inc';
include '../session_helper.php';
include './helper_cal.php';

$action = "";
$eventId = "";

if (!empty($_GET['dynamic_action']) ) {
    $action = $_GET['dynamic_action'];
}


switch ($action) {
    case "add":
        if (save()) {
            die($_GET['dynamic_id']);
        }else {
            die("fail");
        }
        break;
    case "find":
        if (findById($_GET['dynamic_id'])) {
            die("success");
        }else {
            die("fail");
        }
        break;
    default:
        $t = time();
        
        include 'header.html';
        echo "<br /><div id='td-$t'><a id='$t' class='btb' ><img src='../images/calendar_icon.png' width='30' /></a></div><br />";
        echo "<div id='customBTBmessage'> </div>";
        include 'table_start.php';
        displayAll();
        include 'table_stop.php';
        include 'calendar.php';
        include 'footer.html';
}
    

?>

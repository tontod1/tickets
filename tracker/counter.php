<?php include 'pages/header.php';?>

<?php

ini_set('max_execution_time', 300);
include 'counterFunctions.php';
include '../db.inc';

//next example will recieve all messages for specific conversation
$eventId = '';


$sql = "select eventId, Description from event where endDate >= CURDATE()";
$result = mysqli_query($mysqli, $sql);

$dbEvents = [];
while($row = mysqli_fetch_assoc($result)) {
    array_push ($dbEvents, $row["eventId"]);
}

$shEvents = getMyListingIds();
$allEvents = array_unique( array_merge($dbEvents,$shEvents) );

foreach($allEvents as $eventId) {

    $json = getEventTotals($eventId);
    $low=$json->pricingSummary->minTicketPriceWithCurrency->amount;
    $high=$json->pricingSummary->maxTicketPriceWithCurrency->amount;
    $avg=$json->pricingSummary->averageTicketPriceWithCurrency->amount;
    $totalTickets=$json->totalTickets;
    
    $eventId=$json->eventId;
    $t = time();
    //$date = date('m/d/Y h:i a', time());
    
    
    
    $sql = "INSERT INTO events (EventId, availCount, costHigh, costLow, costAvg,created_timestamp) VALUES ('$eventId', '$totalTickets', '$high', '$low', '$avg', '$t')";
    if(mysqli_query($mysqli, $sql)){
    	echo "Records inserted successfully.";
    } else{
    	echo "ERROR: Could not able to execute $sql. " . mysqli_error($mysqli);
    }
}


mysqli_close($mysqli);
 
?>

 
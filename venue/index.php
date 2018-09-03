<?php 
session_start();
date_default_timezone_set('America/New_York');

include 'header.html';
include '../db.inc';
include 'client.php';
include '../calendar/helper_cal.php';

$sql1 = "select venue_name,venue_id from tm_venues";
$result = mysqli_query($mysqli, $sql1);

?>
<div id="topBanner_tm1" class="topBanner_1"><img src="images/ticketmaster_logo.svg" /><a href="../menu.php"><img src="../images/home.png" /></a></div>
<div id="topBanner_tm2" class="topBanner_2"></div>

<table id="example" class="display" cellspacing="0" width="100%">
<thead>
    <tr>
        <th>Venue</th>
        <th>Performer</th>
        <th>Presale Dates</th>
        <th>Public Sale Date</th> 
        <th>Concert Date</th>  
        <th>Price Range</th>
        <th>Save</th>
    </tr>
</thead>
<tfoot>
    <tr>
        <th>Venue</th>
        <th>Performer</th>
        <th>Presale Dates</th>
        <th>Public Sale Date</th>
        <th>Concert Date</th>                
        <th>Price Range</th>
        <th>Save</th>
    </tr>
</tfoot>
<tbody>
<?php
while($row = mysqli_fetch_assoc($result)) {
    //echo "MAT1";
           
            /* PHP SDK v5.0.0 */
            /* make the API call */
            
            

            $events = getEventForVenue ($row["venue_id"]);
            //var_dump($events);
            if (!isset($events['_embedded'])) continue;
            
            foreach ($events['_embedded']['events'] as $event) {

                

                if (stripos($event['name'], 'Tournament') === false ) {
                    //$btbStatus=isThisBitchBooked($event[id]);
                    
                    echo "<tr id='tr-$event[id]'>";
                    echo "<td class='venue'><a href='" . $event['seatmap']['staticUrl'] . "' class='venueUrl'>" . $row["venue_name"] . "</a></td>";
                    echo "<td class='performer'><a href='" . $event['url'] . "' class='performerUrl'> " . $event['name'] . "</a></td>";

                    
                    echo "<td id='pdate'>";
                        if (isset($event['sales']['presales'])) {
                            foreach ($event['sales']['presales'] as $ps) {
                                $time = strtotime( $ps['startDateTime'] );
                                echo "<p class='pre_date'>" . date('m/d/Y H:i', $time) . " / " . $ps ['name'] . "</p>";
                            }
                        } 
                    echo "</td>";
                    //  ['classifications']['segment']['name']
                    $public_time = strtotime( $event['sales']['public']['startDateTime'] );
                    echo "<td>" . date('m/d/Y H:i', $public_time)  . "</td>";
                    echo "<td>" . $event['dates']['start']['localDate'] . "</td>";
                    echo "<td> $" . $event['priceRanges'][0]['min'] . " / $" . $event['priceRanges'][0]['max'] . "</td>";
                    if (findById($event['id'])) {
                        echo "<td>BOOKED!</td>";
                    } else {
                        echo "<td id='td-$event[id]'><a id='$event[id]' class='btb' ><img src='../images/calendar_icon.png' width='30' /></a></td>";
                    }
                    echo "</tr>";

                }
                //onclick='btbVenue(\"$event[id]\")'
            }
//echo time()."MAT2";            

}
?>

</tbody>
</table>



<!-- 
<div id="form-overlay">
	<div id='dyn_form'>
    	<form onsubmit='addEventToCal()' action='#' method='POST'/>
    		<div class= 'appm'>Book this Bitch </div>
    		<div><input type='text'  name='dynamic_venue' id='dynamic_venue' class= 'text ui-widget-content ui-corner-all'/></div>
    		<div><input type='text'  id='dynamic_performer' name='dynamic_performer' class= 'text ui-widget-content ui-corner-all'/></div>
   			<div>
    			<select id='dynamic_date' name='dynamic_date' class='dyn_input' ></select>
    		</div>
    		<div><input type='text'  id='dynamic_code' name='dynamic_code' class= 'dyn_input'/></div>
    		
    		<div>
    			<select id='dynamic_rating' name='dynamic_rating' class= 'dyn_input' >
				<option>Awesome</option>
        		<option>Good</option>
        		<option>OK</option>
			    </select>
			</div>    
			
    		<div><input type='submit' id='savebutton' value = 'Save' /></div>
    	</form>
    </div>
</div>
 -->
<?php 
/* handle the result */
include '../calendar/calendar.php';
include 'footer.html';
?>
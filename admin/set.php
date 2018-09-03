<?php 
session_start();
date_default_timezone_set('America/New_York');

include 'header.html';
include "../session_helper.php";
include '../db.inc';
include 'client.php';


    if (!empty($_GET['fb_name']) && !empty($_GET['fb_key']) ) {
        $sql = "INSERT facebook_pages (page_name, keywords)
            VALUES ('".$_GET['fb_name']."', '".$_GET['fb_key']."')";
        
        if ($mysqli->query($sql) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $mysqli->error;
        }
    }
    if (!empty($_GET['deleteFB']) ) {
        $sql = "DELETE from facebook_pages where page_name = '".$_GET['deleteFB']."'";
        if ($mysqli->query($sql) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $mysqli->error;
        }
    }
    
    
    if (!empty($_GET['venue_name']) && !empty($_GET['venue_id']) ) {
        $sql = "INSERT tm_venues (venue_name, venue_id)
            VALUES ('".$_GET['venue_name']."', '".$_GET['venue_id']."')";
        
        if ($mysqli->query($sql) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $mysqli->error;
        }
    }
    if (!empty($_GET['deleteVenue']) ) {
        $sql = "DELETE from tm_venues where venue_id = '".$_GET['deleteVenue']."'";
        
        if ($mysqli->query($sql) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $mysqli->error;
        }
    }




?>

<script>

function appendPwd(obj) {
	obj.href=obj.href + $('#password').val();
	
}

</script>

<div id="topBanner_admin1" class="topBanner_1">ADMIN <a href="../menu.php"><img src="../images/home.png" /></a></div>
<div id="topBanner_admin2" class="topBanner_2">ticketswindsor@gmail.com</div>



<form method="get"  action="./set.php" >
<div>
<h3>Ticket Master Venues</h3>
<table>
<tr>
<th>Venue Name</th>
<!-- <th>Ticketmaster Venue Id</th> -->
</tr>
<?php
    $sql1 = "select id,venue_name,venue_id from tm_venues";
    $result = mysqli_query($mysqli, $sql1);
    while($row = mysqli_fetch_assoc($result)) {

        echo "<tr>";
        echo "<td>".$row['venue_name'] . "</td>";
        //echo "<td>".$row['venue_id'] . "</td>";
        echo "<td><a onclick='appendPwd(this);' href=\"./set.php?deleteVenue=".$row['venue_id']."&password=\"> Delete</a></td>";
        
        echo "</tr>";

    
    }
?>
<tr>
<td><input type="text" placeholder="Venue Name" name="venue_name" /></td>
<!-- <td><input type="text" placeholder="Ticket Master Id" name="venue_id" /></td> -->
</tr>
<tr>
<td colspan="1"><input type="submit" value="add venue" class="submit_form" /></td>
</tr>
</table> 
<p><a href="https://developer.ticketmaster.com/api-explorer/v2/" target="_blank"> API Explorer </a></p>
</div>


<div>
<h3>Facebook Scanner</h3>
<table>
<tr>
<th>Page Name</th>
<!-- <th>Keywords to search</th> -->
</tr>
<?php
    $sql1 = "select page_name,keywords,id from facebook_pages";
    $result = mysqli_query($mysqli, $sql1);
    while($row = mysqli_fetch_assoc($result)) {

        echo "<tr>";
        echo "<td>".$row['page_name'] . "</td>";
        //echo "<td>".$row['keywords'] . "</td>";
        echo "<td><a onclick='appendPwd(this);' href=\"./set.php?deleteFB=".$row['page_name']."&password=\"> Delete</a></td>";
        echo "</tr>";

    
    }
?>
<tr>
<td><input type="text" placeholder="Venue Name" name="fb_name" /></td>
<!-- <td><input type="text" placeholder="Ticket Master Id" name="fb_key" /></td> -->
</tr>
<tr>
<td colspan="1"><input type="submit" value="add facebook" class="submit_form" /></td>
</tr>
</table> 
<p></p>
</div>
</form>
 <?php 
/* handle the result */
include 'footer.html';
?>
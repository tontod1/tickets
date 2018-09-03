<?php include 'pages/header.php';?>



</head>
<body>
<div id="topBanner_tr1" class="topBanner_1"><img src="images/tracker-logo.jpg" /> <a href="../menu.php"><img src="../images/home.png" /></a></div>
<div id="topBanner_tr2" class="topBanner_2"></div>

<main role="main">

<div class="container">
<div class="row">
          <div class="index">
            <h2>Ticket Tracker</h2>
            <p>Ask Marco to add an event you want to track</p>
            <p>
        
        

			 <div class="dropdown">
			  <button class="btn btn-secondary dropdown-toggle index-btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			    Select Event
			  </button>
			  <div class="dropdown-menu index-btn" aria-labelledby="dropdownMenuButton">
			
			
					<?php
					
					include 'counterFunctions.php';
					
					include '../db.inc';
					
					$eventDesc="";
					$sql1 = "select eventId,Description from event order by Description";
					$result = mysqli_query($mysqli, $sql1);
					
					while($row = mysqli_fetch_assoc($result)) {
					    echo '<a class="dropdown-item" href="view.php?eventId='. $row["eventId"] .'&title='.$row["Description"].'">'. $row["Description"] .'</a>';
					}

					$events = getMyListingIdsPlusName();
					foreach ($events as $key => $value) {
					    echo '<a class="dropdown-item" href="view.php?eventId='. $key .'&title='.$value.'">'. $value .'</a>';
					}
					
					
					?>
			  </div>
			</div>     



            </p>
          </div>
          
</div>
</div>

</main>

<?php 
include 'pages/footer.php';
mysqli_close($mysqli);
?>
 
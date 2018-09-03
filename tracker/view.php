<?php include 'pages/header.php';?>
<?php 
date_default_timezone_set('US/Eastern');
include 'counterFunctions.php';

$eventId = $_GET['eventId'];
include '../db.inc';

$eventDesc=$_GET['title'];
// $sql1 = "select Description from event where eventId='$eventId'";
// $result = mysqli_query($mysqli, $sql1);

// while($row = mysqli_fetch_assoc($result)) {
// 	$eventDesc=$row["Description"];
// }

$sql2 = "select costLow,costHigh,costAvg,availCount,created_timestamp from events where eventId='$eventId' order by created_timestamp asc";
$result1 = mysqli_query($mysqli, $sql2);
$result2;
$total = $result1->num_rows;

$i = 0;
while($row = mysqli_fetch_assoc($result1)) {
	//while (i <= $total) {
	//$json = getEventTotals($eventId);
	//array_push(results2, row);
    $result2[$i]['costLow']=$row["costLow"];
    $result2[$i]['costHigh']=$row["costHigh"];
    $result2[$i]['costAvg']=$row["costAvg"];
    $result2[$i]['availCount']=$row["availCount"];
    $result2[$i]['created_timestamp'] = $row["created_timestamp"];
    $i++;
}

?>



<script>
var dataSet = [<?php
$i=0;

foreach($result2 as $result) {
    $low=$result['costLow'];
    $high=$result["costHigh"];
    $avg=$result["costAvg"];
    $totalTickets=$result["availCount"];
    $t = $result["created_timestamp"];
    
    
    echo "['$t', '".date('m/d/Y H', $t)."','$totalTickets', '$low','$high','$avg']";

    $i++;
    if ($i < $total) {
		echo ",";
	}
}

?>]
$(document).ready(function() {
    $('#example').DataTable( {
    	order: [[ 0, "desc" ]],
        data: dataSet,
        columns: [
            { title: "Timestamp" },
            { title: "Date and Hour" },            
            { title: "Total Tickets" },
            { title: "Cost Low" },
            { title: "Cost High" },
            { title: "Cost Avg" }
        ]
    } );
} );

</script>



<script>
window.onload = function () {

var options = {
	animationEnabled: true,
	theme: "light2",
	title:{
		text: "<?=$eventDesc ?> (<?=$eventId ?>) "
	},
	axisX:{
		valueFormatString: "DD MMM"
	},
	axisY: {
		title: "Total Tikets",
		suffix: "",
		minimum: 10
	},
	toolTip:{
		shared:true
	},  
	legend:{
		cursor:"pointer",
		verticalAlign: "bottom",
		horizontalAlign: "left",
		dockInsidePlotArea: true,
		itemclick: toogleDataSeries
	},
	data: [{
		type: "line",
		showInLegend: true,
		name: "Total Tickets",
		markerType: "square",
		xValueFormatString: "DD MMM, YYYY",
		color: "#F08080",
		yValueFormatString: "#,##",
		dataPoints: [

		<?php
		$i=0;

		foreach($result2 as $result) {
		    $totalTickets=$result["availCount"];
		    $t = $result["created_timestamp"];
		    $y = date('Y', $t);
		    $m = date('m', $t);
		    $d = date('d', $t);
		    
		    echo "{ x: new Date(".$t."000), y: $totalTickets }";
		    //{ x: new Date(2017, 10, 1), y: 63 },
		    $i++;
		    if ($i < $total) {
				echo ",";
			}
		}

		?>		     		
		]
	},
	{
		type: "line",
		showInLegend: true,
		name: "Low Price",
		lineDashType: "dash",
		yValueFormatString: "#,##0K",
		dataPoints: [
     		<?php
   			$i=0;
  			foreach($result2 as $result) {
   				    $low=$result['costLow'];
   				    $t = $result["created_timestamp"];
   				    $y = date('Y', $t);
   				    $m = date('m', $t);
   				    $d = date('d', $t);
    				    
   				    echo "{ x: new Date(".$t."000), y: $low }";
   				    //{ x: new Date(2017, 10, 2), y: 57 }
   				    $i++;
   				    if ($i < $total) {
   						echo ",";
  					}
			}

			?>		     		
		]
	}]
};
$("#chartContainer").CanvasJSChart(options);

function toogleDataSeries(e){
	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	} else{
		e.dataSeries.visible = true;
	}
	e.chart.render();
}

}
</script>

</head>
<body>
<div id="topBanner_tr1" class="topBanner_1"><img src="images/tracker-logo.jpg" /> <a href="../menu.php"><img src="../images/home.png" /></a> <a href="./index.php"><img src="../images/back.jpg" /></a></div>
<div id="topBanner_tr2" class="topBanner_2"></div>

<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<br/><br/><br/><br/><br/>
<div id="divider"></div>
<br/><br/><br/><br/><br/>
<table id="example" class="display" width="100%"></table>


<?php 
include 'pages/footer.php';
mysqli_close($mysqli);
 ?>
 
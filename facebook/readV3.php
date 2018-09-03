<?php 
session_start();
date_default_timezone_set('America/New_York');

include "../session_helper.php";
include 'header.html';
include '../db.inc';
$sql1 = "select page_name,keywords from facebook_pages";
$result = mysqli_query($mysqli, $sql1);

echo "<script>\n";
echo "var pageNames = [];\n";
echo "var keywords = [];\n";
while($row = mysqli_fetch_assoc($result)) {
    echo 'pageNames.push("' . ($row['page_name']) . '");';
    echo 'keywords.push("' .  ($row['keywords'])  . '");' . "\n";
}
echo "\n</script>\n";

?>
<div id="topBanner_fb1" class="topBanner_1"><img src="images/banner-fb.png" /> <a href="../menu.php"><img src="../images/home.png" /></a></div>
<div id="topBanner_fb2" class="topBanner_2"></div>

<div id="overlay"><img src="images/loading_apple.gif"  /></div>
<table id="example" class="display" cellspacing="0" width="100%">
<thead>
    <tr>
        <th>Date</th>
        <th>Venue</th>
        <th>Likes</th>        
        <th>Message</th>
        <th>Save</th>
    </tr>
</thead>
<tfoot>
    <tr>
        <th>Date</th>
        <th>Venue</th>
        <th>Likes</th>        
        <th>Message</th>
        <th>Save</th>
    </tr>
</tfoot>
<tbody>

</tbody>
</table>

<script type="text/javascript">

function getAllPages() {
    var pageCount = pageNames.length - 1;
	$("#overlay").show();
    
    function getNextPage() {
        $.ajax({
            url: "reader_api.php?page_name="+pageNames[pageCount]+"&keywords="+keywords[pageCount],
            method: 'GET',
            async: true,
            success: function(data) {

                renderData(data);

                if (pageCount > 0) {
                    pageCount--;
                   	getNextPage();
                } else {
                	generateFacebookCalendar();
                	startChart();
                }
            }
        });
    }
    getNextPage();
}

// no while loop is needed
// just call getAllImages() and pass it the 
// position and the maxImages you want to retrieve
getAllPages();

function renderData (data) {
	$( "#example" ).find( "tbody" ).append(data);
}

function startChart () {

  	    var table = $('#example').DataTable(
  	    		{
  	    		order: [[ 0, "desc" ]]
  	    		}
  	    		);
  	     
  	    $('#example tbody').on('click', 'tr', function () {
  	        var data = table.row( this ).data();
  	    } );

  	    $("#overlay").hide();

}

</script>


<div id="form-overlay">
<div id='dyn_form'></div>
</div>

<?php 
/* handle the result */
include '../calendar/calendar.php';
include 'footer.html';
?>
<style>
    label, input { display:block; }
    input.text { margin-bottom:12px; width:95%; padding: .4em; }
    fieldset { padding:0; border:0; margin-top:25px; }
    .overflow { height: 200px; }
    h1 { font-size: 1.2em; margin: .6em 0; }
    div#users-contain { width: 350px; margin: 20px 0; }
    div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
    div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
    .ui-dialog .ui-state-error { padding: .3em; }
    .validateTips { border: 1px solid transparent; padding: 0.3em; }
  </style>
  
  


<div id="dialog-form" title="Book this Bitch">
 
  <form action="../calendar">
  	<input type='hidden'  name='dynamic_id' id='dynamic_id' class= ''/>
  	<input type='hidden'  name='dynamic_type' id='dynamic_type' class= ''/>
  	<input type='hidden'  name='dynamic_action' id='dynamic_action' value='add' class= ''/>  	  	  	
    <fieldset>
      <label for="dynamic_venue">Venue</label>
      <input type='text'  name='dynamic_venue' id='dynamic_venue' class= 'text ui-widget-content ui-corner-all'/>
      <label for="dynamic_performer">Performer</label>
      <input type='text'  id='dynamic_performer' name='dynamic_performer' class= 'text ui-widget-content ui-corner-all'/>
      <label for="dynamic_date">Buy Date</label>
      <input type='text'  id='dynamic_date' name='dynamic_date' class= 'text ui-widget-content ui-corner-all'/>
      <label for="dynamic_time">Buy Time</label>
      <input type='text'  id='dynamic_time' name='dynamic_time' class= 'text ui-widget-content ui-corner-all'/>
      <label for="dynamic_code">Pass Code</label>
      <input type='text'  id='dynamic_code' name='dynamic_code' class= 'text ui-widget-content ui-corner-all'/>
      <label for="dynamic_link">Quick Link</label>
      <input type='text'  id='dynamic_link' name='dynamic_link' class= 'text ui-widget-content ui-corner-all'/>
      
      <!-- Allow form submission with keyboard without duplicating the dialog button -->
      <div id='dynamic_error' class="ui-dialog-buttonset" ></div>
      <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
    </fieldset>
  </form>
</div>



  <!-- this is for dynamic form -->
 <script>
 // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
 var dialog, form,
 dvenue = $( "#dynamic_venue" ),
 dperformer = $( "#dynamic_performer" ),
 ddate = $( "#dynamic_date" ),
 dtime = $( "#dynamic_time" ),
 drating = $( "#dynamic_rating" ),
 dlink = $("#dynamic_link"), 
 allFields = $( [] ).add( dvenue ).add( dperformer ).add( ddate ).add( dtime ).add( drating ),
 tips = $( ".validateTips" );


 function checkLength( o, n, min, max ) {
     if ( o.val().length > max || o.val().length < min ) {
       o.addClass( "ui-state-error" );
       return false;
     } else {
       return true;
     }
 }
 
 dialog = $( "#dialog-form" ).dialog({
     autoOpen: false,
     height: 600,
     width: 450,
     modal: true,
     buttons: {
       "Book it!": bookEvent,
       Cancel: function() {
         dialog.dialog( "close" );
       }
     },
     close: function() {
       form[ 0 ].reset();
  	 	$("#dynamic_error").html("");
  	 	$("#customBTBmessage").html("");
       allFields.removeClass( "ui-state-error" );
     }
   });

 $( "#dynamic_date" ).datepicker();

 form = dialog.find( "form" ).on( "submit", function( event ) {
 	bookEvent(); 
	    //event.preventDefault();
 	//addEventToCal();
 	
 });

 function bookEvent() {
     var valid = true;
     allFields.removeClass( "ui-state-error" );

     valid = valid && checkLength( dvenue, "venue", 2, 50 );
     valid = valid && checkLength( dperformer, "performer", 2, 80 );
     valid = valid && checkLength( ddate, "date", 6, 16 );

     if ( !valid ) {
       alert("Error.  Make sure Venue/Performer/Date are valid")
     } else {
   	  addEventToCal();
     } 
	      
     
     return valid;
   }
 
 function generatePopulatedCalendar() {
  	 
    	    $( ".btb" ).button().on( "click", function() {
    	    	btbTicketmasterVenue($(this).attr("id"));
    	    	dialog.dialog( "open" );
    	    });
 }

 function generateEmptyCalendar() {
  	 
	    $( ".btb" ).button().on( "click", function() {
	    	btbEmptyVenue();
	    	dialog.dialog( "open" );
	    });
}

 function generateFacebookCalendar() {
  	 
	    $( ".btb" ).button().on( "click", function() {
	    	btbFacebookVenue($(this).attr("id"));
	    	dialog.dialog( "open" );
	    });
}

 
</script>

<script>

function btbEmptyVenue() {
	
	venue = "";
	performer = "";
	url = "";
	dates = "";
	final_dates = [];
	
	populateDynamicFormId(Date.now(), "custom");
	//populateDynamicForm(venue, performer, url, final_dates);
	
}

function btbTicketmasterVenue(venueId) {
	
	tr = $('#tr-'+venueId);
	venue = tr.find('a.venueUrl')[0].innerHTML;
	performer = tr.find('a.performerUrl')[0].innerHTML;
	url = tr.find('a.performerUrl')[0].href;
	dates = tr.find('.pre_date');
	final_dates = [];
	for (var i = 0, len = dates.length; i < len; i++) {
		splits = dates[i].innerHTML.split(' / ');
		var obj = { date: splits[0], type: splits[1]};
		final_dates.push(obj);
	}
	
	populateDynamicFormId(venueId, "fb");
	
	populateDynamicForm(venue, performer, url, final_dates);
	
}

function btbFacebookVenue(postId) {
	
	tr = $('#tr-'+postId);
	venue = tr.find('a.venueUrl')[0].innerHTML;
	performer = "";
	url = tr.find('a.venueUrl')[0].href;
	dates = tr.find('.pre_date');
	final_dates = [];
	
	populateDynamicFormId(postId, "fb");
	
	populateDynamicForm(venue, performer, url, final_dates);
	
}


function populateDynamicFormId(id, type){
	$("#dynamic_id").val(id);
	$("#dynamic_type").val(type);
}

function populateDynamicForm(venue, performer, url, dates){
	dvenue.val(venue);
	dperformer.val(performer);
	dlink.val(url);	
}

function addEventToCal() {
	
	url = "../calendar/controller.php?"+ 
		 "dynamic_id="+$("#dynamic_id").val()+
		 "&dynamic_venue="+$("#dynamic_venue").val()+
		 "&dynamic_performer="+$("#dynamic_performer").val()+
		 "&dynamic_date="+$("#dynamic_date").val()+
		 "&dynamic_time="+$("#dynamic_time").val()+
		 "&dynamic_code="+$("#dynamic_code").val()+
		 "&dynamic_rating="+$("#dynamic_rating").val()+
		 "&dynamic_link="+$("#dynamic_link").val()+		 
		 "&dynamic_type="+$("#dynamic_type").val()+
		 "&dynamic_action="+$("#dynamic_action").val();

// 	url = "../calendar/controller.php?"+ 
// 		 "dynamic_id="+$("#dynamic_id").val()+
// 		 "&dynamic_venue=qqwe"+
// 		 "&dynamic_performer=wrwer"+
// 		 "&dynamic_date=04/09/2018"+
// 		 "&dynamic_time=ttt"+
// 		 "&dynamic_code=ccc"+
// 		 "&dynamic_rating=rrr"+
// 		 "&dynamic_link=lll"+		 
// 		 "&dynamic_type=tttyyy"+
// 		 "&dynamic_action=add";
		 
		 
	$.ajax({
 		type:"GET",
 		url:url,
 		async:true,
 		dataType: "html",
         success: function(data) {
             console.log(data);
        	 $("#td-"+data).html("BOOKED!");
        	 $("#customBTBmessage").html("BOOKED! refresh page to view");        	 
//      	     dialog = $( "#dialog-form" ).dialog({
//       	      autoOpen: false,
//       	      modal: true,
//       	      close: function() {
//       	        form[ 0 ].reset();
//       	   	 	$("#dynamic_error").html("");
//       	        allFields.removeClass( "ui-state-error" );
//       	      }
//       	    });
          	 dialog.dialog( "close" );
             // Parse the response.
             // Do other things.
         },
         error: function(xhr, status, err) {
             // This time, we do not end up here!
        	 $("#dynamic_error").html("Error Occured");

         }
	});
	return false;
}

</script>
function btbVenue(venueId) {
	
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
	
	dynamicFormVenue(venueId);
	dynamicForm(venue, performer, url, final_dates);
	
	
}

function dynamicFormVenue(id){
	$("#dynamic_id").val(id);
	$("#dynamic_type").val('tm');
}

function dynamicForm(venue, performer, url, dates){

	$("#dynamic_venue").val(venue);
	$("#dynamic_performer").val(performer);


	
	
}

function addEventToCal() {
	//'../calendar/add';
	return false;
}
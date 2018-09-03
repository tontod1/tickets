<?php
date_default_timezone_set('America/New_York');

const stubhubAcct = 'C0DCD9D487EE01E1E04400212868B1B6';
const stubhubToken = 'Bearer 0df8afd4-0b68-39d4-931b-dde362f4aa9b';

function getEventTotals($eventId) {
	sleep(6);
    $service_url = 'https://api.stubhub.com/search/inventory/v2?eventid='.$eventId.'&sort=currentprice+asc&pricingsummary=true&priceType=listPrice&rows=1';
	$curl = curl_init($service_url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

	//Set your auth headers
	curl_setopt($curl, CURLOPT_HTTPHEADER, array(
	    'Authorization:' . stubhubToken
	));

	$curl_response = curl_exec($curl);
	if ($curl_response === false) {
		$info = curl_getinfo($curl);
		curl_close($curl);
		die('error occured during curl exec. Additioanl info: ' . var_export($info));
	}
	curl_close($curl);
	$json = json_decode($curl_response);
	
	if (isset($json->response->status) && $json->response->status == 'ERROR') {
		die('error occured: ' . $json->response->errormessage);
	}
	
	return $json;
	
}

function getMyListingIds() {
    $acct = stubhubAcct;
    $service_url = 'https://api.stubhub.com/accountmanagement/listings/v1/seller/'.$acct;
    $curl = curl_init($service_url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
    //Set your auth headers
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Authorization:'  . stubhubToken
    ));
    
    $curl_response = curl_exec($curl);
    if ($curl_response === false) {
        $info = curl_getinfo($curl);
        curl_close($curl);
        die('error occured during curl exec. Additioanl info: ' . var_export($info));
    }
    curl_close($curl);
    $json = json_decode($curl_response);
    
    if (isset($json->response->status) && $json->response->status == 'ERROR') {
        die('error occured: ' . $json->response->errormessage);
    }
    
    $ids = [];
    foreach ($json->listings->listing as $listing) {
        array_push($ids, $listing->eventId);   
    }
    
    return array_unique($ids);
    
    
}


function getMyListingIdsPlusName() {
    $acct = stubhubAcct;
    $service_url = 'https://api.stubhub.com/accountmanagement/listings/v1/seller/'.$acct;
    $curl = curl_init($service_url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    //Set your auth headers
    //Old token 'Authorization: Bearer 8e778e58-ef01-3541-812e-ab755e33eacd'
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Authorization: ' . stubhubToken
    ));

    $curl_response = curl_exec($curl);
    if ($curl_response === false) {
        $info = curl_getinfo($curl);
        curl_close($curl);
        die('error occured during curl exec. Additioanl info: ' . var_export($info));
    }
    curl_close($curl);
    $json = json_decode($curl_response);
    
    if (isset($json->response->status) && $json->response->status == 'ERROR') {
        die('error occured: ' . $json->response->errormessage);
    }
    
    $ids = [];
    //var_dump($json->listings);
    //die("MAT");
    
    foreach ($json->listings->listing as $listing) {
        $time = strtotime( $listing->eventDate );
        $ids[$listing->eventId] = $listing->eventDescription . "-". $listing->venueDescription . "-". date('m/d/Y H', $time);
    }
    
    return $ids;
    
    
}

function showDiv($val) {
	echo "<div>$val</div>";
}



?>
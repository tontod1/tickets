<?php 



// $.ajax({
//     type:"GET",
//     url:"https://app.ticketmaster.com/discovery/v2/events.json?size=1&apikey=ZCOpO9bwevz8tVp3RLZAc4nx649sBtZv",
//     async:true,
//     dataType: "json",
//     success: function(json) {
//         console.log(json);
//         // Parse the response.
//         // Do other things.
//     },
//     error: function(xhr, status, err) {
//         // This time, we do not end up here!
//     }
// });

    function getEventForVenue($venueId) {
        usleep(200000); //needed to avoid reaching Rate Limit
        $t = date('Y-m-d', time());   //2018-01-29
        //$service_url = "https://app.ticketmaster.com/discovery/v2/events.json?size=1&apikey=ZCOpO9bwevz8tVp3RLZAc4nx649sBtZv&venueId=$venueId&onsaleOnAfterStartDate=$t";
        $service_url = "https://app.ticketmaster.com/discovery/v2/events.json?apikey=ZCOpO9bwevz8tVp3RLZAc4nx649sBtZv&venueId=$venueId&onsaleOnAfterStartDate=$t";
        //echo "[MAT3".$service_url."]";
        $curl = curl_init($service_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        //Set your auth headers
//         curl_setopt($curl, CURLOPT_HTTPHEADER, array(
//            'Authorization: Bearer 8e778e58-ef01-3541-812e-ab755e33eacd'
//        ));
        
        $curl_response = curl_exec($curl);
        if ($curl_response === false) {
            $info = curl_getinfo($curl);
            curl_close($curl);
            die('error occured during curl exec. Additioanl info: ' . var_export($info));
        }
        curl_close($curl);
        //die($curl_response);
        $json = json_decode($curl_response, true);
        
        if (isset($json->response->status) && $json->response->status == 'ERROR') {
            die('error occured: ' . $json->response->errormessage);
        }
        
        return $json;
        
    }
    
    
    function showDiv($val) {
        echo "<div>$val</div>";
    }
    
    

?>
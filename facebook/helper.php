<?php 
$fb = new Facebook\Facebook([
    'app_id' => '922471214585632',
    'app_secret' => '0746a038fc39892dbe21e6bea68aba65',
    'default_graph_version' => 'v2.1',
]);

if (!empty($_GET['token'])) {
    $_SESSION["token"] = $_GET['token'];
}

global $accessToken;
if (!empty($_SESSION['token'])) {
    $accessToken = $_SESSION['token'];
}


function getPosts ($page) {

    global $fb;
    global $accessToken;

    try {
        // Returns a `Facebook\FacebookResponse` object
        $response = $fb->get(
            "/".$page."/posts",
            "$accessToken"
            );
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }

    return $response->getGraphEdge();
    
}


function getEmailAddress() {
    
    global $fb;
    global $accessToken;
    $fb->setDefaultAccessToken($accessToken);
    $response = $fb->get('me?locale=en_US&fields=name,email');
    $userNode = $response->getGraphUser();
//      var_dump(
//          $userNode->getField('email'), $userNode['email']
//          );
    return $userNode->getField('email');
    
}

function getId() {
    
    global $fb;
    global $accessToken;
    $fb->setDefaultAccessToken($accessToken);
    $response = $fb->get('me?locale=en_US&fields=name,email');
    $userNode = $response->getGraphUser();
//     var_dump(
//         $userNode
//         );
    return $userNode->getField('id');
    
}

function checkDateInterval ($dElement, $numDays) {
//return true;
    $currentDate = new DateTime();
    $interval = date_diff($dElement,$currentDate);
    // die(var_dump($interval) . ":MAT");
     //die("HERE:" . $dElement->format('Y-m-d H:i:s') . "<br>" . $currentDate->format('Y-m-d H:i:s'));
        
     return $interval->days < $numDays;
}


function getLikes ($objId) {
    
    global $fb;
    global $accessToken;
    
    try {
      // Returns a `Facebook\FacebookResponse` object
      $response = $fb->get(
          "/".$objId."?fields=likes.limit(1).summary(true)",
        "$accessToken"
      );
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
    }
    $likesEdge = $response->getGraphNode();

    foreach ($likesEdge as $like) {
        $metadata = $like->getMetaData();
        return ($metadata['summary']['total_count']);
    }
            
}
?>
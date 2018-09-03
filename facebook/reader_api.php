<?php 
session_start();
date_default_timezone_set('America/New_York');
require_once 'Facebook/autoload.php'; use Facebook\FacebookSession;
include '../calendar/helper_cal.php';

include '../db.inc';
include 'helper.php';

    
           
            /* PHP SDK v5.0.0 */
            /* make the API call */
            
            

            $postsEdge = getPosts ($_GET["page_name"]);
            
            
            foreach ($postsEdge as $post) {
                if ((stripos($post['message'], $_GET['keywords']) !== false
                    || stripos($post['message'], 'presale') !== false)
                    && checkDateInterval($post['created_time'], 10)
                    ) {

                    //determine liked
                    $likes = getLikes($post["id"]);
                    $liked = '';
                    if ($likes > 150) $liked = 'high';
                    else if ($likes > 75) $liked = 'medium';
                    else $liked = 'low';

                    $ids = explode("_", $post["id"] );
                    $link = "http://facebook.com/".$ids[0]."/posts/".$ids[1];
                    
                    echo "<tr id='tr-$post[id]'>";
                    echo "<td>" . $post['created_time']->format('Y-m-d H:i:s') . "</td>";
                    echo "<td><a target=\"_blank\"  href='$link' class='venueUrl'>".$_GET["page_name"]."</a></td>";
                    echo "<td class='$liked'>". $likes  . "</td>";
                    echo "<td>". $post['message']  ."</td>";
                    if (findById($post['id'])) {
                        echo "<td>BOOKED!</td>";
                    } else {
                        echo "<td id='td-$post[id]'><a id='$post[id]' class='btb' ><img src='../images/calendar_icon.png' width='30' /></a></td>";
                    }
                    echo "</tr>";
                }
                
            }
            
            

            
/* handle the result */
?>
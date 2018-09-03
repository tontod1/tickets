<?php 

require_once '../Database.php';

function validateCalendarEvent() {
    if (!empty($_GET['dynamic_id'])
        && !empty($_GET['dynamic_venue'])
        && !empty($_GET['dynamic_performer'])
        && !empty($_GET['dynamic_date'])
        && !empty($_GET['dynamic_time'])) {
            
            return true;
        }
        
        return false;
}


function save() {
    $db = Database::getConnection();
    if (validateCalendarEvent()) {
        
        $did = $_GET['dynamic_id'];
        $dtype = $_GET['dynamic_type'];
        $dvenue = $_GET['dynamic_venue'];
        $dperf = $_GET['dynamic_performer'];
        $ddate = $_GET['dynamic_date'];
        $dtime =$_GET['dynamic_time'];
        $dcode =$_GET['dynamic_code'];
        $dlink =$_GET['dynamic_link'];
        
        $newdate=date("Y-m-d H:i:s", strtotime($ddate));
        
        $sql = "INSERT calendar (id, event_name, venue, link, sale_date, sale_time, code, type)
            VALUES ('$did', '$dperf', '$dvenue', '$dlink', '$newdate','$dtime', '$dcode', '$dtype')";
        
        if(mysqli_query($db, $sql)){
            return true;
        } else{
            echo "Failed to isnert with error: " . mysqli_error($db);
        }
        
        
    } else {
        echo "Invalid input";
    }
    
    return false;
    
}

function clean() {
    $db = Database::getConnection();
     
        $sql = "delete from calendar where sale_date < CURDATE()-INTERVAL 3 DAY";
        
        if(mysqli_query($db, $sql)){
            return true;
        } else{
            echo "Failed to isnert with error: " . mysqli_error($db);
        }
    
}


function findById($did) {

        if(!empty($did)) {
            
            $sql = "select id from calendar where id = '$did' ";
            
//             if ($mysqli->query($sql) !== TRUE) {
//                 echo "Error: " . $sql . "<br>" . $mysqli->error;
//             } 
            
//             $result = $mysqli->query($sql);
            if ($result =  mysqli_query(Database::getConnection(), $sql)) {
                if ($result->num_rows > 0) {
                    return true;
                }
            } 
        } else {
            echo "No event Id passed.";
        }
        
        return false;
}

function displayAll() {
        
        clean();
    
        $sql = "select id, event_name, venue, link, sale_date, sale_time, code, type ".
                 "from calendar order by sale_date asc ";
        
        //             if ($mysqli->query($sql) !== TRUE) {
        //                 echo "Error: " . $sql . "<br>" . $mysqli->error;
        //             }
        
        //             $result = $mysqli->query($sql);
        //die($sql);
        
        if ($result =  mysqli_query(Database::getConnection(), $sql)) {
            while($row = mysqli_fetch_assoc($result)) {

                $time = strtotime( $row['sale_date'] );
                $class = isToday($time)? "high" : "";
                
                echo "<tr>";
                echo "<td>". $row["venue"] . "</td>";
                echo "<td class='$class'>". $row["event_name"] . "</td>";
                echo "<td >" . date('m/d/Y', $time)  . " " . $row['sale_time'] . "</td>";
                echo "<td>" . $row['code'] . "</td>";
                echo "<td><a href='" . $row['link'] . "' > Buy Now</a></td>";
                echo "</tr>";
            }
        }

}

function isToday($time) {
    return ($time === strtotime('today'));
}

?>
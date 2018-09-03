
<?php
while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>". $row["venue"] . "</td>";
                    echo "<td>". $row["event_name"] . "</td>";
                    $time = strtotime( $row['sale_date'] );
                    echo "<td>" . date('m/d/Y H:i', $time)  . "</td>";
                    echo "<td>" . $row['rating'] . "</td>";
                    echo "<td><a href='" . $row['link'] . "' > Buy Now</a></td>";
                    echo "</tr>";

}
echo "</tbody>";
echo "</table>";
/* handle the result */
include 'footer.html';
?>
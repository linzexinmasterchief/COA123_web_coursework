<html>
    <head>
        <link href="css/style_control.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <table border="1">
            <?php
                require_once('MDB2.php');    

                // import username and password from an individual file for safty
                include 'credentials.php';
                // import weekday calculation function
                include 'weekday.php';

                $db=MDB2::connect("mysql://$MySQL_username:$MySQL_password@$MySQL_hostname/$MySQL_database");

                if(MDB2::isError($db))
                {
                    die($db->getMessage());
                } 

                $date = strval($_GET["date"]);
                $date_arr = split("/", $date);

                $day_in_week = weekday($date_arr);
                // 0 is sunday, 6 is saturday
                $is_weekday = !($day_in_week == 0 || $day_in_week == 6);

                $partySize = (int)$_GET["partySize"];

                $price_name = "venue.weekend_price";
                if ($is_weekday) {
                    $price_name = "venue.weekday_price";
                }

                // fill in sql request
                $sql="SELECT DISTINCT name, $price_name FROM venue 
                WHERE venue_id not in (
                    SELECT DISTINCT venue.venue_id
                    FROM venue JOIN venue_booking
                    ON venue.venue_id = venue_booking.venue_id
                    WHERE venue_booking.date_booked = STR_TO_DATE('$date','%d/%m/%Y')
                    ) AND
                    venue.capacity >= $partySize";


                $db->setFetchMode(MDB2_FETCHMODE_ASSOC);

                $result = $db->queryAll($sql);
                if (PEAR::isError($result)) 
                {
                    die($result->getMessage());
                }

                // header
                echo "<tr>";
                echo "<th scope=\"col\">Name    </th>";
                if ($is_weekday) {
                    echo "<th scope=\"col\">Weekday Cost</th>";
                } else {
                    echo "<th scope=\"col\">Weekend Cost</th>";
                }
                echo "<tr>";

                // use nested loop to iterate through 2d array
                foreach ($result as $record) {
                    echo "<tr>";
                    foreach ($record as $element) {
                        echo "<th scope=\"col\">$element</th>";
                    }
                    echo "</tr>";
                }


            ?>
        </table>
    </body>
</html> 
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

                $db=MDB2::connect("mysql://$MySQL_username:$MySQL_password@$MySQL_hostname/$MySQL_database");

                if(MDB2::isError($db))
                {
                    die($db->getMessage());
                } 

                $venue_id = $_GET["venueId"];
                $sql="SELECT * FROM venue WHERE venue_id = $venue_id";

                $db->setFetchMode(MDB2_FETCHMODE_ASSOC);

                $result = $db->queryAll($sql);
                if (PEAR::isError($result)) 
                {
                    die($result->getMessage());
                }

                echo "<tr>";
                echo "<th scope=\"col\">Venue ID</th>";
                echo "<th scope=\"col\">Name    </th>";
                echo "<th scope=\"col\">Capacity</th>";
                echo "<th scope=\"col\">Weekend Price</th>";
                echo "<th scope=\"col\">Weekday Price</th>";
                echo "<th scope=\"col\">Licenced</th>";
                echo "<tr>";
                // use nested loop to iterate through 2d array
                // row
                foreach ($result as $record) {
                    echo "<tr>";
                    // column
                    foreach ($record as $element) {
                        echo "<th scope=\"col\">$element</th>";
                    }
                    echo "</tr>";
                }

            ?>
        </table>
    </body>
</html> 
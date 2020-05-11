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

                $minCapacity = $_GET["minCapacity"];
                $maxCapacity = $_GET["maxCapacity"];
                $sql="SELECT name, weekend_price, weekday_price FROM venue WHERE capacity <= $maxCapacity AND capacity >= $minCapacity AND licensed = 1";

                $db->setFetchMode(MDB2_FETCHMODE_ASSOC);

                $result = $db->queryAll($sql);
                if (PEAR::isError($result)) 
                {
                    die($result->getMessage());
                }

                echo "<tr>";
                echo "<th scope=\"col\">Name    </th>";
                echo "<th scope=\"col\">Weekend Price</th>";
                echo "<th scope=\"col\">Weekday Price</th>";
                echo "<tr>";

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
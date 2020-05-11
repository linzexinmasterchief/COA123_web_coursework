<html>
    <head>
        <link href="css/style_control.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <table border="1">
            <?php 
                $min = $_GET["min"];
                $max = $_GET["max"];

                $c1 = $_GET["c1"];
                $c2 = $_GET["c2"];
                $c3 = $_GET["c3"];
                $c4 = $_GET["c4"];
                $c5 = $_GET["c5"];
                $arr = array($c1, $c2, $c3, $c4, $c5);

                $header = "cost per person →\r\n↓ party size";
                echo "<tr>";
                echo "<th scope=\"col\">$header</th>";
                foreach ($arr as $cost) {
                    echo "<th scope=\"col\">$cost</th>";
                }
                echo "</tr>";

                for ($i = 0; $i < ($max - $min) / 5 + 1; $i ++){
                    echo "<tr>";
                    $party_size = $i * 5 + $min;
                    echo "<th scope=\"col\">".strval($party_size)."</th>";
                    foreach ($arr as $cost) {
                        echo "<th scope=\"col\">".strval($cost * $party_size)."</th>";
                    }
                    echo "</tr>";
                }
            ?>
        </table>
    </body>
</html> 
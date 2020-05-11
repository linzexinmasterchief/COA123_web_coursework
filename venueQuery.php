<?php

    include 'weekday.php';

    // no error report shown to the user
    error_reporting(0);
    require_once('MDB2.php');

    
    // import username and password from an individual file for safty
    include 'credentials.php';

    $db=MDB2::connect("mysql://$MySQL_username:$MySQL_password@$MySQL_hostname/$MySQL_database");

    if(MDB2::isError($db))
    {
        die($db->getMessage());
    } 
    
    // get q parameter from entering function in wedding.php
    // the request format is: field name + field value
    $q = $_REQUEST["q"];
    $q_arr = split("/", $q, 2);
    $q_field_name = strval($q_arr[0]);
    $q_field_value = strval($q_arr[1]);
    // read json file
    // json format is [$date, $party_size, $catering_grade]
    $file = "user_data.json";
    $json = json_decode(file_get_contents($file), true);
    // update json data ($q_arr[0] is the field name, so can be used as key)
    // check if field name is valid
    if ($q_field_name == "date" || $q_field_name == "party_size" || $q_field_name == "catering_grade"){
        $json[$q_field_name] = $q_field_value;
    }
    file_put_contents($file, json_encode($json));

    $date = strval($json["date"]);
    $date_arr = split("/", $date);

    $day_in_week = weekday($date_arr);
    // 0 is sunday, 6 is saturday
    $is_weekday = !($day_in_week == 0 || $day_in_week == 6);

    // critical: price_name
    $price_name = "venue.weekend_price";
    if ($is_weekday) {
        $price_name = "venue.weekday_price";
    }
    // critical: party_size
    $party_size = (int)$json["party_size"];
    // critical: catering_grade
    $catering_grade = (int)$json["catering_grade"];

    // fill in sql request
    $sql="SELECT DISTINCT venue.name, $price_name, catering.grade, catering.cost, venue.capacity
    FROM venue JOIN catering
    ON venue.venue_id = catering.venue_id
    WHERE venue.venue_id not in (
        SELECT DISTINCT venue.venue_id
        FROM venue JOIN venue_booking
        ON venue.venue_id = venue_booking.venue_id
        WHERE venue_booking.date_booked = STR_TO_DATE('$date','%d/%m/%Y')
    ) AND
        venue.capacity >= $party_size 
    AND
        catering.grade >= $catering_grade
    AND
        venue.licensed = 1
    ORDER BY catering.grade";


    $db->setFetchMode(MDB2_FETCHMODE_ASSOC);

    $result = $db->queryAll($sql);
    if (PEAR::isError($result)) 
    {
        die($result->getMessage());
    }

    // respond back to client
    echo "<tr>";
    echo "<th scope=\"col\">    Name    </th>";
    if ($is_weekday) {
        echo "<th scope=\"col\">  Weekday Cost  </th>";
    } else {
        echo "<th scope=\"col\">  Weekend Cost  </th>";
    }
    echo "<th scope=\"col\">  Catering grade  </th>";
    echo "<th scope=\"col\">  Catering cost   </th>";
    echo "<th scope=\"col\">  Capacity  </th>";
    echo "<tr>";

    foreach ($result as $record) {
        echo "<tr>";
        foreach ($record as $element) {
            echo "<th scope=\"col\">$element</th>";
        }
        echo "</tr>";
    }
?>
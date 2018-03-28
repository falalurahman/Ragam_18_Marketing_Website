<?php
    $servername = "localhost";
    $username = "nitcfest_regdesk";
    $password = "TW8cBu^vtPVy";
    $dbname = "nitcfest_ragam18";

    // Create connection
    $connection = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
    ?>
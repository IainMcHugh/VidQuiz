<?php
    
    if (isset($_GET['percentage'])) {
        require 'dbh-inc.php';

        $percentage = $_GET["percentage"];
        $username = $_GET["username"]; 
        $vid_url_id = $_GET["vid-url-id"]; 
        
        echo $percentage;
        echo $username;
        echo $vid_url_id;

        $sql = "INSERT INTO user_data (username, vid_url_id, mark) VALUES (
            '".mysqli_real_escape_string($conn, $username)."',
            '".mysqli_real_escape_string($conn, $vid_url_id)."',
            '".mysqli_real_escape_string($conn, $percentage)."'
        )";

    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
        echo "New record has an id of: ".mysqli_insert_id($conn)."";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

        // need to pass in the vid_url
        // create a connection with an INSERT INTO

    }

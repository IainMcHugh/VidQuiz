<?php
    
    if (isset($_POST['question'])) {
        require 'dbh-inc.php';

        $question = count($_POST["question"]);
        $answer = count($_POST["answer"]); 
        $search = $_POST["search"]; 
        if($question > 0 && $answer > 0)
        {  
            echo $search;
            $sql = "INSERT INTO video_links (vid_url) VALUES('".mysqli_real_escape_string($conn, $search)."')";
            //now retrieve the vid_url_id from the db of the line above created
            if (mysqli_query($conn, $sql)) {
                echo "New record created successfully";
                echo "New record has an id of: ".mysqli_insert_id($conn)."";
                $vid_url_id = mysqli_insert_id($conn);
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
            for($i=0; $i<$question; $i++)  
            {  
                if(trim($_POST["question"][$i] != ''))  
                {
                    echo $vid_url_id;
                    echo $search;
                    echo $_POST["question"][$i];
                    echo $_POST["answer"][$i];
                    $sql = "INSERT INTO questions (vid_url_id, question, answer) VALUES($vid_url_id, '".mysqli_real_escape_string($conn, $_POST["question"][$i])."', '".mysqli_real_escape_string($conn, $_POST["answer"][$i])."')";  
                    if (mysqli_query($conn, $sql)) {
                        echo "New record created successfully";
                        echo "New record has an id of: ".mysqli_insert_id($conn)."";
                    } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    } 
                }  
            }  
            echo "Data Inserted";  
        }  
        else  
        {  
            echo "Please Enter Name";  
        }  
    }
    else {
        echo "DIDNT WORK!";
    }

<?php
    require 'header.php';
?>


<div class="wrapper-main">
    <section class="section-default">
        <div class="user-layout">
        
        <?php

            require 'includes/dbh-inc.php';

            $user = $_SESSION["userUid"];
            echo '<div class="user-quiz">
                <h2 class="user-heading">Completed Quizzes</h2>
                <h2 class="user-heading">Mark</h2>
            </div>';
            $sql = "SELECT * FROM user_data WHERE username='$user'";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);
            if ($resultCheck > 0){
                while($row = mysqli_fetch_assoc($result)){
                    $vid_url_id = $row['vid_url_id'];
                    $mark = $row['mark'];
                    $sql = "SELECT vid_url FROM video_links WHERE vid_url_id = '$vid_url_id'";
                    $result2 = mysqli_query($conn, $sql);
                    $row2 = mysqli_fetch_assoc($result2);
                    $vid_url_split = preg_replace("#.*youtube\.com/watch\?v=#", "", $row2["vid_url"]);
                    $content = file_get_contents("http://youtube.com/get_video_info?video_id=".$vid_url_split);
                    parse_str($content, $ytarr);
                    $jsondec = json_decode($ytarr['player_response'],true);
                    // echo $jsondec['videoDetails']['title'];
                    $title = $jsondec['videoDetails']['title'];
                    echo '<div class="user-quiz">
                    <h2 class="user-results">'.$title.'</h2>
                    <h2 class="user-results">'.$mark.'%</h2>
                    </div>';
                }
            }
        ?>
    </div>
    </section>
</div>

<?php
    require 'footer.php';
?>
<?php
    require 'header.php';
?>


<div class="wrapper-main">
    <section class="section-default">
    <?php
        if (isset($_POST['search-submit'])) {
            require 'includes/dbh-inc.php';
            $search = mysqli_real_escape_string($conn, $_POST['search']);
            
            $sql = "SELECT vid_url_id FROM video_links WHERE vid_url='$search'";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);
            
            if ($resultCheck == 0){
                $vid_url_split = preg_replace("#.*youtube\.com/watch\?v=#", "", $search);
                
                $content = file_get_contents("http://youtube.com/get_video_info?video_id=".$vid_url_split);
                parse_str($content, $ytarr);
                $jsondec = json_decode($ytarr['player_response'],true);
                $title = $jsondec['videoDetails']['title'];
                if ($title != null) {
                    echo '<div class="search-section">
                    <div class="search-title">'.$title.'</div>
                    <iframe width="1120" height="630" src="https://www.youtube.com/embed/'.$vid_url_split.'" frameborder="0" allowfullscreen></iframe>
                    <div class="search-quiz">Quiz does not yet exist for this Youtube Video!</div>
                    <form action="createquiz.php" method="post">
                        <input type="hidden" name="vid_url" value='.$search.'>
                        <button class="create-quiz-button" type="submit" name="create-quiz">Create Quiz for this video</button>
                        </form>
                    </div>';
                }
                else {
                    echo 'No youtube video associated with this link!';
                }
            }
            else {
                
                $row = mysqli_fetch_assoc($result);
                
                $vid_url_id = $row['vid_url_id'];
                $vid_url_split = preg_replace("#.*youtube\.com/watch\?v=#", "", $search);
                $content = file_get_contents("http://youtube.com/get_video_info?video_id=".$vid_url_split);
                parse_str($content, $ytarr);
                $jsondec = json_decode($ytarr['player_response'],true);
                // echo $jsondec['videoDetails']['title'];
                $title = $jsondec['videoDetails']['title'];
                echo '<div class="search-section">
                    <div class="search-title">'.$title.'</div>';
                echo '<iframe width="1120" height="630" src="https://www.youtube.com/embed/'.$vid_url_split.'" frameborder="0" allowfullscreen></iframe>';
                

                // YOU NEED TO CHECK IF USER HAS COMPLETED QUIZ 
                if (isset($_SESSION["userUid"])){
                    $sql = "SELECT mark FROM user_data WHERE vid_url_id='$vid_url_id'";
                    $result = mysqli_query($conn, $sql);
                    $resultCheck = mysqli_num_rows($result);
                    if ($resultCheck > 0){
                        $row = mysqli_fetch_assoc($result);
                        $mark = $row['mark'];
                        echo '<div class="search-quiz">User has completed this quiz<br>Quiz Result: '.$mark.'%</div>';
                        // get their quiz result
                    }
                    else{
                        echo '<form action="startquiz.php" method="post">
                        <input type="hidden" name="vid_url_id" value='.$vid_url_id.'>
                        <input type="hidden" name="vid_url" value='.$search.'>
                        
                        <button class="create-quiz-button" type="submit" name="start-quiz">Start Quiz for this video</button>
                        </form>';
                    }
                    
                }else {
                    echo '<form action="startquiz.php" method="post">
                    <input type="hidden" name="vid_url_id" value='.$vid_url_id.'>
                    <input type="hidden" name="vid_url" value='.$search.'>
                    
                    <button class="create-quiz-button" type="submit" name="start-quiz">Start Quiz for this video</button>
                    </form>';
                } 
            }
        }
    ?>
    </section>
</div>

<?php
    require 'footer.php';
?>
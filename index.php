<?php
    require 'header.php';
?>

    <main>
        <div class="wrapper-main">
            <section class="section-default">
                <?php
                    if (isset($_SESSION["userUid"])) {
                        echo '<p class="login-status">You are logged in!</p>';
                        $username = ($_SESSION["userUid"]); 
                        echo '<p class="login-status">Welcome '.$_SESSION["userUid"].'!</p>';
                        if (isset($_GET["searchresult=true"]));
                    }
                    else {
                        
                    }
                ?>
            </section>
            <section class="recycler-main">
                <!-- for url in video_links -->
                <!-- get the thumbnail -->
                <!-- get the vid name -->
                <?php 

                include 'includes/dbh-inc.php';
                $sql = "SELECT * FROM video_links";
                $result = mysqli_query($conn, $sql);
                $resultCheck = mysqli_num_rows($result);
                $count = 1;
                if ($resultCheck > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        $vid_url_id = $row['vid_url_id'];
                        $vid_url = $row['vid_url'];
                        $vid_url_split = preg_replace("#.*youtube\.com/watch\?v=#", "", $vid_url);
                        $content = file_get_contents("http://youtube.com/get_video_info?video_id=".$vid_url_split);
                        parse_str($content, $ytarr);
                        $jsondec = json_decode($ytarr['player_response'],true);
                        // echo $jsondec['videoDetails']['title'];
                        $title = $jsondec['videoDetails']['title'];
                        echo '
                        <form action="startquiz.php" method="post">
                            <input type="hidden" name="vid_url_id" value='.$vid_url_id.'>
                            <input type="hidden" name="vid_url" value='.$vid_url.'>
                            <button type="submit" name="quiz-submit-'.$count.'">
                                <div class="quiz-image">
                                    <img name="image" id="'.$count.'" src="http://img.youtube.com/vi/'.$vid_url_split.'/mqdefault.jpg" alt="Take this quiz!">
                                    <h3>'.$title.'</h3>
                                </div>
                            </button>
                        </form>';
                        $count = $count + 1;
                    }
                }
                ?>
            </section>
        </div>
    </main>

<?php
    require 'footer.php';
?>
<?php
    require 'header.php';
?>



<div class="wrapper-main">
    <section class="section-default">
        <?php

            require 'includes/dbh-inc.php';
            
            $vid_url_id = $_POST["vid_url_id"];
            $search = $_POST["vid_url"];
            
            $vid_url_split = preg_replace("#.*youtube\.com/watch\?v=#", "", $_POST["vid_url"]);
            $content = file_get_contents("http://youtube.com/get_video_info?video_id=".$vid_url_split);
            parse_str($content, $ytarr);
            $jsondec = json_decode($ytarr['player_response'],true);
            // echo $jsondec['videoDetails']['title'];
            $title = $jsondec['videoDetails']['title'];
            echo '<div class="create-quiz-for">'.$title.'</div>';

            $sql = "SELECT * FROM questions WHERE vid_url_id='$vid_url_id'";
            $result = mysqli_query($conn, $sql);
            // echo mysqli_fetch_assoc($result);

            $resultCheck = mysqli_num_rows($result);
            if ($resultCheck > 0){
                // echo $resultCheck;
                // $row = mysqli_fetch_assoc($result);
                while($row = mysqli_fetch_assoc($result)){
                    $QuestionId[] = $row['question_id'];
                    $Questions[] = $row['question'];
                    $Answers[] = $row['answer'];
                }
                echo "<div class='quiz-section'>
                <h5 class='question-number'></h5>
                <h3 class='question-header'></h3>
                <div class='quiz-inputs'>
                <input id='answer-input' type='text' placeholder='Answer'>
                <i id='a-submit' type='button' class='material-icons'>create</i>
                </div>
                <div class='w3-light-grey'>
                <div class='w3-grey' style='height:24px;'></div>
                </div><br>
                </div>";
            }
        ?>

    </section>
    <script>
        $(document).ready(function(){
            var vid_url = <?php echo json_encode($search); ?>;
            var vid_url_id = <?php echo json_encode($vid_url_id) ?>;
            var questions_id = <?php echo json_encode($QuestionId); ?>;
            var questions = <?php echo json_encode($Questions); ?>;
            var answers = <?php echo json_encode($Answers); ?>;
            var amount = <?php echo json_encode($resultCheck); ?>;
            var i = 0;
            var correct = 0;
            var inputAnswers = new Array();
            // alert(questions[0]);
            // alert(questions[1]);
            $(".question-number").text("Question " + (i+1));
            $(".question-header").text(questions[i]);
            $("#a-submit").click(function(){
                if(i<amount){
                    // alert(i);
                    var answer = $("#answer-input").val();
                    if (answer == ""){
                        alert("Please fill in answer.")
                    }else {
                        inputAnswers.push(answer);
                        // alert(inputAnswers[i]);
                        if(answer.toUpperCase() == (answers[i]).toUpperCase()){
                            alert("CORRECT ANSWER!");
                            correct++;
                        }
                        else{
                            alert("INCORRECT ANSWER! The correct answer was: " + answers[i]);
                        }
                        i++; 
                        $("#answer-input").val('');
                        $(".question-number").text("Question " + (i+1));
                        var value = ((i/amount)*100);
                        $(".w3-grey").width(value + '%');
                        $(".question-header").text(questions[i]);
                        }
                }
                if (i == amount){
                    var percent = ((correct/amount)*100);
                    alert('WELL DONE, you achieved: ' + percent + '%');
                    $(".question-number").text("Completed");
                    $(".question-header").text('You achieved: ' + percent + '%');
                    $(".quiz-inputs").hide();
                     //update the database if user is logged in
                    <?php
                        if (isset($_SESSION["userUid"])) {
                            $username = $_SESSION["userUid"];
                        }
                        else {
                            $username = -1;
                        }
                    ?>
                    
                    var username = <?php echo json_encode($username); ?>;
                    
                    

                    if (username != -1){
                        $.ajax({  
                        url:"includes/startquiz-inc.php",  
                        method:"GET",
                        // data:$('#add_qa').serialize(),
                        data:"&username=" + username + "&percentage=" + percent + "&vid-url-id=" + vid_url_id,  
                        success:function(data) {  
                            alert(data);  
                            }  
                        });  
                    }
                }
            });
            
            
            // $(".quiz-form").submit(function(){
            //     var $answer = $(".quiz-form :input").text();
            //     alert($answer);
            //     var values = {};
            //     $answer.each(function() {
            //         values[this.name] = $(this).val();
            //     });
            //     alert(values[0]);
            // });
        });
    </script>
</div>

<?php
    require 'footer.php';
?>




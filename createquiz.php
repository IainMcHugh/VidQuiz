<?php
    require 'header.php';
?>


<div class="wrapper-main">
    <div class="create-quiz-title">Create a Quiz!</div>
    <section class="section-default">
        <?php
            $search = $_POST["vid_url"];
            
            $vid_url_split = preg_replace("#.*youtube\.com/watch\?v=#", "", $_POST["vid_url"]);
            $content = file_get_contents("http://youtube.com/get_video_info?video_id=".$vid_url_split);
            parse_str($content, $ytarr);
            $jsondec = json_decode($ytarr['player_response'],true);
            // echo $jsondec['videoDetails']['title'];
            $title = $jsondec['videoDetails']['title'];
            echo '<div class="create-quiz-for">Creating a quiz for: <b>'.$title.'</b></p>';
        ?>

        <div class="qa-container">
            <div class="table-heading">
                <div>Question</div>
                <div>Answer</div>
                <div>New</div>
            </div>
            <form name="add_qa" id="add_qa" class="add-qa">
                <div class="dynamic-table">
                    <div class="dynamic-table-flex">
                        <input type="hidden" name="search" value="<?php echo $search ?>">
                        <input type="text" name="question[]" placeholder="Enter your Question" class="form-control question_list" />
                        <input type="text" name="answer[]" placeholder="Enter the Answer" class="form-control answer_list" />
                        <button type="button" name="add" id="add" class="btn btn-success">
                        <i id='btn-success' type='button' class='material-icons'>add_circle</i>
                        </button>
                    </div>
                </div>
            </form>    
        </div>
        <input type="button" name="submit-qa" id="submit-qa" class="btn btn-info" value="Submit" />
    </section>
    <script>  
        $(document).ready(function(){  
            var i=1;  
            $('#btn-success').click(function(){  
                i++;
                $(".dynamic-table").append('<div id="row'+i+'"><input type="text" name="question[]" placeholder="Enter your Question" class="form-control question_list" /><input type="text" name="answer[]" placeholder="Enter the Answer" class="form-control answer_list" /><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove"><i id="btn-delete" type="button" class="material-icons">clear</i></button></div>');
            });  
            $(document).on('click', '.btn_remove', function(){  
                var button_id = $(this).attr("id");   
                $('#row'+button_id+'').remove();  
            });  
            $('#submit-qa').click(function(){         
                $.ajax({  
                        url:"includes/createquiz-inc.php",  
                        method:"POST",
                        // data:$('#add_qa').serialize(),
                        data:$('#add_qa').serialize(),  
                        success:function(data)  
                        {  
                            alert(data);  
                            $('#add_qa')[0].reset();  
                        }  
                });  
            });  
        });  
    </script>
</div>

<?php
    require 'footer.php';
?>

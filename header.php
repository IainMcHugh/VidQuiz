<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="https://fonts.googleapis.com/css?family=Titillium+Web&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
        <title>Youtube Quiz</title>
        <link rel="shortcut icon" href="images/question_favicon.png" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    </head>
    <body> 
        <header>
            <div class="header-fixed">
                <nav class="nav-header-main">
                    <a href="index.php">YoutubeQuiz</a>
                    <form action="search.php" method="post">
                            <input type="text" name="search" placeholder="Enter a Youtube URL...">
                            <button type="submit" name="search-submit">Search</button>
                    </form>
                </nav>   
                <div class="header-login">
                    <?php
                        if (isset($_SESSION["userUid"])) {
                            echo '<div><a href="user.php"><i class="material-icons">
                            account_circle
                            </i></a>
                            <form class="form-signout" action="includes/logout-inc.php" method="post">
                            <button type="submit" name="logout-submit">Sign out</button>
                        </form>
                        </div>';
                        }
                        else {
                            echo '<div><form action="includes/login-inc.php" method="post">
                            <input type="text" name="email" placeholder="Enter email">
                            <input type="password" name="pwd" placeholder="Enter password">
                            <button type="submit" name="login-submit">Sign in</button>
                        </form>
                        </div>
                        <a href="createaccount.php">Create Account</a>';
                        }
                    ?>
                    
                </div>
            </div>
        </header>
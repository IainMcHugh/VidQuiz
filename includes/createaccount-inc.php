<?php

if (isset($_POST['createaccount-submit'])) {

    require 'dbh-inc.php';

    $username = $_POST["uid"];
    $email = $_POST["email"];
    $password = $_POST["pwd"];
    $repassword = $_POST["pwd-repeat"];

    if (empty($username) || empty($email) || empty($password) || empty($repassword)) {
        header("Location: ../createaccount.php?error=emptyfields&uid=".$username."&email=".$email);
        exit(); 
    }

    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        header("Location: ../createaccount.php?error=invaliduidemail");
        exit();
    }

    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../createaccount.php?error=invalidemail&uid=".$username);
        exit();
    }

    elseif(!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        header("Location: ../createaccount.php?error=invaliduid&email=".$email);
        exit();
    }

    elseif($password != $repassword){
        header("Location: ../createaccount.php?error=pwdcheck&uid=".$username."&email=".$email);
        exit(); 
    }

    else {
        $sql =  "SELECT uidUsers FROM users WHERE uidUsers=?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../createaccount.php?error=sqlerror");
            exit();
        }
        else {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt);
            if ($resultCheck > 0 ){
                header("Location: ../createaccount.php?error=usertaken&email=".$email);
                exit();
            }
            else {
                $sql =  "INSERT INTO users (uidUsers, emailUsers, pwdUsers) VALUES (?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    header("Location: ../createaccount.php?error=sqlerror");
                    exit();
                }
                else { // need to hash users password before saving to db
                    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
                    
                    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPwd);
                    mysqli_stmt_execute($stmt);

                    session_start();
                    $_SESSION["userUid"] = $username;
                    header("Location: ../index.php?login=success");
                    exit();
                }
            }
        }
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    
}

else {
    header("Location: ../signup.php");
    exit();
}
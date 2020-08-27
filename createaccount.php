<?php
    require 'header.php';
?>

    <main>
        <div class="wrapper-main">
            <h1>Create an Account</h1>
            <form class="form-create-account" action="includes/createaccount-inc.php" method="post">
                <input type="text" name="uid" placeholder="Enter Username">
                <input type="text" name="email" placeholder="Enter email">
                <input type="password" name="pwd" placeholder="Enter password">
                <input type="password" name="pwd-repeat" placeholder="Re-enter password">
                <button type="submit" name="createaccount-submit">Create Account</button>
            </form>
        </div>
    </main>

<?php
    require 'footer.php';
?>
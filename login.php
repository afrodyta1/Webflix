<?php
# DISPLAY COMPLETE LOGIN PAGE.
# Include HTML static file login.php
include ('includes/login.php');

# Display any error messages if present.
if (isset($errors) && !empty($errors)) {
    ?>
    <div class="container-sm" >
        <div class="col-sm">
            <?php
//          Display error messages to user 
            echo "<div class='alert alert-danger'>";
            echo '<h1>Error!</h1><p id="err_msg">Oops! There was a problem:<br>';
            foreach ($errors as $msg) {
                echo "<span class='glyphicon glyphicon-ok'></span>&nbsp;" . $msg . "<br>";
            }
            echo 'Please try again or <a href="register.php">Register</a></p>';
            echo "</div>";
            ?>
        </div>
    </div>
    <?php
}
?>
<!-- Display form to user -->
<h1 style='text-align:center; margin-top: 100px; margin-bottom:100px'>Login</h1>
<div class="container">
    <div class="col-sm">
        <form action="login_action.php" method="post" class="alert-dismissible fade show" role="alert" >
            <div class="mb-3">
                <label class="form-label">Email address</label>
                <input type="email" class="form-control" name="email" placeholder="email@example.com">
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="pass" placeholder="Password">
            </div>
            <button style='margin-bottom:600px' type="submit" class="btn " id="button1" value="Login" >Sign in</button>

        </form>
    </div>
</div>
<?php
include ( 'includes/footer.html' );
?>

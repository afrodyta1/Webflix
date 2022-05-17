<?php
# DISPLAY COMPLETE LOGGED OUT PAGE.
# Access session.
session_start();
# Redirect if not logged in.
if (!isset($_SESSION['user_id'])) {
    require ( 'login_tools.php' );
    load();
}
# Set page title and display header section.
$page_title = 'LogOut';
include ( 'includes/login.php' );

# Clear existing variables.
$_SESSION = array();
# Destroy the session.
session_destroy();

# Display body section.
?>
<h1 style='text-align:center; padding-top: 250px; margin-bottom:30px' >Goodbye!</h1>
<h5 style='text-align:center; margin-bottom:50px' >You are now logged out.</h5>
<div class="container" style='text-align:center; margin-bottom:300px'>
    <a href=" <?php login . php ?> "><button style='margin-bottom:600px' type="submit" class="btn " id="button1" value="Login" >Login</button></a>
</div>
<?php
# Display footer section.
include ( 'includes/footer.html' );
?>

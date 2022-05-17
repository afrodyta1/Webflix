<?php

# Access session.
session_start();

# Redirect if not logged in.
if (!isset($_SESSION['user_id'])) {
    require ( 'login_tools.php' );
    load();
}

$userID = $_SESSION['user_id'];

# Check form submitted.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    # Connect to the database.
    require ('includes/connect_db.php');


    $id = mysqli_real_escape_string($link, trim($_POST['tv_show_id']));
# On success id into 'webflix_movies' database table.
    if (empty($errors)) { // deletes episodes belonging to the TV Show being deleted. 
        $q = "DELETE FROM webflix_tv_shows WHERE tv_show_id='$id'";
        $r = @mysqli_query($link, $q);
        if ($r) {
            $q1 = "DELETE FROM webflix_episode WHERE tv_show_id='$id'"; 
            $r1 = @mysqli_query($link, $q1);
            if ($r1) { 
                header("Location: admin_dashboard.php"); //take user back to admin dashboard 
            }
        }

# Close database connection.
        mysqli_close($link);
    }
}
?>
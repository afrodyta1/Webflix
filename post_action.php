<?php

# Access session.
session_start();

# Redirect if not logged in.
if (!isset($_SESSION['user_id'])) {
    require ( 'login_tools.php' );
    load();
}
# Open database connection.
require ( 'includes/connect_db.php' );
# Check form submitted.
if ($_SERVER['REQUEST_METHOD'] = 'POST') {
# Execute inserting into 'review' database table.
    $q = "INSERT INTO mov_rev(id,first_name,last_name,movie_title,rate, message, post_date) 
VALUES('{$_SESSION[user_id]}',
'{$_SESSION[first_name]}',
'{$_SESSION[last_name]}',
'{$_POST[movie_title]}',
'{$_POST[rate]}',
'{$_POST[message]}',NOW() )";
    $r = mysqli_query($link, $q);
# Report error on failure.
    if (mysqli_affected_rows($link) != 1) {
        echo '<p>Error</p>' . mysqli_error($link);
    } else {
        header("Location: review.php");
        //include('review.php');
    }
}
?>

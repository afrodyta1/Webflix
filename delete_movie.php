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


    $id = mysqli_real_escape_string($link, trim($_POST['movie_id']));
# On success id into 'webflix_movies' database table.
    if (empty($errors)) {
        $q = "DELETE FROM webflix_movies WHERE movie_id='$id'";
        $r = @mysqli_query($link, $q);
        if ($r) {
            header("Location: admin_dashboard.php");
        }

# Close database connection.
        mysqli_close($link);
    }
}
?>
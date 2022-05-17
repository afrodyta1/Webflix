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

# Initialize an error array.
    $errors = array();

    # Check for an user_id :
    if (empty($_POST['user_id'])) {
        $errors[] = 'Enter the id of the user you want to delete.';
    } else {
        $id = mysqli_real_escape_string($link, trim($_POST['user_id']));
    }


# On success id into 'users' database table.
    if (empty($errors)) {
        $q = "DELETE FROM webflix_users WHERE user_id='$id'";
        $r = @mysqli_query($link, $q);
        if ($r) {
            header("Location: admin_dashboard.php");
        } else {
            echo "Error deleting record: " . $link->error;
        }


# Close database connection.

        mysqli_close($link);
        exit();
    }

# Or report errors.
    else {
        echo ' <div class="container"><div class="alert alert-dark alert-dismissible fade show"> <button type="button" class="close" data-dismiss="alert">&times;</button><h1><strong>Error!</strong></h1><p>The following error(s) occurred:<br>';
        foreach ($errors as $msg) {
            echo " - $msg<br>";
        }
        echo 'Please try again.</div></div>';
        # Close database connection.
        mysqli_close($link);
    }
}
?>

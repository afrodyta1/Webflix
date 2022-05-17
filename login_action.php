<?php

# Check form submitted.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
# Open database connection.
    require ( 'includes/connect_db.php' );
# Get connection, load, and validate functions.
    require ( 'login_tools.php' );
# Check login.
    list ( $check, $data ) = validate($link, $_POST['email'], $_POST['pass']);
    # On success set session data and display logged in page.
    if ($check) {
        # Access session.
        session_start();
        $_SESSION['user_id'] = $data['user_id'];
        $_SESSION['first_name'] = $data['first_name'];
        $_SESSION['surname'] = $data['surname'];
        $_SESSION['role_id'] = $data['role_id'];
        $_SESSION['status'] = $data['status'];
        $id = $_SESSION['user_id'];
        $q = "SELECT webflix_users.user_id, webflix_users.status, webflix_payment.endDate FROM webflix_users INNER JOIN webflix_payment ON webflix_users.user_id=webflix_payment.user_id WHERE webflix_users.user_id=$id";
        $r = mysqli_query($link, $q);
        if (@mysqli_num_rows($r) == 1) {
            $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
            $subscriptionEnd = $row['endDate'];
            $currentDate = date('c');
            if ($subscriptionEnd < $currentDate) {
                $q1 = "UPDATE webflix_users set status='inactive' WHERE user_id=$id";
                $r1 = @mysqli_query($link, $q1);
                if ($r1) {
                    load('index.php');
                }
                load('index.php');
            }
            load('index.php');
        }
        load('index.php');
    }
    # Or on failure set errors.
    else {
        $errors = $data;
    }

    # Close database connection.
    mysqli_close($link);
}

# Continue to display login page on failure.
include ( 'login.php' );
?>
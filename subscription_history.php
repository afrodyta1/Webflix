<?php
session_start();
# DISPLAY COMPLETE REGISTRATION PAGE.
$page_title = 'My Subscription History';
include('includes/logout.php');


# Redirect if not logged in.
if (!isset($_SESSION['user_id'])) {
require ( 'login_tools.php' );
load();
}

# Display body section.
echo "<h1 style='text-align:center; '>Subscription History</h1>";

# Open database connection.
require ( 'includes/connect_db.php' );
# Retrieve items from 'booking' database table.
$q = "SELECT * FROM webflix_payment WHERE user_id={$_SESSION[user_id]}
ORDER BY date DESC";
$r = mysqli_query($link, $q);
if (mysqli_num_rows($r) > 0) {
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
//    display payment history to user
echo '<div class="container">
    <div id="background1" class="alert " role="alert">
        <ul class="list-group list-group-flush" id="background1">
            <li class="list-group-item" id="background1">
                <div class="form-group row" id="background1">
                    <h5 for="booking ref" class="col-sm-12 ">
                        Booking Reference:  #PAY1000' . $row['payment_id'] . '</h5> 
                </div>
            </li>
            <li class="list-group-item" id="background1">
                <div class="form-group row" id="background1">
                    <h5 for="booking ref" class="col-sm-12 ">
                        Total Paid:   &pound 99.99 
                    </h5>
                </div>
            </li>
        </ul>
        <hr>
        <div class="card-footer">
            <p> Start date of subscription: ' . $row['date'] . '</p>
            <p> End date of subscription: ' . $row['endDate'] . '</p>
        </div>
    </div>
</div>
';
}
# Close database connection.
mysqli_close($link);
} 
include('includes/footer.html');
?>

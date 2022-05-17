<?php
session_start(); # DISPLAY COMPLETE REGISTRATION PAGE.
$page_title = 'User Area ';
include('includes/logout.php');
# Access session.
# Redirect if not logged in.
if (!isset($_SESSION['user_id'])) {
    require ( 'login_tools.php' );
    load();
}

# Open database connection.
require ( 'includes/connect_db.php' );

# Display body section.
echo "<h1 style='text-align:center; '>User Details</h1>";
$userID = $_SESSION['user_id'];
if (array_key_exists('btnChangePassword', $_POST)) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

# Initialize an error array.
        $errors = array();
# Check for a password and matching input passwords.
        if (!empty($_POST['pass1'])) {
            if ($_POST['pass1'] != $_POST['pass2']) {
                $errors[] = 'Passwords do not match.';
            } else {
                if (strlen($_POST['pass1']) < 6) {
                    $errors[] = 'Password need to be more than 6 characters in length';
                } else {
                    $pass = mysqli_real_escape_string($link, trim($_POST['pass1']));
                }
            }
        } else {
            $errors[] = 'Enter your password.';
        }

# On success card details into 'users' database table.
        if (empty($errors)) {
            $q = "UPDATE webflix_users SET password= SHA2('$p',256) WHERE user_id='$userID'";
            $r = @mysqli_query($link, $q);
            ?>
            <div class="container-sm" >
                <div class="col-sm">
                    <?php
                    echo "<div class='alert alert-success'>";
                    echo '<h1>Password updated</h1>';
                    echo "</div>";
                    ?>
                </div>
            </div>
            <?php
        }

# Or report errors.
        else {
            ?>
            <div class="container-sm" >
                <div class="col-sm">
                    <?php
                    echo "<div class='alert alert-danger'>";
                    echo '<h1>Error!</h1><p id="err_msg">The following error(s) occurred:<br>';
                    foreach ($errors as $msg) {
                        echo "<span class='glyphicon glyphicon-ok'></span>&nbsp;" . $msg . "<br>";
                    }
                    echo 'Please try again.</p>';
                    echo "</div>";
                    ?>
                </div>
            </div>
            <?php
        }
    }
} else {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        # Initialize an error array.
        $errors = array();

        # Check for an card_number :
        if (empty($_POST['card_number'])) {
            $errors[] = 'Enter your card_number.';
        } else {
            if (strlen($_POST['card_number']) == 16) {
                $c = mysqli_real_escape_string($link, trim($_POST['card_number']));
            } else {
                $errors[] = 'The card number must have 16 numbers.';
            }
        }

        # Check if the card is expired:
        if (empty($_POST['exp_month']) || empty($_POST['exp_year'])) {
            $errors[] = 'Enter the expir month and year.';
        } else {
            $expires = DateTime::createFromFormat('my', $_POST['exp_month'] . $_POST['exp_year']);
            $now = new DateTime();
            if ($expires < $now) {
                $errors[] = 'This card is expired.';
            } else {
                $em = mysqli_real_escape_string($link, trim($_POST['exp_month']));
                $ey = mysqli_real_escape_string($link, trim($_POST['exp_year']));
            }
        }

        # Check for an CVV:
        if (empty($_POST['cvv'])) {
            $errors[] = 'Enter the CVV number.';
        } else {
            if (!preg_match('/^[0-9]{3}$/', $_POST['cvv'])) {
                $errors[] = 'CVV number entered is not valid.';
            } else {
                $cvv = mysqli_real_escape_string($link, trim($_POST['cvv']));
            }
        }

        # On success card details into 'users' database table.
        if (empty($errors)) {
            $q = "INSERT INTO `webflix_payment`(`user_id`, `date`, `endDate` ) VALUES ('$userID', NOW(), NOW()+INTERVAL 365 DAY)";
            $r = @mysqli_query($link, $q);
            if ($r) {
                $q = "UPDATE webflix_users SET status='active' WHERE user_id='$userID'";
                $r = @mysqli_query($link, $q);
                ?>
                <div class="container-sm" >
                    <div class="col-sm">
                        <?php
                        echo "<div class='alert alert-success'>";
                        echo '<h1>Subscription purchased</h1>';
                        echo "</div>";
                        ?>
                    </div>
                </div>
                <?php
            } else {
                echo "Error updating record: " . $link->error;
            }
        }

        # Or report errors.
        else {
            ?>
            <div class="container-sm" >
                <div class="col-sm">
                    <?php
                    echo "<div class='alert alert-danger'>";
                    echo '<h1>Error!</h1><p id="err_msg">The following error(s) occurred:<br>';
                    foreach ($errors as $msg) {
                        echo "<span class='glyphicon glyphicon-ok'></span>&nbsp;" . $msg . "<br>";
                    }
                    echo 'Please try again.</p>';
                    echo "</div>";
                    ?>
                </div>
            </div>
            <?php
        }
    }
}
$q1 = "SELECT * FROM webflix_users WHERE user_id={$_SESSION[user_id]}";
$r1 = mysqli_query($link, $q1);
?>
<div class="container" style="margin-bottom: 200px; margin-top: 200px">
    <div class="row">
        <?php
        if (mysqli_num_rows($r1) > 0) {

            while ($row1 = mysqli_fetch_array($r1, MYSQLI_ASSOC)) {
                echo '
                    <div class="col">
                        <div id="background1" class=" alert alert-dark" role="alert">
                            <h5>' . $row1['first_name'] . ' ' . $row1['surname'] . '</h5> 
                            <p> User ID : ' . $row1['user_id'] . ' </p>
                            <p> Email : ' . $row1['email'] . ' </p>
                            <p> Registration Date : ' . $row1['join_date'] . ' </p>
                            <button type="button" class="btn" id="button1" data-toggle="modal" data-target="#password"> Change Password </button>
                        </div>
                    </div>
                    ';
            }
        } else {
            echo '<h3>No user details.</h3>';
        }

# Retrieve items from 'webflix_payment' database table.
        $q = "SELECT webflix_payment.`payment_id`, webflix_payment.`user_id`, webflix_payment.`date`, webflix_payment.`endDate`,  webflix_users.status FROM `webflix_payment` INNER JOIN webflix_users ON webflix_payment.`user_id`=webflix_users.user_id  WHERE webflix_users.user_id={$_SESSION[user_id]} AND webflix_users.status = 'active' ORDER BY webflix_payment.`payment_id` DESC LIMIT 1";
        $r = mysqli_query($link, $q);
        if (mysqli_num_rows($r) > 0) {
            while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                echo '
                    <div class="col">
                        <div id="background1" class="alert alert-dark" role="alert">
                            <h5>Subscription Details</h5>
                            <p> Subscription Status : ' . $row['status'] . ' </p>
                            <p> Subscription Start Date : ' . $row['date'] . ' </p>
                            <p> Subscription End Date : ' . $row['endDate'] . ' </p>
                            <a href="subscription_history.php"><button class="btn" id="button1"> View Subscription History </button><a>
                        </div>
                    </div>
                    ';
            }
        } else {
            # Retrieve items from 'webflix_users' database table.
            $q2 = "SELECT *FROM  webflix_users WHERE webflix_users.user_id={$_SESSION[user_id]} AND webflix_users.status = 'inactive'";
            $r2 = mysqli_query($link, $q2);
            if (mysqli_num_rows($r2) > 0) {
                while ($row2 = mysqli_fetch_array($r2, MYSQLI_ASSOC)) {
                    echo'
                        <div class = "col">
                            <div id = "background1" class = " alert alert-dark" role = "alert">
                                <h5>Subscription Details</h5>
                                <p> Subscription Status : ' . $row2['status'] . ' </p>
                                <p> Subscription for £99.99 for 1 year.</p>
                                <button type="button" class="btn" id="button1" data-toggle="modal" data-target="#subscription"> Buy Subscription </button>
                            </div>
                        </div>';
                }
            }
        }
        ?>
    </div>
</div>
<!-- pop up box to change password -->
<div class="modal fade" id="password" tabindex="-1" role="dialog" aria-labelledby="password" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div id="background2" class="modal-content" >
            <form  action="user.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Change Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <input type="password"  name="pass1" 
                               class="form-control"  
                               placeholder="New Password" 				
                               value="<?php if (isset($_POST['pass1'])) echo $_POST['pass1']; ?>" 
                               required>
                    </div>
                    <div class="form-group">
                        <input type="password" 
                               name="pass2" 
                               class="form-control" 
                               placeholder="Confirm New Password"
                               value="<?php if (isset($_POST['pass2'])) echo $_POST['pass2']; ?>" 
                               required>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group">
                        <input type="submit" 
                               name="btnChangePassword" 
                               class="btn btn-block" id="button1" value="Save Changes"/>
                    </div>
                </div>
            </form>
        </div><!--Close body-->
    </div><!--Close modal-body-->
</div><!-- Close modal-fade-->

<!-- pop up box to buy subscription -->
<div class="modal fade" id="subscription" tabindex="-1" role="dialog" aria-labelledby="subscription" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div id="background2" class="modal-content" >
            <form  action="user.php" method="post">
                <div class="modal-header">
                    <h5>Buy Annual Subscription</h5>
                    <p><br>For just £99.99</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text"  name="card_number" 
                               class="form-control"  
                               placeholder="Card Number" 				
                               value="<?php if (isset($_POST['card_number'])) echo $_POST['card_number']; ?>" 
                               required>
                    </div>
                    <div class="form-group">
                        <input type="text"  name="exp_month" 
                               class="form-control"  
                               placeholder="Expire Month" 				
                               value="<?php if (isset($_POST['exp_month'])) echo $_POST['exp_month']; ?>" 
                               required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="exp_year" 
                               class="form-control" 
                               placeholder="Expire Year"
                               value="<?php if (isset($_POST['exp_year'])) echo $_POST['exp_year']; ?>" 
                               required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="cvv" 
                               class="form-control" 
                               placeholder="CVV Code"
                               value="<?php if (isset($_POST['cvv'])) echo $_POST['cvv']; ?>" 
                               required>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group">
                        <!--<button style='margin-bottom:100px' type="submit" class="btn " id="button1" value="Confirm" >Confirm</button>-->
                        <input type="submit" 
                               name="btnBuySubscription" 
                               class="btn btn-block" id="button1" value="Confirm"/>
                    </div>
                </div>
            </form>
        </div><!--Close body-->
    </div><!--Close modal-body-->
</div><!-- Close modal-fade-->
<?php
# Display footer section.
include ( 'includes/footer.html' );
?>
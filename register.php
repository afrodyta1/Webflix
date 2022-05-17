<?php
# Include HTML static file login.html
include ( 'includes/login.php' );

# Check form submitted.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
# Connect to the database.
    require ('includes/connect_db.php');
    # Initialize an error array.
    $errors = array();
# Check for a first name.
    if (empty($_POST['first_name'])) {
        $errors[] = 'Enter your first name.';
    } else {
        if (!preg_match("/^[a-zA-Z ]+$/", $_POST['first_name'])) {
            $errors[] = 'First name must contain only alphabets and space.';
        } else {
            $fn = mysqli_real_escape_string($link, trim($_POST['first_name']));
        }
    }

    # Check for a last name.
    if (empty($_POST['last_name'])) {
        $errors[] = 'Enter your last name.';
    } else {
        if (!preg_match("/^[a-zA-Z ]+$/", $_POST['last_name'])) {
            $errors[] = 'Last name must contain only alphabets and space.';
        } else {
            $ln = mysqli_real_escape_string($link, trim($_POST['last_name']));
        }
    }

    # Check for a email.
    if (empty($_POST['email'])) {
        $errors[] = 'Enter your email.';
    } else {
        $email = mysqli_real_escape_string($link, trim($_POST['email']));
    }

    # Check for a date of birth.
    if (empty($_POST['birthday'])) {
        $errors[] = 'Pick your birthday.'; #
    } else {
        $birthday = trim(date('Y-m-d', strtotime($_POST['birthday'])));
        $age = floor((time() - strtotime($birthday)) / 31556926); // the number of second is a year "31556926"
        if ($age >= 18) {
            $birthday = mysqli_real_escape_string($link, trim(date('Y-m-d', strtotime($_POST['birthday']))));
        } else {
            $errors[] = 'You must be 18 years old or over to register.';
        }
    }

    # Check for a contact number.
    if (empty($_POST['contact_number1'])) {
        $errors[] = 'Enter your contact number.';
    } else {
        if (strlen($_POST['contact_number1']) < 10) {
            $errors[] = 'Mobile number must have more then 10 characters.';
        } else {
            $number = mysqli_real_escape_string($link, trim($_POST['contact_number1']));
        }
    }

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

# Check for a country of residence .
    if ($_POST['country_of_residence'] === "Choose one") {
        $errors[] = 'Enter your country of residence.';
    } else {
        $country = mysqli_real_escape_string($link, trim($_POST['country_of_residence']));
    }

# Check if email address already registered.
    if (empty($errors)) {
        $q = "SELECT user_id FROM webflix_users WHERE email='$email'";
        $r = @mysqli_query($link, $q);
        if (mysqli_num_rows($r) != 0)
            $errors[] = 'Email address already registered. <a href="login.php">Login</a>';
    }

# On success register user inserting into 'webflix_users' database table.
    if (empty($errors)) {
        $q = "INSERT INTO webflix_users (role_id, first_name, surname, date_of_birth, email, contact_number, password, join_date, country_of_residence, status) VALUES ( 2, '$fn', '$ln', '$birthday', '$email', '$number', SHA2('$pass',256), NOW(), '$country', 'inactive')";
        $r = @mysqli_query($link, $q);
        if ($r) {
            echo '<h1 style="text-align:center; margin-top: 100px; margin-bottom:50px">Registered!</h1>'
            . '<h5 style="text-align:center; margin-top: 100px; margin-bottom:50px">You are now registered.</h5>';
            ?>
            <div class="container" style='text-align:center'>
                <a href="login.php"><button style='margin-bottom:600px' class="btn " id="button1" value="Login" >Login</button></a>

            </div>
            <?php
        }
        # Close database connection.
        mysqli_close($link);
        exit();
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
        # Close database connection.
        mysqli_close($link);
    }
}
?>
<!-- display form to user -->
<h1 style='text-align:center; margin-top: 100px; margin-bottom:50px' >Register</h1>
<div class="container" style='margin-bottom:100px'>
    <div class="col-sm">
        <form action="register.php" method="post" class="alert-dismissible fade show" role="alert" >
            <div class="mb-3">
                <label  class="form-label">First Name</label>
                <input type="text" class="form-control" name="first_name" placeholder="First Name" value="<?php if (isset($_POST['first_name'])) echo $_POST['first_name']; ?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">Last Name</label>
                <input type="text" class="form-control" name="last_name" placeholder="Last Name" value="<?php if (isset($_POST['last_name'])) echo $_POST['last_name']; ?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">Email address</label>
                <input type="email" class="form-control"  name="email" placeholder="email@example.com" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>">
            </div>
            <div class="mb-3">
                <!>
                <label for="birthday">Birthday:</label>
                <input type="date" class="form-control datepicker" name="birthday" placeholder="dd-mm-yyyy" >
            </div>
            <div class="mb-3">
                <label  class="form-label">Contact Number</label>
                <input type="text" class="form-control"  name="contact_number1" placeholder="Contact Number" value="<?php if (isset($_POST['contact_number1'])) echo $_POST['contact_number1']; ?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">Password</label>
                <input type="password" class="form-control" name="pass1" placeholder="Password" value="<?php if (isset($_POST['pass1'])) echo $_POST['pass1']; ?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">Confirm Password</label>
                <input type="password" class="form-control" name="pass2" placeholder="Confirm Password" value="<?php if (isset($_POST['pass2'])) echo $_POST['pass2']; ?>">
            </div>
            <div class="mb-3">
                <!foreach loop pulls data from $data array (from json file>
                <label  class="form-label">Country of residence</label>
                <select name="country_of_residence" id="country_of_residence">
                    <option selected="selected">Choose one</option>
                    <?php foreach ($data as $country) { ?>
                        <option value="<?= $country["name"] ?>"><?= $country["name"] ?></option>
                    <?php }
                    ?>
                </select>
            </div>
            <button style='margin-bottom:100px' type="submit" class="btn " id="button1" value="Register" >Register</button>
        </form>
    </div>
</div>
<?php
include ( 'includes/footer.html' );
?>

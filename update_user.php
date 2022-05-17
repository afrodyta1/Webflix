<?php
session_start(); # DISPLAY COMPLETE REGISTRATION PAGE.
$page_title = 'Edit User';
include('includes/logout.php');
# Access session.
# Redirect if not logged in.
if (!isset($_SESSION['user_id'])) {
    require ( 'login_tools.php' );
    load();
}

# Connect to the database.
require ('includes/connect_db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM webflix_users WHERE user_id=$id";
    $result = @mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);

    $role_id = $row['role_id'];
    $first_name = $row['first_name'];
    $surname = $row['surname'];
    $date_of_birth = $row['date_of_birth'];
    $email = $row['email'];
    $contact_number = $row['contact_number'];
    $join_date = $row['join_date'];
    $country_of_residence = $row['country_of_residence'];
    $status = $row['status'];

# Check form submitted.
    if (isset($_POST['submit'])) {
        # Initialize an error array.
        $errors = array();
        # Update for role id.
        if (empty($_POST['role_id'])) {
            $errors[] = 'Enter users role id.';
        } else {
            $roleId = mysqli_real_escape_string($link, trim($_POST['role_id']));
        }
        # Check for a first name.
        if (empty($_POST['first_name'])) {
            $errors[] = 'Enter users first name.';
        } else {
            $fn = mysqli_real_escape_string($link, trim($_POST['first_name']));
        }
        # Check for a last name.
        if (empty($_POST['surname'])) {
            $errors[] = 'Enter users last name.';
        } else {
            $ln = mysqli_real_escape_string($link, trim($_POST['surname']));
        }
        # Check for a email.
        if (empty($_POST['email'])) {
            $errors[] = 'Enter users email.';
        } else {
            $email = mysqli_real_escape_string($link, trim($_POST['email']));
        }

        # Check for a date of birth.
        if (empty($_POST['birthday'])) {
            $errors[] = 'Enter users birthday.';
        } else {
            $birthday = mysqli_real_escape_string($link, trim(date('Y-m-d', strtotime($_POST['birthday']))));
        }

        # Check for a contact number.
        if (empty($_POST['contact_number'])) {
            $errors[] = 'Enter user contact number.';
        } else {
            $number = mysqli_real_escape_string($link, trim($_POST['contact_number']));
        }

        # Update for a Join Date.
        if (empty($_POST['join_date'])) {
            $errors[] = 'Enter users join date.';
        } else {
            $joinDate = mysqli_real_escape_string($link, trim($_POST['join_date']));
        }

# Check for a country of residence .
        if (empty($_POST['country_of_residence'])) {
            $errors[] = 'Enter users country of residence.';
        } else {
            $country = mysqli_real_escape_string($link, trim($_POST['country_of_residence']));
        }

        # Update for a status.
        if (empty($_POST['status'])) {
            $errors[] = 'Enter users status.';
        } else {
            $status = mysqli_real_escape_string($link, trim($_POST['status']));
        }

# On success register user inserting into 'webflix_users' database table.
        if (empty($errors)) {
            $q = "UPDATE webflix_users set role_id='$roleId', first_name='$fn', surname='$ln', date_of_birth='$birthday', email='$email', contact_number='$number', join_date='$joinDate', country_of_residence='$country', status='$status' WHERE user_id=$id";
            $r = @mysqli_query($link, $q);
            if ($r) {
                ?>
                <div style='margin-bottom:50px' class="container-sm" >
                    <div class="col-sm">
                        <?php
                        echo "<div class='alert alert-success'>";
                        echo '<h1 style="text-align:center; margin-top: 100px; margin-bottom:50px">Updated Successfully</h1>';
                        ?>
                        <div class="container" style='text-align:center'>
                            <a href="admin_dashboard.php"><button style='margin-bottom:50px' class="btn " id="button1" value="Dashboard" >Dashboard</button></a>
                        </div>
                        <?php
                        echo "</div>";
                        ?>
                    </div>
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
//                  display error messages to user
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
}
?>
<h1 style='text-align:center; margin-top: 100px; margin-bottom:50px' >Edit User</h1>
<!-- display edit user form to user -->
<div class="container" style='margin-bottom:100px'>
    <div class="col-sm">
        <form method="post" class="alert-dismissible fade show" role="alert" >
            <div class="mb-3">
                <label  class="form-label">Role ID</label>
                <input type="text" class="form-control" name="role_id" value="<?php echo $role_id; ?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">First Name</label>
                <input type="text" class="form-control" name="first_name" value="<?php echo $first_name; ?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">Last Name</label>
                <input type="text" class="form-control" name="surname" value="<?php echo $surname; ?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">Email address</label>
                <input type="email" class="form-control"  name="email" value="<?php echo $email; ?>">
            </div>
            <div class="mb-3">
                <label for="birthday">Birthday:</label>
                <input type="text" class="form-control datepicker" name="birthday" value="<?php echo $date_of_birth; ?>"> 
            </div>
            <div class="mb-3">
                <label  class="form-label">Contact Number</label>
                <input type="text" class="form-control"  name="contact_number" value="<?php echo $contact_number; ?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">Join Date</label>
                <input type="text" class="form-control"  name="join_date" value="<?php echo $join_date; ?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">Country of residence</label>
                <select name="country_of_residence" id="country_of_residence">
                    <option selected="selected" value="<?php echo $country_of_residence; ?>"><?= $country_of_residence ?></option>
                    <?php foreach ($data as $country) { ?>
                        <option value="<?= $country["name"] ?>"><?= $country["name"] ?></option>
                    <?php }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label  class="form-label">User Status</label>
                <select name="status" id="status">
                    <option selected="selected" value="<?php echo $status; ?>"><?= $status ?></option>
                    <option value="active">active</option>
                    <option value="inactive">inactive</option>
                    <option value="blocked">blocked</option>
                </select>
            </div>
            <button style='margin-bottom:100px' type="submit" class="btn " name='submit' id="button1" value="submit" >Update</button>
        </form>
    </div>
</div>
<?php
include ( 'includes/footer.html' );
?>

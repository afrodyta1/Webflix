<?php
session_start(); # DISPLAY COMPLETE REGISTRATION PAGE.
$page_title = 'Edit Category';
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

    $sql = "SELECT * FROM webflix_category WHERE category_id=$id";
    $result = @mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);

    $category_name = $row['category_name'];
    $description = $row['description'];

# Check form submitted.
    if (isset($_POST['submit'])) {
        # Initialize an error array.
        $errors = array();
        # Update for category name.
        if (empty($_POST['category_name'])) {
            $errors[] = 'Enter the name of the category.';
        } else {
            $category_name1 = mysqli_real_escape_string($link, trim($_POST['category_name']));
        }
        # Check for category description.
        if (empty($_POST['description'])) {
            $errors[] = 'Enter a description of the category.';
        } else {
            $description1 = mysqli_real_escape_string($link, trim($_POST['description']));
        }
# On success category inserting into 'webflix_category database table.
        if (empty($errors)) {
            $q = "UPDATE webflix_category set category_name='$category_name1', description='$description1' WHERE category_id=$id";
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
        }

# Or report errors.
        else {
            ?>
            <div class="container-sm" >
                <div class="col-sm">
                    <?php
                    
//                    Display error to the user
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
<h1 style='text-align:center; margin-top: 100px; margin-bottom:50px' >Edit Category</h1>
<!-- display category form to user-->
<div class="container" style='margin-bottom:100px'>
    <div class="col-sm">
        <form method="post" class="alert-dismissible fade show" role="alert" >
            <div class="mb-3">
                <label  class="form-label">Category Name</label>
                <input type="text" class="form-control" name="category_name" value="<?php echo $category_name; ?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">Category Description</label>
                <input type="text" class="form-control" name="description" value="<?php echo $description; ?>">
            </div>
            <button style='margin-bottom:100px' type="submit" class="btn " name='submit' id="button1" value="submit" >Update</button>
        </form>
    </div>
</div>
<?php
include ( 'includes/footer.html' );
?>

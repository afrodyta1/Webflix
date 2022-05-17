<?php
session_start(); # DISPLAY COMPLETE REGISTRATION PAGE.
$page_title = 'Add Category';
include('includes/logout.php');
# Access session.
# Redirect if not logged in.
if (!isset($_SESSION['user_id'])) {
    require ( 'login_tools.php' );
    load();
}

# Connect to the database.
require ('includes/connect_db.php');

# Check form submitted.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    # Initialize an error array.
    $errors = array();
# Check for category name.
    if (empty($_POST['category_name'])) {
        $errors[] = 'Enter the name of the category.';
    } else {
        $name = mysqli_real_escape_string($link, trim($_POST['category_name']));
    }
    # Check for a category description
    if (empty($_POST['description'])) {
        $errors[] = 'Enter a description of the category.';
    } else {
        $description = mysqli_real_escape_string($link, trim($_POST['description']));
    }
# Check if category already exists.
    if (empty($errors)) {
        $q = "SELECT category_id FROM webflix_category WHERE category_name='$name'";
        $r = @mysqli_query($link, $q);
        if (mysqli_num_rows($r) != 0)
            $errors[] = 'A category with this name already exists.';
    }

# On success category inserting into 'webflix_category' database table.
    if (empty($errors)) {
        $q = "INSERT INTO webflix_category (category_name, description) VALUES ('$name', '$description')";
        $r = @mysqli_query($link, $q);
        if ($r) {
            echo '<h1 style="text-align:center; margin-top: 100px; margin-bottom:50px">Added Successfully!</h1>';
            ?>
            <div class="container" style='text-align:center'>
                <a href="admin_dashboard.php"><button style='margin-bottom:50px' class="btn " id="button1" value="Dashboard" >Dashboard</button></a>
            </div>
            <?php
        }
        # Close database connection.
        mysqli_close($link);
//        exit();
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
<!-- Display form on page -->
<h1 style='text-align:center; margin-top: 100px; margin-bottom:50px' >Add a new category</h1>
<div class="container" style='margin-bottom:100px'>
    <div class="col-sm">
        <form action="create_category.php" method="post" class="alert-dismissible fade show" role="alert" >
            <div class="mb-3">
                <label  class="form-label">Category Name</label>
                <input type="text" class="form-control" name="category_name" placeholder="Category Name" value="<?php if (isset($_POST['category_name'])) echo $_POST['category_name']; ?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">Category Description</label>
                <input type="text" class="form-control" name="description" placeholder="Category Description" value="<?php if (isset($_POST['description'])) echo $_POST['description']; ?>">
            </div>
            <button style='margin-bottom:100px' type="submit" class="btn " id="button1" value="submit" >Add</button>
        </form>
    </div>
</div>
<?php
include ( 'includes/footer.html' );
?>

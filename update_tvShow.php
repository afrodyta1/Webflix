<?php
session_start(); # DISPLAY COMPLETE REGISTRATION PAGE.
$page_title = 'Edit TV Show';
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

    $sql = "SELECT * FROM webflix_category";
    $r1 = mysqli_query($link, $sql);


    $sql = "SELECT webflix_tv_shows.tv_show_id, webflix_tv_shows.title, webflix_tv_shows.image, webflix_tv_shows.category_id, webflix_tv_shows.description, webflix_tv_shows.release_year, webflix_tv_shows.language, webflix_tv_shows.number_of_seasons, webflix_tv_shows.number_of_episodes, webflix_category.category_name FROM webflix_tv_shows INNER JOIN webflix_category ON webflix_tv_shows.category_id=webflix_category.category_id WHERE webflix_tv_shows.tv_show_id=$id";
    $result = @mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);

    $title = $row['title'];
    $image = $row['image'];
    $category_id = $row['category_id'];
    $category_name = $row['category_name'];
    $description = $row['description'];
    $release_year = $row['release_year'];
    $language = $row['language'];
    $number_of_seasons = $row['number_of_seasons'];
    $number_of_episodes = $row['number_of_episodes'];

# Check form submitted.
    if (isset($_POST['submit'])) {
        # Initialize an error array.
        $errors = array();
        # Check for TV show title.
        if (empty($_POST['title'])) {
            $errors[] = 'Enter the title of the TV show.';
        } else {
            $title = mysqli_real_escape_string($link, trim($_POST['title']));
        }
        # Check for TV show image
        if (empty($_POST['image'])) {
            $errors[] = 'Add a cover image.';
        } else {
            $image = mysqli_real_escape_string($link, trim($_POST['image']));
        }
        # Check for TV show category
        if (empty($_POST['category_id'])) {
            $errors[] = 'Enter the category id of the TV show.';
        } else {
            $categoryID = mysqli_real_escape_string($link, trim($_POST['category_id']));
        }
        # Check for TV show description
        if (empty($_POST['description'])) {
            $errors[] = 'Enter the description of the TV show.';
        } else {
            $description = mysqli_real_escape_string($link, trim($_POST['description']));
        }
        # Check for TV show release_year
        if (empty($_POST['release_year'])) {
            $errors[] = 'Enter the release year of the TV show.';
        } else {
            $release_year = mysqli_real_escape_string($link, trim($_POST['release_year']));
        }
        # Check for TV show language
        if (empty($_POST['language'])) {
            $errors[] = 'Enter the language of the TV show.';
        } else {
            $language = mysqli_real_escape_string($link, trim($_POST['language']));
        }
        # Check for TV show number_of_seasons
        if (empty($_POST['number_of_seasons'])) {
            $errors[] = 'Enter the duration of the TV show.';
        } else {
            $number_of_seasons = mysqli_real_escape_string($link, trim($_POST['number_of_seasons']));
        }
        # Check for TV show  number_of_episodes
        if (empty($_POST['number_of_episodes'])) {
            $errors[] = 'Enter the trailer link of the TV show.';
        } else {
            $number_of_episodes = mysqli_real_escape_string($link, trim($_POST['number_of_episodes']));
        }
# On success Tv Show update into 'webflix_tv_show database table.
        if (empty($errors)) {
            $q = "UPDATE webflix_tv_shows set title='$title', image='$image', category_id='$categoryID', description='$description', release_year='$release_year', language='$language', number_of_seasons='$number_of_seasons', number_of_episodes='$number_of_episodes' WHERE tv_show_id=$id";
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
            $sql = "SELECT * FROM webflix_category";
            $r1 = mysqli_query($link, $sql);
            # Close database connection.
            mysqli_close($link);
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
            $sql = "SELECT * FROM webflix_category";
            $r1 = mysqli_query($link, $sql);
            mysqli_close($link);
        }
    }
}
?>
<h1 style='text-align:center; margin-top: 100px; margin-bottom:50px' >Edit TV Show</h1>
<!-- display TV Show form to user -->
<div class="container" style='margin-bottom:100px'>
    <div class="col-sm">
        <form method="post" class="alert-dismissible fade show" role="alert" >
            <div class="mb-3">
                <label  class="form-label">TV Show Title</label>
                <input type="text" class="form-control" name="title" value="<?php echo $title; ?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">Cover Image</label>
                <input type="text" class="form-control" name="image" value="<?php echo $image; ?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">TV Show Category</label>
                <?php if (mysqli_num_rows($r1) > 0) {
                    ?>
                    <select name="category_id" id="category_id">
                        <option selected="selected" value="<?= $category_id ?>"><?= $category_name ?></option>
                        <?php while ($row1 = mysqli_fetch_array($r1, MYSQLI_ASSOC)) { ?>
                            <option value="<?= $row1["category_id"] ?>"><?= $row1["category_name"] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                <?php }
                ?>
            </div>

            <div class="mb-3">
                <label  class="form-label">TV Show Description</label>
                <input type="text" class="form-control" name="description" value="<?php echo $description; ?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">Release Year</label>
                <input type="text" class="form-control" name="release_year" value="<?php echo $release_year; ?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">Language</label>
                <input type="text" class="form-control" name="language" value="<?php echo $language; ?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">Number of Seasons</label>
                <input type="text" class="form-control" name="number_of_seasons" value="<?php echo $number_of_seasons; ?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">Number of Episodes</label>
                <input type="text" class="form-control" name="number_of_episodes" value="<?php echo $number_of_episodes; ?>">
            </div>
            <button style='margin-bottom:100px' type="submit" class="btn " name='submit' id="button1" value="submit" >Update</button>
        </form>
    </div>
</div>
<?php
include ( 'includes/footer.html' );
?>

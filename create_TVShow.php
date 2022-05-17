<?php
session_start(); # DISPLAY COMPLETE REGISTRATION PAGE.
$page_title = 'Add TV Show';
include('includes/logout.php');
# Access session.
# Redirect if not logged in.
if (!isset($_SESSION['user_id'])) {
    require ( 'login_tools.php' );
    load();
}

# Connect to the database.
require ('includes/connect_db.php');
$sql = "SELECT * FROM webflix_category";
$r1 = mysqli_query($link, $sql);

# Check form submitted.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    # Initialize an error array.
    $errors = array();

# Check for TV show title.
    if (empty($_POST['title'])) {
        $errors[] = 'Enter the title of the tv show.';
    } else {
        $title = mysqli_real_escape_string($link, trim($_POST['title']));
    }
    # Check for TV show image
    if (empty($_POST['image'])) {
        $errors[] = 'Add a cover image.';
    } else {
        $img = mysqli_real_escape_string($link, trim($_POST['image']));
        $image = 'image/' . $img;
    }
    # Check for TV show category
    if (empty($_POST['category_id'])) {
        $errors[] = 'Enter the category id of the tv show.';
    } else {
        $categoryID = mysqli_real_escape_string($link, trim($_POST['category_id']));
    }
    # Check for TV show description
    if (empty($_POST['description'])) {
        $errors[] = 'Enter the description of the tv show.';
    } else {
        $description = mysqli_real_escape_string($link, trim($_POST['description']));
    }
    # Check for TV show release_year
    if (empty($_POST['release_year'])) {
        $errors[] = 'Enter the release year of the tv show.';
    } else {
        $release_year = mysqli_real_escape_string($link, trim($_POST['release_year']));
    }
    # Check for TV show language
    if (empty($_POST['language'])) {
        $errors[] = 'Enter the language of the tv show.';
    } else {
        $language = mysqli_real_escape_string($link, trim($_POST['language']));
    }
    # Check for the number of seasons in the TV show
    if (empty($_POST['number_of_seasons'])) {
        $errors[] = 'Enter the number of seasons the TV Show has.';
    } else {
        $number_of_seasons = mysqli_real_escape_string($link, trim($_POST['number_of_seasons']));
    }
    # Check for the number of episodes in the TV show
    if (empty($_POST['number_of_episodes'])) {
        $errors[] = 'Enter the number of episodes the TV Show has.';
    } else {
        $number_of_episodes = mysqli_real_escape_string($link, trim($_POST['number_of_episodes']));
    }
    # Check if movie already exists.
    if (empty($errors)) {
        $q = "SELECT tv_show_id FROM webflix_tv_shows WHERE title='$title'";
        $r = @mysqli_query($link, $q);
        if (mysqli_num_rows($r) != 0)
            $errors[] = 'A TV show with this title already exists.';
    }

# On success tv show inserting into 'webflix_tv_show' database table.
    if (empty($errors)) {
        $q = "INSERT INTO webflix_tv_shows (title, image, category_id, description, release_year, language, number_of_seasons, number_of_episodes) VALUES ('$title', '$image', '$categoryID', '$description', '$release_year', '$language', '$number_of_seasons', '$number_of_episodes')";
        $r = @mysqli_query($link, $q);
        if ($r) {
            echo '<h1 style="text-align:center; margin-top: 100px; margin-bottom:50px">Added Successfully!</h1>';
            ?>
            <div class="container" style='text-align:center'>
                <a href="admin_dashboard.php"><button style='margin-bottom:50px' class="btn " id="button1" value="Dashboard" >Dashboard</button></a>
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

        # Close database connection.
        mysqli_close($link);
    }
}
?>
<!-- Display form on page -->
<h1 style='text-align:center; margin-top: 100px; margin-bottom:50px' >Add a new TV Show</h1>
<div class="container" style='margin-bottom:100px'>
    <div class="col-sm">
        <form action="create_TVShow.php" method="post" class="alert-dismissible fade show" role="alert" >
            <div class="mb-3">
                <label  class="form-label">TV Show Title</label>
                <input type="text" class="form-control" name="title" placeholder="TV Show Title" value="<?php if (isset($_POST['title'])) echo $_POST['title']; ?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">Cover Image</label>
                <input type="text" class="form-control" name="image" placeholder="Cover image path" value="<?php if (isset($_POST['image'])) echo $_POST['image']; ?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">TV Show Category</label>
                <?php
                if (mysqli_num_rows($r1) > 0) {             
                    ?>
                    <select name="category_id" id="category_id">
                        <?php while ($row = mysqli_fetch_array($r1, MYSQLI_ASSOC)) { ?>
                            <option value="<?= $row["category_id"] ?>"><?= $row["category_name"] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                <?php }
                ?>
            </div>
            <div class="mb-3">
                <label  class="form-label">TV Show Description</label>
                <input type="text" class="form-control" name="description" placeholder="TV Show Description" value="<?php if (isset($_POST['description'])) echo $_POST['description']; ?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">Release Year</label>
                <input type="text" class="form-control" name="release_year" placeholder="Release Year" value="<?php if (isset($_POST['release_year'])) echo $_POST['release_year']; ?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">Language</label>
                <input type="text" class="form-control" name="language" placeholder="Language" value="<?php if (isset($_POST['language'])) echo $_POST['language']; ?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">Number of Seasons</label>
                <input type="text" class="form-control" name="number_of_seasons" placeholder="Number of Seasons" value="<?php if (isset($_POST['number_of_seasons'])) echo $_POST['number_of_seasons']; ?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">Number of Episodes</label>
                <input type="text" class="form-control" name="number_of_episodes" placeholder="Number of Episodes" value="<?php if (isset($_POST['number_of_episodes'])) echo $_POST['number_of_episodes']; ?>">
            </div>
            <button style='margin-bottom:100px' type="submit" class="btn " id="button1" value="submit" >Add</button>
        </form>
    </div>
</div>
<?php
include ( 'includes/footer.html' );
?>
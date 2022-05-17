<?php
session_start(); # DISPLAY COMPLETE REGISTRATION PAGE.
$page_title = 'Add Movie';
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
# Check for movie title.
    if (empty($_POST['title'])) {
        $errors[] = 'Enter the title of the movie.';
    } else {
        $title = mysqli_real_escape_string($link, trim($_POST['title']));
    }
    # Check for movie image
    if (empty($_POST['image'])) {
        $errors[] = 'Add a cover image.';
    } else {
        $img = mysqli_real_escape_string($link, trim($_POST['image']));
        $image = 'image/' . $img;
    }
    # Check for movie category
    if (empty($_POST['category_id'])) {
        $errors[] = 'Enter the category id of the movie.';
    } else {
        $categoryID = mysqli_real_escape_string($link, trim($_POST['category_id']));
    }
    # Check for movie description
    if (empty($_POST['description'])) {
        $errors[] = 'Enter the description of the movie.';
    } else {
        $description = mysqli_real_escape_string($link, trim($_POST['description']));
    }
    # Check for movie release_year
    if (empty($_POST['release_year'])) {
        $errors[] = 'Enter the release year of the movie.';
    } else {
        $release_year = mysqli_real_escape_string($link, trim($_POST['release_year']));
    }
    # Check for movie language
    if (empty($_POST['language'])) {
        $errors[] = 'Enter the language of the movie.';
    } else {
        $language = mysqli_real_escape_string($link, trim($_POST['language']));
    }
    # Check for movie movie_duration
    if (empty($_POST['movie_duration'])) {
        $errors[] = 'Enter the duration of the movie.';
    } else {
        $movie_duration = mysqli_real_escape_string($link, trim($_POST['movie_duration']));
    }
    # Check for movie trailer link
    if (empty($_POST['link_trailer'])) {
        $errors[] = 'Enter the trailer link of the movie.';
    } else {
        $link_trailer = mysqli_real_escape_string($link, trim($_POST['link_trailer']));
    }
    # Check for movie full link
    if (empty($_POST['link_full'])) {
        $errors[] = 'Enter the full link of the movie.';
    } else {
        $link_full = mysqli_real_escape_string($link, trim($_POST['link_full']));
    }
# Check if movie already exists.
    if (empty($errors)) {
        $q = "SELECT movie_id FROM webflix_movies WHERE title='$title'";
        $r = @mysqli_query($link, $q);
        if (mysqli_num_rows($r) != 0)
            $errors[] = 'A movie with this title already exists.';
    }

# On success movie inserting into 'webflix_movies' database table.
    if (empty($errors)) {
        $q = "INSERT INTO webflix_movies (title, image, category_id, description, release_year, language, movie_duration, link_trailer, link_full) VALUES ('$title', '$image', '$categoryID', '$description', '$release_year', '$language', '$movie_duration', '$link_trailer', '$link_full')";
//        $q = "INSERT INTO `webflix_movies`( `title`, `image`, `category_id`, `description`, `release_year`, `language`, `movie_duration`, `link_trailer`, `link_full` ('$title', '$image', '$categoryID', '$description', '$release_year', '$language', '$movie_duration', '$link_trailer', '$link_full')";
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
<h1 style='text-align:center; margin-top: 100px; margin-bottom:50px' >Add a new movie</h1>
<div class="container" style='margin-bottom:100px'>
    <div class="col-sm">
        <form action="create_movie.php" method="post" class="alert-dismissible fade show" role="alert" >
            <div class="mb-3">
                <label  class="form-label">Movie Title</label>
                <input type="text" class="form-control" name="title" placeholder="Movie Title" value="<?php if (isset($_POST['title'])) echo $_POST['title']; ?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">Cover Image</label>
                <input type="text" class="form-control" name="image" placeholder="Cover image path" value="<?php if (isset($_POST['image'])) echo $_POST['image']; ?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">Movie Category</label>
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
                <label  class="form-label">Movie Description</label>
                <input type="text" class="form-control" name="description" placeholder="Movie Description" value="<?php if (isset($_POST['description'])) echo $_POST['description']; ?>">
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
                <label  class="form-label">Movie Duration</label>
                <input type="text" class="form-control" name="movie_duration" placeholder="Movie Duration" value="<?php if (isset($_POST['movie_duration'])) echo $_POST['movie_duration']; ?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">Trailer Link</label>
                <input type="text" class="form-control" name="link_trailer" placeholder="Trailer Link" value="<?php if (isset($_POST['link_trailer'])) echo $_POST['link_trailer']; ?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">Full Movie Link</label>
                <input type="text" class="form-control" name="link_full" placeholder="Full Movie Link" value="<?php if (isset($_POST['link_full'])) echo $_POST['link_full']; ?>">
            </div>
            <button style='margin-bottom:100px' type="submit" class="btn " id="button1" value="submit" >Add</button>
        </form>
    </div>
</div>
<?php
include ( 'includes/footer.html' );
?>

<?php
session_start(); # DISPLAY COMPLETE REGISTRATION PAGE.
$page_title = 'Edit Movie';
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

    $sql = "SELECT webflix_movies.movie_id, webflix_movies.title, webflix_movies.image, webflix_movies.category_id, webflix_movies.description, webflix_movies.release_year, webflix_movies.language, webflix_movies.movie_duration, webflix_movies.link_trailer, webflix_movies.link_full, webflix_category.category_name FROM webflix_movies INNER JOIN webflix_category ON webflix_movies.category_id=webflix_category.category_id WHERE movie_id=$id";
    $result = @mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);

    $title = $row['title'];
    $image = $row['image'];
    $category_id = $row['category_id'];
    $category_name = $row['category_name'];
    $description = $row['description'];
    $release_year = $row['release_year'];
    $language = $row['language'];
    $movie_duration = $row['movie_duration'];
    $link_trailer = $row['link_trailer'];
    $link_full = $row['link_full'];

# Check form submitted.
    if (isset($_POST['submit'])) {
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
            $image = mysqli_real_escape_string($link, trim($_POST['image']));
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
# On success movie update into 'webflix_movies database table.
        if (empty($errors)) {
            $q = "UPDATE webflix_movies set title='$title', image='$image', category_id='$categoryID', description='$description', release_year='$release_year', language='$language', movie_duration='$movie_duration', link_trailer='$link_trailer', link_full='$link_full' WHERE movie_id=$id";
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
            
            # Close database connection.
            mysqli_close($link);
        }
    }
}

?>
<h1 style='text-align:center; margin-top: 100px; margin-bottom:50px' >Edit Movie</h1>
<!-- display movie form to user -->
<div class="container" style='margin-bottom:100px'>
    <div class="col-sm">
        <form method="post" class="alert-dismissible fade show" role="alert" >
            <div class="mb-3">
                <label  class="form-label">Movie Title</label>
                <input type="text" class="form-control" name="title" value="<?php echo $title; ?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">Cover Image</label>
                <input type="text" class="form-control" name="image" value="<?php echo $image; ?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">Movie Category</label>
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
                <label  class="form-label">Movie Description</label>
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
                <label  class="form-label">Movie Duration</label>
                <input type="text" class="form-control" name="movie_duration" value="<?php echo $movie_duration; ?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">Trailer Link</label>
                <input type="text" class="form-control" name="link_trailer" value="<?php echo $link_trailer; ?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">Full Movie Link</label>
                <input type="text" class="form-control" name="link_full" value="<?php echo $link_full; ?>">
            </div>
            <button style='margin-bottom:100px' type="submit" class="btn " name='submit' id="button1" value="submit" >Update</button>
        </form>
    </div>
</div>
<?php
include ( 'includes/footer.html' );
?>

<?php
session_start(); # DISPLAY COMPLETE REGISTRATION PAGE.
$page_title = 'Add TV Show Episode';
include('includes/logout.php');
# Access session.
# Redirect if not logged in.
if (!isset($_SESSION['user_id'])) {
    require ( 'login_tools.php' );
    load();
}

# Connect to the database.
require ('includes/connect_db.php');
$sql = "SELECT * FROM webflix_tv_shows";
$r1 = mysqli_query($link, $sql);
# Check form submitted.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    # Initialize an error array.
    $errors = array();

# Check for TV show episode title.
    if (empty($_POST['episode_title'])) {
        $errors[] = 'Enter the title of the tv show episode.';
    } else {
        $episode_title = mysqli_real_escape_string($link, trim($_POST['episode_title']));
    }
    # Check for TV show title
    if (empty($_POST['tv_show_id'])) {
        $errors[] = 'Enter the title of the tv show.';
    } else {
        $tv_show_id = mysqli_real_escape_string($link, trim($_POST['tv_show_id']));
    }
    # Check for TV show episode season number
    if (empty($_POST['season_number'])) {
        $errors[] = 'Enter the season number of the episode.';
    } else {
        $season_number = mysqli_real_escape_string($link, trim($_POST['season_number']));
    }
    # Check for TV show episode number
    if (empty($_POST['episode_number'])) {
        $errors[] = 'Enter the episode number.';
    } else {
        $episode_number = mysqli_real_escape_string($link, trim($_POST['episode_number']));
    }
    
    # Check for TV show trailer link
    if (empty($_POST['episode_link_trailer'])) {
        $errors[] = 'Enter the link to the trailer of the episode.';
    } else {
        $episode_link_trailer = mysqli_real_escape_string($link, trim($_POST['episode_link_trailer']));
    }
    # Check for TV show full link
    if (empty($_POST['episode_link_full'])) {
        $errors[] = 'Enter the link to the full episode..';
    } else {
        $episode_link_full = mysqli_real_escape_string($link, trim($_POST['episode_link_full']));
    }
    
    # Check if movie already exists.
    if (empty($errors)) {
        $q = "SELECT episode_id FROM webflix_episode WHERE episode_number='$episode_number' AND tv_show_id='$tv_show_id' AND season_number='$season_number'";
        $r = @mysqli_query($link, $q);
        if (mysqli_num_rows($r) != 0)
            $errors[] = 'An episode with this season number and episode number already exists.';
    }

# On success tv show inserting into 'webflix_tv_show' database table.
    if (empty($errors)) {
        $q = "INSERT INTO webflix_episode (tv_show_id, episode_number, season_number, episode_title, link_trailer, link_full) VALUES ('$tv_show_id', '$episode_number', '$season_number', '$episode_title', '$episode_link_trailer', '$episode_link_full')";
        $r = @mysqli_query($link, $q);
        if ($r) {
            echo '<h1 style="text-align:center; margin-top: 100px; margin-bottom:50px">Added Successfully!</h1>';
            ?>
            <div class="container" style='text-align:center'>
                <a href="admin_dashboard.php"><button style='margin-bottom:50px' class="btn " id="button1" value="Dashboard" >Dashboard</button></a>
            </div>

            <?php
        }
        $sql = "SELECT * FROM webflix_tv_shows";
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
        $sql = "SELECT * FROM webflix_tv_shows";
        $r1 = mysqli_query($link, $sql);
        # Close database connection.
        mysqli_close($link);
    }
}
?>
<!-- Display form on page -->
<h1 style='text-align:center; margin-top: 100px; margin-bottom:50px' >Add a new Episode</h1>
<div class="container" style='margin-bottom:100px'>
    <div class="col-sm">
        <form action="create_episode.php" method="post" class="alert-dismissible fade show" role="alert" >
            <div class="mb-3">
                <label  class="form-label">Episode Title</label>
                <input type="text" class="form-control" name="episode_title" placeholder="Episode Title" value="<?php if (isset($_POST['episode_title'])) echo $_POST['episode_title']; ?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">TV Show Title</label>
                <?php
                if (mysqli_num_rows($r1) > 0) {
                    ?>
                    <select name="tv_show_id" id="tv_show_id">
                        <?php while ($row = mysqli_fetch_array($r1, MYSQLI_ASSOC)) { ?>
                            <option value="<?= $row["tv_show_id"] ?>"><?= $row["title"] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                <?php }
                ?>
            </div>
            <div class="mb-3">
                <label  class="form-label">Season Number</label>
                <input type="text" class="form-control" name="season_number" placeholder="Season number" value="<?php if (isset($_POST['season_number'])) echo $_POST['season_number']; ?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">Episode Number</label>
                <input type="text" class="form-control" name="episode_number" placeholder="Episode number" value="<?php if (isset($_POST['episode_number'])) echo $_POST['episode_number']; ?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">Episode trailer link</label>
                <input type="text" class="form-control" name="episode_link_trailer" placeholder="Episode Link Trailer" value="<?php if (isset($_POST['episode_link_trailer'])) echo $_POST['episode_link_trailer']; ?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">Episode full link</label>
                <input type="text" class="form-control" name="episode_link_full" placeholder="Episode Link Trailer" value="<?php if (isset($_POST['episode_link_full'])) echo $_POST['episode_link_full']; ?>">
            </div>

            <button style='margin-bottom:100px' type="submit" class="btn " id="button1" value="submit" >Add</button>
        </form>
    </div>
</div>
<?php
include ( 'includes/footer.html' );
?>
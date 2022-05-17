<?php
session_start(); # DISPLAY COMPLETE REGISTRATION PAGE.
$page_title = 'Edit TV Show Episode';
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

    $sql1 = "SELECT * FROM webflix_tv_shows";
    $r1 = mysqli_query($link, $sql1);


    $sql = "SELECT webflix_episode.episode_id, webflix_episode.tv_show_id, webflix_episode.episode_number, webflix_episode.season_number, webflix_episode.episode_title, webflix_episode.link_trailer, webflix_episode.link_full, webflix_tv_shows.title FROM webflix_episode INNER JOIN webflix_tv_shows ON webflix_episode.tv_show_id=webflix_tv_shows.tv_show_id WHERE webflix_episode.episode_id=$id";
    $result = @mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);

    $title = $row['episode_title'];
    $tvShowID = $row['tv_show_id'];
    $tvShowTile = $row['title'];
    $episodeNumber = $row['episode_number'];
    $seasonNumber = $row['season_number'];
    $linkTrailer = $row['link_trailer'];
    $linkFull = $row['link_full'];

# Check form submitted.
    if (isset($_POST['submit'])) {
        # Initialize an error array.
        $errors = array();
        # Check for TV show episode title.
        if (empty($_POST['episode_title'])) {
            $errors[] = 'Enter the title of the Episode.';
        } else {
            $title = mysqli_real_escape_string($link, trim($_POST['title']));
        }
        # Check for TV show id
        if (empty($_POST['tv_show_id'])) {
            $errors[] = 'Pick a TV show.';
        } else {
            $tv_show_id = mysqli_real_escape_string($link, trim($_POST['tv_show_id']));
        }
        # Check for season number
        if (empty($_POST['season_number'])) {
            $errors[] = 'Enter the season number of the episode.';
        } else {
            $season_number = mysqli_real_escape_string($link, trim($_POST['season_number']));
        }
        # Check for episode number
        if (empty($_POST['episode_number'])) {
            $errors[] = 'Enter the episode number of the episode.';
        } else {
            $episode_number = mysqli_real_escape_string($link, trim($_POST['episode_number']));
        }
        # Check for episode trailer link
        if (empty($_POST['link_trailer'])) {
            $errors[] = 'Enter the link for the episode trailer.';
        } else {
            $link_trailer = mysqli_real_escape_string($link, trim($_POST['link_trailer']));
        }
        # Check for episode full link
        if (empty($_POST['link_full'])) {
            $errors[] = 'Enter the link to the full episode.';
        } else {
            $link_full = mysqli_real_escape_string($link, trim($_POST['link_full']));
        }
# On success episode update into 'webflix_episode database table.
        if (empty($errors)) {
            $q = "UPDATE webflix_episode set tv_show_id='$tv_show_id', episode_number='$episode_number', season_number='$season_number', episode_title='$title', link_trailer='$link_trailer', link_full='$link_full' WHERE episode_id=$id";
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
            $sql1 = "SELECT * FROM webflix_tv_shows";
            $r1 = mysqli_query($link, $sql1);
            # Close database connection.
            mysqli_close($link);
        }

# Or report errors.
        else {
            ?>
            <div class="container-sm" >
                <div class="col-sm">
                    <?php
//                    Display error messages to users
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
            $sql1 = "SELECT * FROM webflix_tv_shows";
            $r1 = mysqli_query($link, $sql1);
            mysqli_close($link);
        }
    }
}
?>
<h1 style='text-align:center; margin-top: 100px; margin-bottom:50px'>Edit TV Show Episode</h1>
<!-- display add TV Show episode form to user -->
<div class="container" style='margin-bottom:100px'>
    <div class="col-sm">
        <form method="post" class="alert-dismissible fade show" role="alert" >
            <div class="mb-3">
                <label  class="form-label">Title of Episode</label>
                <input type="text" class="form-control" name="episode_title" value="<?php echo $title; ?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">TV Show Title</label>
                <?php if (mysqli_num_rows($r1) > 0) {
                    ?>
                    <select name="tv_show_id" id="tv_show_id">
                        <option selected="selected" value="<?= $tvShowID ?>"><?= $tvShowTile ?></option>
                        <?php
                        while ($row1 = mysqli_fetch_array($r1, MYSQLI_ASSOC)) {
                            echo '<option value="<?= $row1["tv_show_id"] ?>"><?= $row1["title"] ?></option>';
                        }
                        ?>
                    </select>
                <?php }
                ?>
            </div>
            <div class="mb-3">
                <label  class="form-label">Season number</label>
                <input type="text" class="form-control" name="season_number" value="<?php echo $seasonNumber; ?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">Episode number</label>
                <input type="text" class="form-control" name="episode_number" value="<?php echo $episodeNumber; ?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">Episode trailer link</label>
                <input type="text" class="form-control" name="link_trailer" value="<?php echo $linkTrailer; ?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">Episode full link</label>
                <input type="text" class="form-control" name="link_full" value="<?php echo $linkFull; ?>">
            </div>
            <button style='margin-bottom:100px' type="submit" class="btn " name='submit' id="button1" value="submit" >Update</button>
        </form>
    </div>
</div>
<?php
include ( 'includes/footer.html' );
?>

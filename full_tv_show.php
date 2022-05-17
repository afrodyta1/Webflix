<?php
# Access session.
session_start();
# DISPLAY COMPLETE REGISTRATION PAGE.
$page_title = 'Movie';
include('includes/logout.php');

# Redirect if not logged in.
if (!isset($_SESSION['user_id'])) {
    require ( 'login_tools.php' );
    load();
}

# Get passed product id and assign it to a variable.
if (isset($_GET['id']))
    $id = $_GET['id'];
if (isset($_GET['season']))
    $season = $_GET['season'];
if (isset($_GET['episode']))
    $episode = $_GET['episode'];

# Open database connection.
require ( 'includes/connect_db.php' );

# Retrieve selective item data from 'webflix_episode' database table. 
$q = "SELECT * FROM webflix_episode WHERE tv_show_id = $id AND season_number = $season AND episode_number = $episode";
$r = mysqli_query($link, $q);
if (mysqli_num_rows($r) > 0) {
    $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
    ?>
    <div class="container" style='margin-bottom:150px'></div>
    <?php
    //   Display TV Show episode as big screen
    echo '<div class= "container">
        <div class="row">
            <div class="col-xl-12">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src=' . $row['link_full'] . ' 
                            frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                </iframe>
            </div>
        </div>
    </div>
    </div>';
    ?>

    <div class="container" style='margin-bottom:270px'></div>
    <?php
}

# Close database connection.
mysqli_close($link);
# Display footer section.
include ( 'includes/footer.html' );
?>
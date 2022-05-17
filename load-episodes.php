<?php

session_start();
# Redirect if not logged in.
if (!isset($_SESSION['user_id'])) {
    require ('login_tools.php' );
    load();
}
# Set page title and display header section.
include ( 'includes/logout.php' );

# Open database connection.
require ( 'includes/connect_db.php' );

$id = $_POST['id'];
$seasonSelected = $_POST['seasonSelected'];

$sql = "SELECT * FROM webflix_episode WHERE tv_show_id = $id AND season_number = $seasonSelected ORDER BY episode_number ASC";
$result = mysqli_query($link, $sql);

//populates dropdown list with all available episode for chosen tv show and season.
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        echo '<option value=' . $row['episode_number'] . '>' . $row['episode_number'] . '</option>';
    }
} else {
    echo "There are no episodes available.";
}
?>
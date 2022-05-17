<?php

session_start();
if (!isset($_SESSION['user_id'])) {
    require ('login_tools.php' );
    load();
}
# Redirect if not logged in.
if (!isset($_SESSION['user_id'])) {
    require ( 'login_tools.php' );
    load();
}
# Open database connection.
require ( 'includes/connect_db.php' );

$id = $_POST['id'];
$seasonSelected = $_POST['seasonSelected'];
$episodeSelected = $_POST['episodeSelected'];

$sql = "SELECT * FROM webflix_episode WHERE tv_show_id = $id AND season_number = $seasonSelected AND episode_number = $episodeSelected";
$result = mysqli_query($link, $sql);

//display episode title for chosen tv show and season.
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    print $row['episode_title'];
}
?>
    
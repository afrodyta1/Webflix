<?php
# DISPLAY COMPLETE LOGGED IN PAGE.
# Access session.
session_start();
# Redirect if not logged in.
if (!isset($_SESSION['user_id'])) {
    require ('login_tools.php' );
    load();
}
# Set page title and display header section.
$page_title = 'TV Shows';
include ( 'includes/logout.php' );

# Display body section.
echo "<h1 style='text-align:center;'>TV Shows</h1>";

# Open database connection.
require ( 'includes/connect_db.php' );
# Retrieve movies from 'webflix_tv_shows' database table.
$q = "SELECT DISTINCT webflix_tv_shows.`tv_show_id`, webflix_tv_shows.title, webflix_tv_shows.image, webflix_episode.tv_show_id FROM webflix_tv_shows INNER JOIN webflix_episode ON webflix_tv_shows.`tv_show_id`=webflix_episode.tv_show_id";
$r = mysqli_query($link, $q);
# Check form submitted.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    # Check for movie category
    if (empty($_POST['category_id'])) {
        $q = "SELECT DISTINCT webflix_tv_shows.`tv_show_id`, webflix_tv_shows.title, webflix_tv_shows.image, webflix_episode.tv_show_id FROM webflix_tv_shows INNER JOIN webflix_episode ON webflix_tv_shows.`tv_show_id`=webflix_episode.tv_show_id";
        $r = mysqli_query($link, $q);
    } else {
        $categoryID = mysqli_real_escape_string($link, trim($_POST['category_id']));
        $q = "SELECT * FROM webflix_tv_shows WHERE category_id= $categoryID";
        $r = mysqli_query($link, $q);
    }
}

# Retrieve categories from 'Webflix_category' database table.
$sql = "SELECT DISTINCT webflix_category.`category_id`, webflix_category.category_name, webflix_tv_shows.category_id FROM webflix_category INNER JOIN webflix_tv_shows ON webflix_category.category_id=webflix_tv_shows.category_id ";
$r1 = mysqli_query($link, $sql);
if (mysqli_num_rows($r) > 0) {
    ?>
    <div class="container">
        <div class="mb-3">
            <form action="tv_shows.php" method="post" class="alert-dismissible fade show" role="alert" >
                <!-- display category filter (drop-down list)to user-->
                <label  class="form-label">Filter by TV show Category</label><br>
                <?php
                if (mysqli_num_rows($r1) > 0) {
                    ?>
                    <select name="category_id" id="category_id">
                        <option value="">See All</option>
                        <?php while ($row1 = mysqli_fetch_array($r1, MYSQLI_ASSOC)) { ?>
                            <option value="<?= $row1["category_id"] ?>"><?= $row1["category_name"] ?></option>
                            <?php
                        }
                        ?>
                    </select><br>
                <?php }
                ?>
                <button style='margin-bottom:100px' type="submit" class="btn " id="button1" value="submit" >Search</button>
            </form>
        </div>
        <div class="row row-cols-1 row-cols-md-4 g-4">
            <?php
            # Display body section.
            while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                echo '<div class= "col" style= "padding-bottom: 20px">
                <div class="card h-100">
                    <img class="card-img-top"  src = "' . $row['image'] . '" alt = "TV Show">
                    <div class="card-body">
                        <h5 class="card-title">' . $row['title'] . '</h5>
                        <a href="shows.php?id=' . $row['tv_show_id'] . '"> <button id="button1" type="button" class="btn " role="button"> Find Out More </button></a>
                    </div>
                </div>
            </div>';
            }
            ?>
        </div>
    </div>
    <?php
# Close database connection.
    mysqli_close($link);
}
# Or display message.
else {
    echo '<p>There are currently no TV shows showing in this category.</p>';
}

# Display footer section.
include ( 'includes/footer.html' );
?>
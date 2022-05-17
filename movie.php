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

$userID = $_SESSION['user_id'];
# Get passed product id and assign it to a variable.
if (isset($_GET['id']))
    $id = $_GET['id'];

# Open database connection.
require ( 'includes/connect_db.php' );

# Retrieve selective item data from 'Webflix_movie' database table where movie id is equal to the id of the movie selected. 
$q = "SELECT * FROM webflix_movies WHERE movie_id = $id";
$r = mysqli_query($link, $q);
if (mysqli_num_rows($r) == 1) {
    $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
    ?>
    <div class="container" style='margin-bottom:250px'></div>

    <div class= "container">
        <h1 class="display-4"><?php print $row['title']; ?></h1>
        <div class="row">
            <div class="col-sm-12 col-md-4">
                <div class="embed-responsive embed-responsive-16by9">
                    <?php
                    echo '<iframe class="embed-responsive-item" src=' . $row['link_trailer'] . ' 
                            frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                </iframe>';
                    ?>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <p> <?php print $row['description']; ?> </p>
            </div>
            <div class="col-sm-12 col-md-4" >
                <h4>Watch Full Movie </h4>
                <?php
                # Retrieve all data from 'webflix_users' database table where user id is equal to the id of the user logged in. 
                $q1 = "SELECT * FROM webflix_users WHERE user_id = $userID";
                $r1 = mysqli_query($link, $q1);
                if (mysqli_num_rows($r1) == 1) {
                    $row1 = mysqli_fetch_array($r1, MYSQLI_ASSOC);
                    if ($row1['status'] == 'active') { // grant access if status is active (user subscribed)
                        echo '<hr>
                        <h2>
                            <a href="full_movie.php?id=' . $row['movie_id'] . '"> <button type="button" class="btn" id="button1" role="button"> Watch Now </button></a>
                        </h2>';
                    } else if ($row1['status'] == 'inactive') {// deny access if status is inactive (user is not subscribed)
                        echo '<hr>
                        <h2>
                            <button type="button" class="btn" id="button1" data-toggle="modal" data-target="#notSubscribed"> Watch Now </button>
                        </h2>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <div class="container" style='margin-bottom:270px'></div>


    <div class="container" style='margin-bottom:270px'></div>
    <?php
}

# Close database connection.
mysqli_close($link);
# Display footer section.
include ( 'includes/footer.html' );
?>
<!-- Display pop up box with message to buy subscription-->
<div class="modal fade" id="notSubscribed" tabindex="-1" role="dialog" aria-labelledby="notSubscribed" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div id="background2" class="modal-content" >
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Sorry you are not subscribed</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5 class="modal-title" id="exampleModalCenterTitle">To watch full movie please subscribe.</h5>
            </div>
            <div class="modal-footer">
                <div class="form-group">
                    <a href="user.php"> <button type="button" class="btn" id="button1" role="button"> Subscribe Here </button></a>
                </div>
            </div>
        </div><!--Close body-->
    </div><!--Close modal-body-->
</div><!-- Close modal-fade-->
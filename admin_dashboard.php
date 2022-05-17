<?php
session_start(); # DISPLAY COMPLETE REGISTRATION PAGE.
$page_title = 'Admin Dashboard';
include('includes/logout.php');
# Access session.
# Redirect if not logged in.
if (!isset($_SESSION['user_id'])) {
    require ( 'login_tools.php' );
    load();
}

# Open database connection.
require ( 'includes/connect_db.php' );

# Display body section.
echo "<h1 style='text-align:center; '>Admin Dashboard</h1>";
?>
<div class="container" style="margin-bottom: 200px">
    <div class="row">
        <div class="col-2"><!-- Buttons to navigate the admin dashboard-->
            <div class="list-group" id="list-tab" role="tablist" style="padding-top:40px">
                <a class="list-group-item list-group-item-action active" id="list-user-list" data-bs-toggle="list" href="#list-user" role="tab" aria-controls="list-user">User's</a>
                <a class="list-group-item list-group-item-action" id="list-category-list" data-bs-toggle="list" href="#list-category" role="tab" aria-controls="list-profile">Categories</a>
                <a class="list-group-item list-group-item-action" id="list-movies-list" data-bs-toggle="list" href="#list-movies" role="tab" aria-controls="list-movies">Movies</a>
                <a class="list-group-item list-group-item-action" id="list-TvShows-list" data-bs-toggle="list" href="#list-TvShows" role="tab" aria-controls="list-TvShows">TV Shows</a>
                <a class="list-group-item list-group-item-action" id="list-TvShowEpisodes-list" data-bs-toggle="list" href="#list-TvShowEpisodes" role="tab" aria-controls="list-TvShowEpisodes">TV Shows Episodes</a>
            </div>
        </div>
        <div class="col-10">
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="list-user" role="tabpanel" aria-labelledby="list-user-list">
                    <?php
                    # Retrieve users from 'webflix_users' database table.
                    $q1 = "SELECT * FROM webflix_users";
                    $r1 = mysqli_query($link, $q1);
                    if (mysqli_num_rows($r1) > 0) {
                        ?>
                        <h4 style='text-align:center; '>List of users</h4>
                        <div class="table-responsive" style="height: 500px; overflow: scroll;">
                            <!-- Display user table -->
                            <table class="table table-striped table-light table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">User Type</th>
                                        <th scope="col">First</th>
                                        <th scope="col">Last</th>
                                        <th scope="col">D.O.B</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Number</th>
                                        <th scope="col">Country</th>
                                        <th scope="col">Join Date</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Edit</th>
                                        <th scope="col">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = mysqli_fetch_array($r1, MYSQLI_ASSOC)) {
                                        $id = $row['user_id'];
                                        echo'<tr>
                                    <td> ' . $row['user_id'] . '</td>
                                    <td> ' . $row['role_id'] . '</td>
                                    <td> ' . $row['first_name'] . '</td>
                                    <td> ' . $row['surname'] . '</td>
                                    <td> ' . $row['date_of_birth'] . '</td>
                                    <td> ' . $row['email'] . '</td>
                                    <td> ' . $row['contact_number'] . '</td>
                                    <td> ' . $row['join_date'] . '</td>
                                    <td> ' . $row['country_of_residence'] . '</td>
                                    <td> ' . $row['status'] . '</td>
                                    <td>  <a href="update_user.php?id=' . $id . '"><button type="button" class="btn btn-warning" id="btn1" >Edit</button></a></td>
                                    <td> <button type="button" class="btn btn-danger" id="btn1" data-toggle="modal" data-target="#user">Delete</button></td>
                                </tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <?php
                    } else {
                        echo '<h3>No User on the Database.</h3>';
                    }
                    ?>
                </div>
                <div class="tab-pane fade" id="list-category" role="tabpanel" aria-labelledby="list-category-list">
                    <div class="tab-pane fade show active" id="list-category" role="tabpanel" aria-labelledby="list-category-list">
                        <?php
                        # Retrieve categories from 'webflix_category' database table.
                        $q2 = "SELECT * FROM webflix_category";
                        $r2 = mysqli_query($link, $q2);
                        if (mysqli_num_rows($r2) > 0) {
                            // table displaying categories from database with edit and delete buttons
                            ?>
                            <h4 style='text-align:center; '>List of Categories</h4>
                            <div class="table-responsive" style="height: 500px; overflow: scroll;">
                                <!-- Display categories table -->
                                <table class="table table-striped table-light table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Edit</th>
                                            <th scope="col">Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($row2 = mysqli_fetch_array($r2, MYSQLI_ASSOC)) {
                                            $categoryID = $row2['category_id'];
                                            echo'<tr>
                                    <td> ' . $row2['category_id'] . '</td>
                                    <td> ' . $row2['category_name'] . '</td>
                                    <td> ' . $row2['description'] . '</td>
                                    <td>  <a href="update_category.php?id=' . $categoryID . '"><button type="button" class="btn btn-warning" id="btn1" >Edit</button></a></td>
                                    <td> <button type="button" class="btn btn-danger" id="btn1" data-toggle="modal" data-target="#category">Delete</button></td>
                                </tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                        } else {
                            echo '<h3>No Categories on the Database.</h3>';
                        }
                        ?>
                        <a href="create_category.php"><button type="button" class="btn btn-success" id="btn1" data-toggle="modal" >Add New</button></a>
                    </div>
                </div>
                <div class="tab-pane fade" id="list-movies" role="tabpanel" aria-labelledby="list-movies-list">
                    <?php
                    # Retrieve movies from 'webflix_movies' database table.
                    $q3 = "SELECT webflix_movies.movie_id, webflix_movies.title, webflix_movies.image, webflix_movies.category_id, webflix_movies.description, webflix_movies.release_year, webflix_movies.language, webflix_movies.movie_duration, webflix_movies.link_trailer, webflix_movies.link_full, webflix_category.category_name FROM webflix_movies INNER JOIN webflix_category ON webflix_movies.category_id=webflix_category.category_id ORDER BY movie_id ASC";
                    $r3 = mysqli_query($link, $q3);
                    if (mysqli_num_rows($r3) > 0) {
                        ?>
                        <h4 style='text-align:center; '>List of Movies</h4>
                        <div class="table-responsive" style="height: 500px; overflow: scroll;">
                            <!-- Display movies table -->
                            <table class="table table-striped table-light table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Cover Image</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Release Year</th>
                                        <th scope="col">Language</th>
                                        <th scope="col">Movie Duration (min)</th>
                                        <th scope="col">Trailer Link</th>
                                        <th scope="col">Full Link</th>
                                        <th scope="col">Edit</th>
                                        <th scope="col">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row3 = mysqli_fetch_array($r3, MYSQLI_ASSOC)) {
                                        $movieID = $row3['movie_id'];
                                        echo'<tr>
                                    <td> ' . $row3['movie_id'] . '</td>
                                    <td> ' . $row3['title'] . '</td>
                                    <td> <img class="card-img-top"  src = "' . $row3['image'] . '" alt = "Movie"></td>
                                    <td> ' . $row3['category_name'] . '</td>
                                    <td style="width: 200px"> ' . $row3['description'] . '</td>
                                    <td> ' . $row3['release_year'] . '</td>
                                    <td> ' . $row3['language'] . '</td>
                                    <td> ' . $row3['movie_duration'] . '</td>
                                    <td> ' . $row3['link_trailer'] . '</td>
                                    <td> ' . $row3['link_full'] . '</td>
                                    <td>  <a href="update_movie.php?id=' . $movieID . '"><button type="button" class="btn btn-warning" id="btn1" >Edit</button></a></td>
                                    <td> <button type="button" class="btn btn-danger" id="btn1" data-toggle="modal" data-target="#movie">Delete</button></td>
                                </tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <?php
                    } else {
                        echo '<h3>No Movies on the Database.</h3>';
                    }
                    ?>
                    <a href="create_movie.php"><button type="button" class="btn btn-success" id="btn1" data-toggle="modal" >Add New</button></a>
                </div>
                <div class="tab-pane fade" id="list-TvShows" role="tabpanel" aria-labelledby="list-TvShows-list">
                    <?php
                    # Retrieve tv shows from 'webflix_tv_shows' database table.
                    $q4 = "SELECT webflix_tv_shows.tv_show_id, webflix_tv_shows.title, webflix_tv_shows.image, webflix_tv_shows.category_id, webflix_tv_shows.description, webflix_tv_shows.release_year, webflix_tv_shows.language, webflix_tv_shows.number_of_seasons, webflix_tv_shows.number_of_episodes, webflix_category.category_name FROM webflix_tv_shows INNER JOIN webflix_category ON webflix_tv_shows.category_id=webflix_category.category_id ORDER BY tv_show_id ASC";
                    $r4 = mysqli_query($link, $q4);
                    if (mysqli_num_rows($r4) > 0) {
                        ?>
                        <h4 style='text-align:center; '>List of TV Shows</h4>
                        <div class="table-responsive" style="height: 500px; overflow: scroll;">
                            <!-- Display TV Show table -->
                            <table class="table table-striped table-light table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Cover Image</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Release Year</th>
                                        <th scope="col">Language</th>
                                        <th scope="col"># of seasons</th>
                                        <th scope="col"># of episodes</th>
                                        <th scope="col">Edit</th>
                                        <th scope="col">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row4 = mysqli_fetch_array($r4, MYSQLI_ASSOC)) {
                                        $tvShowID = $row4['tv_show_id'];
                                        echo'<tr>
                                    <td> ' . $row4['tv_show_id'] . '</td>
                                    <td> ' . $row4['title'] . '</td>
                                    <td> <img class="card-img-top"  src = "' . $row4['image'] . '" alt = "TV shows"></td>
                                    <td> ' . $row4['category_name'] . '</td>
                                    <td style="width: 200px"> ' . $row4['description'] . '</td>
                                    <td> ' . $row4['release_year'] . '</td>
                                    <td> ' . $row4['language'] . '</td>
                                    <td> ' . $row4['number_of_seasons'] . '</td>
                                    <td> ' . $row4['number_of_episodes'] . '</td>
                                    <td>  <a href="update_tvShow.php?id=' . $tvShowID . '"><button type="button" class="btn btn-warning" id="btn1" >Edit</button></a></td>
                                    <td> <button type="button" class="btn btn-danger" id="btn1" data-toggle="modal" data-target="#tvShow">Delete</button></td>
                                </tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <?php
                    } else {
                        echo '<h3>No TV Shows on the Database.</h3>';
                    }
                    ?>
                    <a href="create_TVShow.php"><button type="button" class="btn btn-success" id="btn1" data-toggle="modal" >Add New</button></a>

                </div>
                <div class="tab-pane fade" id="list-TvShowEpisodes" role="tabpanel" aria-labelledby="list-TvShowEpisodes-list">
                    <?php
                    # Retrieve episodes from 'webflix_episode' database table.
                    $q5 = "SELECT webflix_episode.episode_id, webflix_episode.tv_show_id, webflix_episode.episode_number, webflix_episode.season_number, webflix_episode.episode_title, webflix_episode.link_trailer, webflix_episode.link_full, webflix_tv_shows.tv_show_id, webflix_tv_shows.title FROM webflix_episode INNER JOIN webflix_tv_shows ON webflix_episode.tv_show_id=webflix_tv_shows.tv_show_id";
                    $r5 = mysqli_query($link, $q5);
                    if (mysqli_num_rows($r5) > 0) {
                        ?>
                        <h4 style='text-align:center; '>List of Episodes</h4>
                        <div class="table-responsive" style="height: 500px; overflow: scroll;">
                            <!-- Display episodes table -->
                            <table class="table table-striped table-light table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Episode Title</th>
                                        <th scope="col">Season number</th>
                                        <th scope="col">Episode number</th>
                                        <th scope="col">TV Show Title</th>
                                        <th scope="col">Episode trailer link</th>
                                        <th scope="col">Episode full link</th>
                                        <th scope="col">Edit</th>
                                        <th scope="col">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    //autofill TV Show episodes from database     
                                    while ($row5 = mysqli_fetch_array($r5, MYSQLI_ASSOC)) {
                                        $episodeID = $row5['episode_id'];
                                        echo'<tr>
                                    <td> ' . $row5['episode_id'] . '</td>
                                    <td> ' . $row5['episode_title'] . '</td>
                                    <td> ' . $row5['season_number'] . '</td>
                                    <td> ' . $row5['episode_number'] . '</td>
                                    <td> ' . $row5['title'] . '</td>
                                    <td> ' . $row5['link_trailer'] . '</td>
                                    <td> ' . $row5['link_full'] . '</td>
                                    <td>  <a href="update_episode.php?id=' . $episodeID . '"><button type="button" class="btn btn-warning" id="btn1" >Edit</button></a></td>
                                    <td> <button type="button" class="btn btn-danger" id="btn1" data-toggle="modal" data-target="#episode">Delete</button></td>
                                </tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <?php
                    } else {
                        echo '<h3>No TV Shows on the Database.</h3>';
                    }
                    ?>
                    <a href="create_episode.php"><button type="button" class="btn btn-success" id="btn1" data-toggle="modal" >Add New</button></a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
# Display footer section.
include ( 'includes/footer.html' );
?>


<!-- pop up box to delete user by id -->
<div class="modal fade" id="user" tabindex="-1" role="dialog" aria-labelledby="user" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div id="background2" class="modal-content" >
            <form  action="delete_user.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Delete User</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Please confirm the ID of the user you want to delete.</h5>
                    <div class="form-group">
                        <input type="text"  name="user_id" 
                               class="form-control"  
                               placeholder="Confirm User's ID" 				
                               value="<?php if (isset($_POST['user_id'])) echo $_POST['user_id']; ?>" 
                               required>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group">
                        <input type="submit" 
                               name="btnDelete" 
                               class="btn btn-danger" id="btn1" value="Delete"/>
                    </div>
                </div>
            </form>

        </div><!--Close body-->
    </div><!--Close modal-body-->
</div><!-- Close modal-fade-->

<!-- pop up box to delete category by id -->
<div class="modal fade" id="category" tabindex="-1" role="dialog" aria-labelledby="category" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div id="background2" class="modal-content" >
            <form  action="delete_category.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Delete Category</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Please confirm the ID of the category you want to delete.</h5>
                    <div class="form-group">
                        <input type="text"  name="category_id" 
                               class="form-control"  
                               placeholder="Confirm Category ID" 				
                               value="<?php if (isset($_POST['category_id'])) echo $_POST['category_id']; ?>" 
                               required>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group">
                        <input type="submit" 
                               name="btnDelete" 
                               class="btn btn-danger" id="btn1" value="Delete"/>
                    </div>
                </div>
            </form>

        </div><!--Close body-->
    </div><!--Close modal-body-->
</div><!-- Close modal-fade-->

<!-- pop up box to delete movie by id -->
<div class="modal fade" id="movie" tabindex="-1" role="dialog" aria-labelledby="movie" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div id="background2" class="modal-content" >
            <form  action="delete_movie.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Delete Movie</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Please confirm the ID of the movie you want to delete.</h5>
                    <div class="form-group">
                        <input type="text"  name="movie_id" 
                               class="form-control"  
                               placeholder="Confirm Movie ID" 				
                               value="<?php if (isset($_POST['movie_id'])) echo $_POST['movie_id']; ?>" 
                               required>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group">
                        <input type="submit" 
                               name="btnDelete" 
                               class="btn btn-danger" id="btn1" value="Delete"/>
                    </div>
                </div>
            </form>

        </div><!--Close body-->
    </div><!--Close modal-body-->
</div><!-- Close modal-fade-->

<!-- pop up box to delete TV Show by id -->
<div class="modal fade" id="tvShow" tabindex="-1" role="dialog" aria-labelledby="tvShow" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div id="background2" class="modal-content" >
            <form  action="delete_TVShow.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Delete TV Show</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Please confirm the ID of the TV Show you want to delete.</h5>
                    <div class="form-group">
                        <input type="text"  name="tv_show_id" 
                               class="form-control"  
                               placeholder="Confirm TV Show ID" 				
                               value="<?php if (isset($_POST['tv_show_id'])) echo $_POST['tv_show_id']; ?>" 
                               required>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group">
                        <input type="submit" 
                               name="btnDelete" 
                               class="btn btn-danger" id="btn1" value="Delete"/>
                    </div>
                </div>
            </form>

        </div><!--Close body-->
    </div><!--Close modal-body-->
</div><!-- Close modal-fade-->

<!-- pop up box to delete episode by id -->
<div class="modal fade" id="episode" tabindex="-1" role="dialog" aria-labelledby="episode" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div id="background2" class="modal-content" >
            <form  action="delete_episode.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Delete Episode</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Please confirm the ID of the episode you want to delete.</h5>
                    <div class="form-group">
                        <input type="text"  name="episode_id" 
                               class="form-control"  
                               placeholder="Confirm Episode ID" 				
                               value="<?php if (isset($_POST['episode_id'])) echo $_POST['episode_id']; ?>" 
                               required>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group">
                        <input type="submit" 
                               name="btnDelete" 
                               class="btn btn-danger" id="btn1" value="Delete"/>
                    </div>
                </div>
            </form>

        </div><!--Close body-->
    </div><!--Close modal-body-->
</div><!-- Close modal-fade-->
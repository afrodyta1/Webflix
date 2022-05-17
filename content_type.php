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
$page_title = 'Movies or TV Shows';
include ( 'includes/logout.php' );

# Display body section.
echo "<h1 style='text-align:center;'>Movies or TV Shows</h1>";

# Open database connection.
require ( 'includes/connect_db.php' );
?>
<!-- display Movies or TV Show options-->
<div class= "container" style="padding-bottom: 300px; padding-top: 100px">
    <div class="row row-cols-1 row-cols-md-2 g-4">
        <div class="col">
            <div class="col">
                <a class="navbar-brand" href="movies.php"><img src="image/Movies.jpg" class="card-img-top" alt="Movies"></a>
                
            </div>
        </div>
        <div class="col">
            <div class="col">
                <a class="navbar-brand" href="tv_shows.php"><img src="image/TVshows.jpg" class="card-img-top" alt="TV Shows"></a>
                
            </div>
        </div>
    </div>
</div>
<?php
# Display footer section.
include ( 'includes/footer.html' );
?>
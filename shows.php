<?php
# Access session.
session_start();
# Redirect if not logged in.
if (!isset($_SESSION['user_id'])) {
    require ( 'login_tools.php' );
    load();
}

$page_title = 'TV Show';
include('includes/logout.php');



# Get passed product id and assign it to a variable.
if (isset($_GET['id']))
    $id = $_GET['id'];
$userID = $_SESSION['user_id'];
# Open database connection.
require ( 'includes/connect_db.php' );
?>

<script type="text/javascript" >
//stores tv show id and season selected calls the load-episodes file
    $(document).ready(function () {
        $('#button2').click(function () {
            var seasonSelected = $('#number_of_season :selected').text();
            var idd = document.getElementById("TVShow_id").textContent;
            //fill the dropdown list with episode from just the selected season.
            $("#number_of_episodess").load("load-episodes.php", {
                seasonSelected: seasonSelected,
                id: idd
            });
        });
    });
//stores selected episode
    $(document).ready(function () {
        $('#button3').click(function () {
            var episodeSelected = $('#number_of_episodess :selected').text();
            
            if (episodeSelected === "") {
                alert("Please first choose an episode.");
                return;
            } else {
                var idd = document.getElementById("TVShow_id").textContent;
                var seasonSelected = $('#number_of_season :selected').text();
                var episodeSelected = $('#number_of_episodess :selected').text();
                $("#TVShow_e_title").load("load-one-episode.php", {
                    id: idd,
                    seasonSelected: seasonSelected,
                    episodeSelected: episodeSelected
                });
                //call the load-episode-trailer file to display the correct trailer 
                $("#trailer").load("load-episode-trailer.php", {
                    id: idd,
                    seasonSelected: seasonSelected,
                    episodeSelected: episodeSelected
                });
            }
        });
    });
// takes user to watch the full episode 
    let redirectPage = () => {
        let episodeSelected = document.getElementById('number_of_episodess');

        if (episodeSelected.value === "") {
            alert("Please first choose the season and episode.");
            return;
        } else {
            let idd = document.getElementById('TVShow_id').textContent;
            let seasonSelected = document.getElementById('number_of_season');
            let episodeSelected = document.getElementById('number_of_episodess');
            const url = "full_tv_show.php?id=" + idd + "&season=" + seasonSelected.value + "&episode=" + episodeSelected.value;

            window.location.href = url;
        }
    }
</script>
<?php
# Retrieve selective item data from 'movie' database table. 
$q = "SELECT * FROM webflix_tv_shows WHERE tv_show_id = $id";
$r = mysqli_query($link, $q);

//$number = mysqli_query($link, $p);
$p = "SELECT * FROM webflix_episode WHERE tv_show_id = $id AND season_number = 1 AND episode_number = 1";
$t = mysqli_query($link, $p);
if (mysqli_num_rows($r) == 1) {
    $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
    if (mysqli_num_rows($t) == 1) {
        $row1 = mysqli_fetch_array($t, MYSQLI_ASSOC);
        
        $sql = "SELECT COUNT(DISTINCT `season_number`) AS number FROM webflix_episode WHERE tv_show_id = $id";
        $result = mysqli_query($link, $sql);
        $row4 = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $numberOfSeasons = $row4['number'];
        
        ?>

        <div class="container" style='margin-bottom:100px'></div>        
        <div class= "container" >
            <h1 class="display-4" id="TVShow_id" > <?php print $row['tv_show_id']; ?></h1>
            <h1 class="display-4" id="TVShow_title"> <?php print $row['title']; ?></h1>
            <h2 id="TVShow_e_title" class="display-4"> <?php print $row1['episode_title']; ?> </h2>
            <div class="row">
                <div class="col-sm-12 col-md-4" >
                    <div class="embed-responsive embed-responsive-16by9" id="trailer">
                        <?php echo'<iframe  class="embed-responsive-item" src=' . $row1['link_trailer'] . ' 
                                frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen>
                                </iframe>';
                        ?>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <p> <?php print $row['description']; ?></p>
                </div>
                <div class="col-sm-12 col-md-4" >
                    <h4>All Seasons and Episodes</h4>
                    <hr>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <div class="row">
                                    <div class="form-group">

                                        <label for="number_of_season">Select a Season</label>

                                        <select class="form-control" id="number_of_season" name="number_of_season">
                                            <?php
                                            for ($x = 1; $x < $numberOfSeasons + 1; $x++) {
                                                echo "<option value= '$x'>" . $x . "</option>";
                                            }
                                            ?>
                                        </select>
                                        <input id="button2" type="button" value="Select"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <label for="books">Select an Episode</label>
                                        <div id="episode_drop_down">
                                            <select class="form-control" id="number_of_episodess" name="episodes">

                                            </select>
                                            <input id="button3" type="button" value="Select"/>
                                        </div>    
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <h4>Watch Full Episode </h4>
                    <hr>
                    <?php
                    $q2 = "SELECT * FROM webflix_users WHERE user_id = $userID";
                    $r2 = mysqli_query($link, $q2);

                    if (mysqli_num_rows($r2) == 1) {
                        $row2 = mysqli_fetch_array($r2, MYSQLI_ASSOC);
                        if ($row2['status'] == 'active') {
                            ?>
                            <h2>
                                <!--on click button calls redirectPage() function to watch full episode-->
                                <button type="button" class="btn" id="button1" role="button" onclick='redirectPage()'> Watch Now </button>
                            </h2>
                            <?php
                        } else if ($row2['status'] == 'inactive') {
                            ?>
                            <h2>
                                <button type="button" class="btn" id="button1" role="button" data-toggle="modal" data-target="#notSubscribed"> Watch Now </button>
                            </h2>
                            <?php
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
}

# Close database connection.
mysqli_close($link);
# Display footer section.
include ( 'includes/footer.html' );
?>
<script type="text/javascript" >
//hide div with tv show id
    function update() {
        var tvShowId = document.getElementById("TVShow_id")
        tvShowId.style.visibility = "hidden"
    };
    update();
</script>
<!--display pop up box with message to user -->
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
                <h5 class="modal-title" id="exampleModalCenterTitle">To watch full episode please subscribe.</h5>
            </div>
            <div class="modal-footer">
                <div class="form-group">
                    <a href="user.php"> <button type="button" class="btn" id="button1" role="button"> Subscribe Here </button></a>
                </div>
            </div>
        </div><!--Close body-->
    </div><!--Close modal-body-->
</div><!-- Close modal-fade-->
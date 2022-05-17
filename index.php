<?php
# Access session.
session_start();

$userID = $_SESSION['user_id'];
# Set page title and display header section.
$page_title = 'About';
if($userID == null){
   include ( 'includes/login.php' ); 
}else{
   include ( 'includes/logout.php' ); 
}

# Display body section.
echo "<h1 style='text-align:center;'>About</h1>";

?>
<!-- display images and test in columns of 3 -->
<div class="container">
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <div class="col" style=" padding-bottom: 20px">
            <div class="card h-100" >
                <img src="image/feedback.png" class="card-img-top" alt="Image with chalkboard">
                <div class="card-body">
                    <h5 class="card-title">Give us your suggestions.</h5>
                    <p class="card-text">Tell us what features you would like to see on Webflix, and we will be implementing the most requested ones. So make sure you get your suggesting in, by email.</p>
                </div>
            </div>
        </div>
        <div class="col" style=" padding-bottom: 20px">
            <div class="card h-100">
                <img src="image/Streaming.jpg" class="card-img-top" alt="With living room and Wifi icon.">
                <div class="card-body">
                    <h5 class="card-title">Webflix New Streaming Service</h5>
                    <p class="card-text">Welcome to Webflix. Make to sure to register we are a brand-new streaming service, providing awesome content at an affordable price.</p>
                </div>
            </div>
        </div>
        <div class="col" style=" padding-bottom: 20px">
            <div class="card h-100">
                <img src="image/MovieIndex.png" class="card-img-top" alt="Image with OLD MOVIES words">
                <div class="card-body">
                    <h5 class="card-title">Movie must have's.</h5>
                    <p class="card-text">Email us what Movies you would want to see on Webflix next month.</p>
                </div>
            </div>
        </div>
        <div class="col" style=" padding-bottom: 20px">
            <div class="card h-100">
                <img src="image/99.99.jpg" class="card-img-top" alt="Image with £99.99">
                <div class="card-body">
                    <h5 class="card-title">Join for just £99.99.</h5>
                    <p class="card-text">Join for just £99.99, buy a premium subscription for the whole year for just £99.99. Get access to full length movies and TV shows.</p>
                </div>
            </div>
        </div>
        <div class="col" style=" padding-bottom: 20px">
            <div class="card h-100">
                <img src="image/comingSoon.jpg" class="card-img-top" alt="Image with the words coming soon">
                <div class="card-body">
                    <h5 class="card-title">Coming Soon page.</h5>
                    <p class="card-text">Have a look at the Coming Soon page for a sneak peek to content that will be premiering on Webflix next Month.</p>
                </div>
            </div>
        </div>
        <div class="col" style=" padding-bottom: 20px">
            <div class="card h-100">
                <img src="image/comedy.jpg" class="card-img-top" alt="Imagew with the word comedy">
                <div class="card-body">
                    <h5 class="card-title">Join us for our Comedy Movie Marathon.</h5>
                    <p class="card-text">Truly the comedy genres is responsible for some of the greatest movies of all time.</p>
                </div>
            </div>
        </div>
        <div class="col" style=" padding-bottom: 20px">
            <div class="card h-100">
                <img src="image/TVShowsIndex.jpg" class="card-img-top" alt="Colorful image with TV">
                <div class="card-body">
                    <h5 class="card-title">Tell us your favourite TV Shows.</h5>
                    <p class="card-text">And if we've left out your favourite TV Shows, let us know. We are constantly adding new TV Shows so keep an eye out for your favourite, or why not try something new.</p>
                </div>
            </div>
        </div>
        <div class="col" style=" padding-bottom: 20px">
            <div class="card h-100">
                <img src="image/About7.jpg" class="card-img-top" alt="Forrest gump image">
                <div class="card-body">
                    <h5 class="card-title">How many times have you seen this movie??</h5>
                    <p class="card-text">“My mama always said, ‘Life was like a box of chocolates. You never know what you’re gonna get.'” -Forrest Gump.</p>
                </div>
            </div>
        </div>
        <div class="col" style=" padding-bottom: 20px">
            <div class="card h-100">
                <img src="image/categories.png" class="card-img-top" alt="Categories image">
                <div class="card-body">
                    <h5 class="card-title">New Categories!!!</h5>
                    <p class="card-text">New Categories coming soon, we are always expanding our content, we will be adding Documentaries next, Tell us what documentaries you would like to see on Webflix.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include('includes/footer.html');

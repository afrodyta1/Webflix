<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>	
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="includes/styleSheet.css">
        <title>logout(HTML)</title>

    </head>
    <body>
        <nav  id="nav1"  class="navbar navbar-expand-lg navbar-light" >
            <a class="navbar-brand" href="index.php"><img src="image/Logo.JPG" class="card-img-top" alt="..." style="max-width: 10rem;"></a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="container">
                <div class="collapse navbar-collapse" id="navbarScroll">
                    <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                        <li class="nav-item">
                            <a id="text2" class="nav-link active" href="index.php">About</a>
                        </li>
                        <li class="nav-item">
                            <a id="text2" class="nav-link active" href="coming_soon.php">Coming Soon</a>
                        </li>
                        <li class="nav-item">
                            <a id="text2" class="nav-link active" href="content_type.php">Content</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a id="text2" class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo "{$_SESSION['first_name']} {$_SESSION['last_name']} " ?> 
                            </a>
                            <ul id="nav1"  class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
                                <li><a id="text2" class="dropdown-item" href="user.php">User Account</a></li>
                                <?php
                                if ($_SESSION['role_id'] === "1") {
                                    echo'<li><a id="text2" class="dropdown-item"  href="admin_dashboard.php">Admin Dashboard</a></li>';
                                }
                                ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a id="text2" class="dropdown-item" href="logout.php">Logout </a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </body>
</html>
<?php
//get json object form file called countryList
$data = file_get_contents("countryList.json"); 
//convert json object into PHP data type
$data = json_decode($data, true);
?>

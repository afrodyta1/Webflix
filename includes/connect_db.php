<?php
//connection to database
$link = mysqli_connect('localhost', 'HNDSOFTSA24', '33vFmXSEfG', 'HNDSOFTSA24');

if (!$link) {
    die('Could not connect to MySQL: ' . mysqli_error());//catches error 
}

?>
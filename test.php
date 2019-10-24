<?php
include 'includes/header.php';
//Inkluzija konekcije sa fajlom koji hendla bazu podataka
include 'includes/db.php';

 
 //echo password_hash('secret', PASSWORD_BCRYPT, array('cost' => 12));

echo loggedInUserId();


?>
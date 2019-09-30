<?php include "db.php"; ?>
<!--Uključi sesiju -->
<?php session_start(); ?>

<?php

if(isset($_POST['login'])){
  //hvatanje inputa od login forme
  $username = $_POST['username'];
  $password = $_POST['password'];

  //čišćenje inputa tako da se ne može proslijediti neki query kroz input
  $username = mysqli_real_escape_string($connection, $username);
  $password = mysqli_real_escape_string($connection, $password);

  //query za selektovanje usera koji je unio tačan username i password
  $query = "SELECT * FROM users WHERE username = '{$username}' ";
  $select_user_query = mysqli_query($connection, $query);

  //provjera konekcije
  if(!$select_user_query){
    die("QUERY FAILED" . mysqli_error($connection));
  }

  //while loop za čupanje podataka o useru
while($row = mysqli_fetch_assoc($select_user_query)){
  $db_id = $row['user_id'];
  $db_username = $row['username'];
  $db_password = $row['user_password'];
  $db_firstname = $row['user_firstname'];
  $db_lastname = $row['user_lastname'];
  $db_user_role = $row['user_role'];

}

//If statement koja provjerava uneseni username i pasword sa podacima iz baze podataka ako se ti podaci ne podudaraju onda redirektuje na index.php ako se podudaraju onda redirektuje na admin sekciju ako se bilo šta mimo toga desi npr pogodi ime ali ne pogodi pasword onda opet redirektuje na index.php
if($username === $db_username && $password === $db_password){
    //Postavljamo sesiju tako što username iz baze postavljamo u globalnu varajablu session i onda kada pozovemo tu varijablu sa tim parametrom imat ćemo podatak o kojem useru se radi
   $_SESSION['username'] = $db_username;
   //hvatamo podatke o firstname i čuvamo
    $_SESSION['firstname'] = $db_firstname;
    //hvatamo podatke o lastname i čuvamo
    $_SESSION['lastname'] = $db_lastname;
    //hvatamo podatke o user role i čuvamo
    $_SESSION['role'] = $db_user_role;

    header("Location: ../admin");
}else{
  header("Location: ../index.php");
}

}

?>
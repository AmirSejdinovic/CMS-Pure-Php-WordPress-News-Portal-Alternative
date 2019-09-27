<?php include "db.php"; ?>

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
  echo $db_id = $row['user_id'];
  $username = $row['username'];
  $password = $row['user_password'];
}

}

?>
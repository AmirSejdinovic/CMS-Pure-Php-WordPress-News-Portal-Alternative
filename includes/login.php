<?php session_start(); ?>
<?php include "db.php"; ?>
<?php include "../admin/functions.php"; ?>
<!--Uključi sesiju -->


<?php

if(isset($_POST['login'])){


    //hvatanje inputa od login forme
  login_user($_POST['username'], $_POST['password']);
     
  

}

?>
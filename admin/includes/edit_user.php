<?php

if(isset($_GET['edit_user'])){
  $current_user_id = $_GET['edit_user'];

  $query = "SELECT * FROM users WHERE user_id = $current_user_id ";
  $edit_user_query = mysqli_query($connection, $query);
  comfirm($edit_user_query);

  while($row = mysqli_fetch_assoc($edit_user_query)){
   $user_id = $row['user_id'];
   $username = $row['username'];
   $user_firstname = $row['user_firstname'];
   $user_lastname = $row['user_lastname'];
   $user_email = $row['user_email'];
   $user_image = $row['user_image'];
   $user_role = $row['user_role'];
   $user_password = $row['user_password'];
   $salt = $row['randSalt'];
  }

}
  if(isset($_POST['edit_user'])){

           
     $user_firstname = $_POST['user_firstname'];
     $user_lastname = $_POST['user_lastname'];
     $user_role = $_POST['user_role'];

     $username = $_POST['username'];

     
     //$post_image = $_FILES['image']['name'];
     //postavlja sliku u tmp fajl
     //$post_image_temp = $_FILES['image']['tmp_name'];

     $user_email = $_POST['user_email'];
     $user_password = $_POST['user_password'];
     //$post_date = date('d-m-y');
     //$post_comment_count = 0;
     $user_image = "sp.jpg";//default value zahtjeva 
      $randSalt = "sss";//default value zahtejva

     //php funckija koja premjesta sliku iz temp fajl u lokaciju koju mi želimo to je ovdje folder images u root direktoriju
     //move_uploaded_file($post_image_temp, "../images/$post_image");

     //query za selektovanje randSalt tabele iz db
     $query = "SELECT randSalt FROM users";
     $select_randSalt_query = mysqli_query($connection, $query);
     //test
     if(!$select_randSalt_query){
       die("QUERY FAILED" . mysqli_error($connection));
     }
     //čuvamo u varaijblu podataka iz baze
     $row = mysqli_fetch_assoc($select_randSalt_query);
     //biramo teablu iz baze i čuvamo podatke iz te tabele u varaijblu kod nas su to salt ključevi
     $salt = $row['randSalt'];
      //kreiramo crypt funkciju i onda čuvamo tako generisanu šifru u varijabli koju zatim prosljeđujemo u query za update kako bi ista išla u bazu
     $hashed_password = crypt($user_password, $salt);




     $query ="UPDATE users SET ";
     $query .="user_firstname = '{$user_firstname}', ";
     $query .="user_lastname ='{$user_lastname}', ";
     $query .="user_role = '{$user_role}', ";
     $query .="username = '{$username}', ";
     $query .="user_email = '{$user_email}', ";
     $query .="user_password = '{$hashed_password }' ";
     $query .="WHERE user_id = {$current_user_id} ";
     
     $update_user_query = mysqli_query($connection, $query);

     comfirm($update_user_query );











  }

?>


<form action="" method="post" enctype="multipart/form-data">

<div class="form-group">

 <label for="title">Firstname</label>
 <input type="text" class="form-control" name="user_firstname" value="<?php echo $user_firstname; ?>">
</div>

<div class="form-group">

 <label for="title">Lastname</label>
 <input type="text" class="form-control" name="user_lastname" value="<?php echo $user_lastname; ?>">
</div>



<div class="form-group">
  <select name="user_role" id="">
  <option value="<?php echo $user_role; ?>"><?php echo $user_role; ?></option>
  <?php
   if($user_role == 'admin'){
    echo "<option value='subscriber'>Subsciber</option>";
   }else{
    echo "<option value='admin'>Admin</option>";
   }
  ?>
     
     
     
  </select>

  <!--<label for="post_category">Post Category Id</label>
  <input type="text" class="form-control" name="post_category_id">-->
</div>



<!--<div class="form-group">
  <label for="post_image">Post Image</label>
  <input type="file" name="image">
</div>-->

<div class="form-group">
 <label for="post_tags">Username</label>
 <input type="text" class="form-control" name="username" value="<?php echo $username; ?>">
</div>

<div class="form-group">
 <label for="post_content">Email</label>
 <input type="email" class="form-control" name="user_email" value="<?php echo $user_email; ?>">
</div>

<div class="form-group">
 <label for="post_content">Password</label>
 <input type="password" class="form-control" name="user_password" value="<?php echo  $user_password; ?>">
</div>

<div class="form-group">
  <input type="submit" class="btn btn-primary" name="edit_user" value="Add user">
</div>


</form>
<?php
  if(isset($_POST['create_users'])){

           
     $user_firstname = escape($_POST['user_firstname']);
     $user_lastname = escape($_POST['user_lastname']);
     $user_role = escape($_POST['user_role']);

     $username = escape($_POST['username']);

     
     //$post_image = $_FILES['image']['name'];
     //postavlja sliku u tmp fajl
     //$post_image_temp = $_FILES['image']['tmp_name'];

     $user_email = escape($_POST['user_email']);
     $user_password = escape($_POST['user_password']);
     //$post_date = date('d-m-y');
     //$post_comment_count = 0;
     $user_image = "sp.jpg";//default value zahtjeva 
      $randSalt = "sss";//default value zahtejva

      //enkripcija passworda i sotranje u varijablu koju ćemo proslijediti u query i onda tako u bazu
      $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost'=>10));

     //php funckija koja premjesta sliku iz temp fajl u lokaciju koju mi želimo to je ovdje folder images u root direktoriju
     //move_uploaded_file($post_image_temp, "../images/$post_image");

     //Query za dodavanje usera u bazu
     $query ="INSERT INTO users(user_firstname, user_lastname, user_role, username, user_email, user_password,user_image) ";
     $query .= "VALUES ('{$user_firstname}', '{$user_lastname}', '{$user_role}' , '{$username}', '{$user_email}', '{$user_password}', '{$user_image}') ";

     //Prosljeđivanje querya sa konekcijom
     $create_user_query = mysqli_query($connection, $query);

     //Provjera konekcije kroz funkciju confirm koju smo napravili u funcitons.php
     comfirm($create_user_query);


    echo "User Created: " . " " . "<a href='users.php'>View Users</a>";



  }

?>


<form action="" method="post" enctype="multipart/form-data">

<div class="form-group">

 <label for="title">Firstname</label>
 <input type="text" class="form-control" name="user_firstname">
</div>

<div class="form-group">

 <label for="title">Lastname</label>
 <input type="text" class="form-control" name="user_lastname">
</div>

<div class="form-group">
  <select name="user_role" id="">
     <option value="subscriber">Select an option</option>
     <option value="admin">Admin</option>
     <option value="subscriber">Subsciber</option>
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
 <input type="text" class="form-control" name="username">
</div>

<div class="form-group">
 <label for="post_content">Email</label>
 <input type="email" class="form-control" name="user_email">
</div>

<div class="form-group">
 <label for="post_content">Password</label>
 <input type="password" class="form-control" name="user_password">
</div>

<div class="form-group">
  <input type="submit" class="btn btn-primary" name="create_users" value="Add user">
</div>


</form>
<?php
  if(isset($_POST['create_post'])){

     $post_title = escape($_POST['title']);
     $post_user = escape($_POST['post_user']);
     $post_category_id = escape($_POST['post_category_id']);

     $post_status = escape($_POST['post_status']);
     //hvata ime slike i ime
     $post_image = $_FILES['image']['name'];
     //postavlja sliku u tmp fajl
     $post_image_temp = $_FILES['image']['tmp_name'];

     $post_tags = escape($_POST['post_tags']);
     $post_contnet = escape($_POST['post_content']);
     $post_date = date('d-m-y');
     $post_comment_count = 0;

     //php funckija koja premjesta sliku iz temp fajl u lokaciju koju mi želimo to je ovdje folder images u root direktoriju
     move_uploaded_file($post_image_temp, "../images/$post_image");

     //Query za dodavanje posta u bazu podataka
     $query ="INSERT INTO posts(post_category_id, post_title, post_user, post_date, post_image, post_content, post_tags, post_comment_count, post_status) ";
     $query .= "VALUES ({$post_category_id}, '{$post_title}', '{$post_user}', now(), '{$post_image}' , '{$post_contnet}', '{$post_date}', {$post_comment_count}, '{$post_status}')";

     //Prosljeđivanje querya sa konekcijom
     $add_post_query_send = mysqli_query($connection, $query);

     //Provjera konekcije kroz funkciju confirm koju smo napravili u funcitons.php
     comfirm($add_post_query_send);
      //mysqli funkcija koja ubacuje zadnji id
     $post_id_current = mysqli_insert_id($connection);
     echo "<p class='bg-success'>Post Created. <a href='../post.php?p_id={$post_id_current}'>View post</a> or <a href='posts.php'>Edit More Posts</a></p>"; 



  }

?>


<form action="" method="post" enctype="multipart/form-data">

<div class="form-group">

 <label for="title">Post Title</label>
 <input type="text" class="form-control" name="title">
</div>

<div class="form-group">
<label for="categories">Categories</label>
  <select name="post_category_id" id="post_category">
   <?php
   
   $query = "SELECT * FROM categories";
   $select_categories_by_id = mysqli_query($connection, $query);

   //comfirm($select_categories_by_id);

   while($row = mysqli_fetch_assoc($select_categories_by_id)){
         $cat_id = $row['cat_id'];
         $cat_title = $row['cat_title'];

         echo "<option value='{$cat_id}'>$cat_title</option>";


   }
   
   ?>
  
  
  </select>

  <!--<label for="post_category">Post Category Id</label>
  <input type="text" class="form-control" name="post_category_id">-->
</div>

<div class="form-group">
<label for="users">Users</label>
  <select name="post_user" id="post_category">
   <?php
   
   $query = "SELECT * FROM users";
   $select_users_by_id = mysqli_query($connection, $query);

   //comfirm($select_categories_by_id);

   while($row = mysqli_fetch_assoc($select_users_by_id)){
         $user_id = $row['user_id'];
         $username = $row['username'];

         echo "<option value='{$username}'>$username</option>";


   }
   
   ?>
  
  
  </select>

  <!--<label for="post_category">Post Category Id</label>
  <input type="text" class="form-control" name="post_category_id">-->
</div>


<!--<div class="form-group">
  <label for="title">Post Author</label>
  <input type="text" class="form-control" name="author">
</div>-->




<div class="form-group">

  <label for="post_status">Post Status</label>
  <select name="post_status" id="">
    <option value="draft">Select Options</option>
    <option value="published">Published</option>
    <option value="draft">Draft</option>
  </select>

 


</div>

<div class="form-group">
  <label for="post_image">Post Image</label>
  <input type="file" name="image">
</div>

<div class="form-group">
 <label for="post_tags">Post Tags</label>
 <input type="text" class="form-control" name="post_tags">
</div>

<div class="form-group">
 <label for="post_content">Post Content</label>
 <textarea name="post_content" class="form-control" id="body" cols="30" rows="10"></textarea>
</div>

<div class="form-group">
  <input type="submit" class="btn btn-primary" name="create_post" value="Publish Post">
</div>


</form>
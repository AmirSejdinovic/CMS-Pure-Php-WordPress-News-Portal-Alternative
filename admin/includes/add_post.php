<?php
  if(isset($_POST['create_post'])){

     $post_title = $_POST['title'];
     $post_author = $_POST['author'];
     $post_category_id = $_POST['post_category_id'];

     $post_status = $_POST['post_status'];
     //hvata ime slike i ime
     $post_image = $_FILES['image']['name'];
     //postavlja sliku u tmp fajl
     $post_image_temp = $_FILES['image']['tmp_name'];

     $post_tags = $_POST['post_tags'];
     $post_contnet = $_POST['post_content'];
     $post_date = date('d-m-y');
     $post_comment_count = 4;

     //php funckija koja premjesta sliku iz temp fajl u lokaciju koju mi želimo to je ovdje folder images u root direktoriju
     move_uploaded_file($post_image_temp, "../images/$post_image");

     //Query za dodavanje posta u bazu podataka
     $query ="INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_comment_count, post_status) ";
     $query .= "VALUES ({$post_category_id}, '{$post_title}', '{$post_author}', now(), '{$post_image}' , '{$post_contnet}', '{$post_date}', '{$post_comment_count}', '{$post_status}')";

     //Prosljeđivanje querya sa konekcijom
     $add_post_query_send = mysqli_query($connection, $query);

     //Provjera konekcije kroz funkciju confirm koju smo napravili u funcitons.php
     comfirm($add_post_query_send);






  }

?>


<form action="" method="post" enctype="multipart/form-data">

<div class="form-group">

 <label for="title">Post Title</label>
 <input type="text" class="form-control" name="title">
</div>

<div class="form-group">
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
  <label for="title">Post Author</label>
  <input type="text" class="form-control" name="author">
</div>

<div class="form-group">
  <label for="post_status">Post Status</label>
  <input type="text" class="form-control" name="post_status">
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
 <textarea name="post_content" class="form-control" id="" cols="30" rows="10"></textarea>
</div>

<div class="form-group">
  <input type="submit" class="btn btn-primary" name="create_post" value="Publish Post">
</div>


</form>
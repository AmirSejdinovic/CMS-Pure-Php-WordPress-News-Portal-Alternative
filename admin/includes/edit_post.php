
<?php

if(isset($_GET['p_id'])){
   
    $post_id_current =  $_GET['p_id'];


}
 $query ="SELECT * FROM posts WHERE post_id = $post_id_current";
 //uspostava konekcije i prosljeđivanje querya
 $select_posts_by_id = mysqli_query($connection, $query);

 

 //While loop koja čupa sve iz baze iz tabele posts i pretvaranje pdataka u varjable
 while($row = mysqli_fetch_assoc($select_posts_by_id)){

  $post_id = $row['post_id'];
  $post_author = $row['post_author'];
  $post_title = $row['post_title'];
  $post_category_id = $row['post_category_id'];
  $post_status = $row['post_status'];
  $post_image = $row['post_image'];
  $post_tags = $row['post_tags'];
  $post_comment_count = $row['post_comment_count'];
  $post_date = $row['post_date'];
  $post_content = $row['post_content'];

 }

 if(isset($_POST['update_post'])){
    
        $update_title = escape($_POST['post_title']);
        $update_cat_id = escape($_POST['post_category_id']);
        $update_post_author = escape($_POST['post_author']);
        $update_post_title = escape($_POST['post_title']);
        $update_post_status = escape($_POST['post_status']);
        $update_image = $_FILES['post_image']['name'];
        $update_image_temp = $_FILES['post_image']['tmp_name'];
        $update_post_content = escape($_POST['post_content']);
        $update_post_tags = escape($_POST['post_tags']);


        move_uploaded_file($update_image_temp, "../images/$update_image");


        if(empty($update_image)){
           $query = "SELECT * FROM posts WHERE post_id = $post_id_current";
           $query_select_image = mysqli_query($connection, $query);

           comfirm($query_select_image);

           while($row = mysqli_fetch_assoc($query_select_image)){
                $post_image = $row['post_image'];
           }
        }

        $query ="UPDATE posts SET ";
        $query .="post_title = '{$update_post_title}', ";
        $query .="post_category_id = {$update_cat_id}, ";
        $query .="post_date = now(), ";
        $query .="post_author = '{$update_post_author}', ";
        $query .="post_status = '{$update_post_status}', ";
        $query .="post_tags = '{$update_post_tags}', ";
        $query .="post_content = '{$update_post_content}', ";
        $query .="post_image = '{$update_image}' ";
        $query .="WHERE post_id = {$post_id_current} ";
       

        

        $update_post_query = mysqli_query($connection, $query);

        comfirm($update_post_query);

        echo "<p class='bg-success'>Post Updated. <a href='../post.php?p_id={$post_id_current}'>View post</a> or <a href='posts.php'>Edit More Posts</a></p>";




 }


?>


<form action="" method="post" enctype="multipart/form-data">

<div class="form-group">

 <label for="title">Post Title</label>
 <input value="<?php echo $post_title; ?>" type="text" class="form-control" name="post_title">
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
</div>

<div class="form-group">
  <label for="title">Post Author</label>
  <input value="<?php echo $post_author; ?>" type="text" class="form-control" name="post_author">
</div>

<div class="form-group">
<select name="post_status" id="">

  <option value='<?php $post_status; ?>'><?php echo $post_status; ?></option>

  <?php
  if($post_status == 'published'){
      echo "<option value='draft'>Draft</option>";
  }else{
    echo "<option value='published'>Publish</option>";
  }
   ?>
</select>
</div>



<div class="form-group">
  <img width="100" src="../images/<?php echo $post_image; ?>" alt="">
  <label for="post_image">Chose Image</label>
  <input type="file" name="post_image">
</div>

<div class="form-group">
 <label for="post_tags">Post Tags</label>
 <input value ="<?php echo $post_tags; ?>" type="text" class="form-control" name="post_tags">
</div>

<div class="form-group">
 <label for="post_content">Post Content</label>
 <textarea name="post_content" class="form-control" id="body" cols="30" rows="10">
 <?php echo $post_content; ?> 
 </textarea>
</div>

<div class="form-group">
  <input type="submit" class="btn btn-primary" name="update_post" value="Edit Post">
</div>


</form>
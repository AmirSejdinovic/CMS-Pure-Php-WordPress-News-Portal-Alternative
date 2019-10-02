<?php

if(isset($_POST['checkBoxArray'])){
  
  foreach($_POST['checkBoxArray'] as $checkBoxValue){
      
    $bulk_options = $_POST['bulk_options'];
  }
}

?>


<form action="" method="post">
<table class="table table-bordered table-hover">


          <div id="bulkOptionsContainer" class="col-xs-4">
            <select  class="form-control" name="bulk_options" id="">
              <option value="">Select Options</option>
              <option value="">Publish</option>
              <option value="">Draft</option>
              <option value="">Delete</option>
            
            </select>
          </div>

          <div class="col-xs-4">
           <input type="submit" name="submit" class="btn btn-success" value="Apply">
           <a class="btn btn-primary" href="add_post.php">Add New</a>
          </div>
                        <thead>
                          <tr>
                            <th><input id="selectAllBoxes" type="checkbox"></th>
                            <th>ID</th>
                            <th>Author</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Image</th>
                            <th>Tags</th>
                            <th>Comments</th>
                            <th>Date</th>
                            <th>Edit</th>
                            <th>Delete</th>
                          </tr>
                        </thead>
                        <tbody>
                        

                          <?php
                          //query za selektovanje svih stavki u tabeli post dakle svih postova
                          $query ="SELECT * FROM posts";
                          //uspostava konekcije i prosljeđivanje querya
                          $post_display_query = mysqli_query($connection, $query);

                          //Testiranje konekcije 
                          if(!$post_display_query){
                            die('FAILED'. mysqli_erorr($connection));
                          }

                          //While loop koja čupa sve iz baze iz tabele posts i pretvaranje pdataka u varjable
                          while($row = mysqli_fetch_assoc($post_display_query)){

                           $post_id = $row['post_id'];
                           $post_author = $row['post_author'];
                           $post_title = $row['post_title'];
                           $post_category_id = $row['post_category_id'];
                           $post_status = $row['post_status'];
                           $post_image = $row['post_image'];
                           $post_tags = $row['post_tags'];
                           $post_comment_count = $row['post_comment_count'];
                           $post_date = $row['post_date'];


                           echo "<tr>";

                           ?>

                             <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $post_id; ?>'/></td>


                             <?php
                             echo "<td>{$post_id}</td>";
                             echo "<td>{$post_author}</td>";
                             echo "<td>{$post_title}</td>";
                             
                          $query ="SELECT * FROM categories WHERE cat_id = {$post_category_id}";
                             $select_categories_id = mysqli_query($connection,$query);

                             while($row = mysqli_fetch_assoc($select_categories_id)){

                              $cat_id = $row['cat_id'];
                              $cat_title = $row['cat_title'];

                              echo "<td>{$cat_title}</td>";
                             }

                             



                             echo "<td>{$post_status}</td>";
                             echo "<td><img  width='100' src='../images/$post_image' alt='image'></td>";
                             echo "<td>{$post_tags}</td>";
                             echo "<td>{$post_comment_count}</td>";
                             echo "<td>{$post_date }</td>";
                             echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
                             echo "<td><a href='posts.php?delete={$post_id}'>Delete</a></td>";
                             
                           echo "</tr>";
                           
                          }


                          ?>


                          
                      </tbody>
                      </table>
                      </form>


                      <?php
                         //ako je postavjen get delte onda uradi ovo
                       if(isset($_GET['delete'])){
                         //sačuvaj vrijednost ključa delete u varijabli
                          $the_post_id = $_GET['delete'];

                          //query za brisanje posta
                       $query ="DELETE FROM posts WHERE post_id = {$the_post_id}";
                       //šaljemo query u bazu
                       $delte_query_post = mysqli_query($connection, $query);

                       //provjera konekcije
                       comfirm($delte_query_post);

                       header("Location: posts.php");

                       }
                       ?>
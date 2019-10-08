<?php

if(isset($_POST['checkBoxArray'])){
  //prolazi koroz checkboxove sa name checkBoxArray (koje smo predhodno postavili kao arayy u samom name) i za svaki chekirani box koji se nalazi u array postavlja varjalbu $checkBoxValue i čuva sve njegove paramtere u toj varijabli
  foreach($_POST['checkBoxArray'] as $postValueId){
      
    $bulk_options = $_POST['bulk_options'];
    //provjeramavamo varaijablu bulk options i poredimo je sa raznim slučajevima a to su kod nas opcije iz select elementa dakle "published", "draft", "delete". Znači kada je bulk options ima parametar npr published onda uradio ovo a kada ima neki drugi parametar onda uradi nešto drugo
    switch($bulk_options){

      //Slučaj ako je selektovan publish onda uradi ovu queryi za update posta sa draft na published
       case 'published':
         $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId} ";
         $send_query_to_published_status = mysqli_query($connection, $query);
         comfirm($send_query_to_published_status );
         break;

           //Slučaj ako je selektova draft onda uradi query za update posta na post status draft
         case 'draft':
         $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId} ";
         $send_query_to_draft_status = mysqli_query($connection, $query);
         comfirm($send_query_to_draft_status);
         break;
          //Slučaj ako je selektovan delete onda uradi query za delete posta te obriši post
         case 'delete':
          $query = "DELETE FROM posts WHERE post_id = {$postValueId} ";
          $send_delete_post_query = mysqli_query($connection, $query);
          comfirm($send_delete_post_query);
         break;

         //Case za kljcnu rijec clone ako je izabrana ta opcija uradi sve ispod
         case 'clone':
         //birmo post 
    $query = "SELECT * FROM posts WHERE post_id = '{$postValueId}' ";
    $select_post_query = mysqli_query($connection, $query);
   //while loop da dobijemo podatke od posta koji treba klonirati
    while($row = mysqli_fetch_assoc($select_post_query)){
        $post_title = $row['post_title'];
        $post_category_id = $row['post_category_id'];
        $post_date = $row['post_date'];
        $post_author = $row['post_author'];
        $post_status = $row['post_status'];
        $post_image = $row['post_image'];
        $post_tags = $row['post_tags'];
        $post_content = $row['post_content'];
        $post_comment_count = $row['post_comment_count'];
        

    }
    //query za kloniranje posta 
    $query = "INSERT INTO posts (post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags,post_status, 	post_comment_count, post_views_count) ";
    $query .= "VALUES({$post_category_id}, '{$post_title}', '{$post_author}', now() , '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}','{$post_comment_count}', 0 ) ";
    
    $copy_query = mysqli_query($connection, $query);
    if(!$copy_query){
      die("Query Failed: " . mysqli_error($connection));
    }
         break;


    }
  }
}

?>


<form action="" method="post">
<table class="table table-bordered table-hover">


          <div id="bulkOptionsContainer" class="col-xs-4">
            <select  class="form-control" name="bulk_options" id="">
              <option value="">Select Options</option>
              <option value="published">Publish</option>
              <option value="draft">Draft</option>
              <option value="delete">Delete</option>
              <option value="clone">Clone</option>
            
            </select>
          </div>

          <div class="col-xs-4">
           <input type="submit" name="submit" class="btn btn-success" value="Apply">
           <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
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
                            <th>View post</th>
                            <th>Edit</th>
                            <th>Delete</th>
                            <th>Views</th>
                          </tr>
                        </thead>
                        <tbody>
                        

                          <?php
                          //query za selektovanje svih stavki u tabeli post dakle svih postova
                          $query ="SELECT * FROM posts ORDER BY post_id DESC ";
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
                           $post_views = $row['post_views_count'];



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

                             //Novi način prikaza broja kometera. Queryem selektujemo sve tabele iz table comments gdje je comment_post_id jednak post id
                              $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
                              $send_commnet_query = mysqli_query($connection, $query);
                              //Jednostavni ulazak u bazu
                              $row = mysqli_fetch_assoc($send_commnet_query);
                              //Pornalazenje coment id za taj komentar i pohranjivanje u varijablu
                              $comment_id = $row['comment_id'];
                              //borjimo broj redova i prikazujemo broj komentara
                              $count_comments = mysqli_num_rows($send_commnet_query);

                             echo "<td><a href='post_comments.php?id=$post_id'>{$count_comments}</a></td>";


                             echo "<td>{$post_date }</td>";
                             echo "<td><a href='../post.php?p_id={$post_id}'>View post</a></td>";
                             echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
                             echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete') \" href='posts.php?delete={$post_id}'>Delete</a></td>";
                             echo "<td><a href='posts.php?reset={$post_id}'>{$post_views}</a></td>";
                             
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

                       //resetovanje broja pregeleda
                       if(isset($_GET['reset'])){
                         $the_id = $_GET['reset'];

                         $query = "UPDATE posts SET post_views_count = 0 WHERE post_id =". mysqli_real_escape_string($connection, $_GET['reset']) . " ";
                         $reset_query = mysqli_query($connection, $query);

                         comfirm($reset_query);
                         header("Location: posts.php");
                       }
                       ?>
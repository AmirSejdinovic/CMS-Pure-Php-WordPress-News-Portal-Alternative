<table class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Author</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Image</th>
                            <th>Tags</th>
                            <th>Comments</th>
                            <th>Date</th>
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
                             echo "<td>{$post_id}</td>";
                             echo "<td>{$post_author}</td>";
                             echo "<td>{$post_title}</td>";
                             echo "<td>{$post_category_id}</td>";
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

                       }
                       ?>
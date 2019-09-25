<table class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Author</th>
                            <th>Comment</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>In Response to</th>
                            <th>Date</th>
                            <th>Approve</th>
                            <th>Unapprove</th>
                            <th>Edit</th>
                            <th>Delete</th>
                          </tr>
                        </thead>
                        <tbody>
                        

                          <?php
                          //query za selektovanje svih polja unutar tabele comments u bazi podataka
                          $query ="SELECT * FROM comments";
                          //uspostava konekcije i prosljeđivanje querya
                          $comments_display_query = mysqli_query($connection, $query);

                          //Testiranje konekcije 
                          if(!$comments_display_query){
                            die('FAILED'. mysqli_erorr($connection));
                          }

                          //While loop koja čupa sve informacije iz polja unutar tabele comments u bazi podataka
                          while($row = mysqli_fetch_assoc($comments_display_query)){

                           $comment_id = $row['comment_id'];
                           $comment_post_id = $row['comment_post_id'];
                           $comment_author = $row['comment_author'];
                           $comment_email = $row['comment_email'];
                           $comment_content = $row['comment_content'];
                           $comment_status = $row['comment_status'];
                           $comment_date = $row['comment_date'];
                          

                           echo "<tr>";
                             echo "<td>{$comment_id}</td>";
                             echo "<td>{$comment_author}</td>";
                             echo "<td>{$comment_content}</td>";
                             echo "<td>{$comment_email}</td>";
                             echo "<td>{$comment_status}</td>";
                             

                             //Na osnovu id posta kojeg smo dobili kroz super globalnu varijablu get unutar post.php formiramo u bazi taj unos i onda na osnovu tog unosa imamo id posta u coment_post_id i onda na osnovu tog id biramo tačno post na kome je izvršen komentar putem query WHERE post_id = $comment_post_id
                             $query ="SELECT * FROM posts WHERE post_id = $comment_post_id ";
                             //slanje querya
                             $select_post_title_by_id = mysqli_query($connection, $query);

                              //testiranje konekcije i querya
                             comfirm($select_post_title_by_id);

                             //while loop koja prolazi kroz sve postove i čupa nazive postova prema id na kome su izvršeni komentari
                             while($row = mysqli_fetch_assoc($select_post_title_by_id)){
                               //pohranjujemo post id i post title u varijable
                               $post_id = $row['post_id'];
                               $post_title = $row['post_title'];
                                //prikaz sadržaja varijabli tj naslova posta i id posta te uspostava linka putem kojeg idemo na taj post
                               echo "<td><a href='../post.php?p_id=$post_id'>{$post_title}</a></td>";
                             }

                            


                             echo "<td>{$comment_date}</td>";
                             echo "<td><a href='posts.php?source=edit_post&p_id={$comment_id}'>Approve</a></td>";
                             echo "<td><a href='posts.php?delete={$comment_id}'>Unapprove</a></td>";

                             echo "<td><a href='posts.php?source=edit_post&p_id={$comment_id}'>Edit</a></td>";
                             echo "<td><a href='posts.php?delete={$comment_id}'>Delete</a></td>";
                             
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
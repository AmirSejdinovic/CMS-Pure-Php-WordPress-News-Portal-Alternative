<table class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <th>Email</th>
                            <th>Role</th>
                            
                            
                          </tr>
                        </thead>
                        <tbody>
                        

                          <?php
                          //query za selektovanje svih polja unutar tabele comments u bazi podataka
                          $query ="SELECT * FROM users";
                          //uspostava konekcije i prosljeđivanje querya
                          $users_display_query = mysqli_query($connection, $query);

                          //Testiranje konekcije 
                          if(!$users_display_query){
                            die('FAILED'. mysqli_erorr($connection));
                          }

                          //While loop koja čupa sve informacije iz polja unutar tabele comments u bazi podataka
                          while($row = mysqli_fetch_assoc($users_display_query)){

                           $user_id = $row['user_id'];
                           $username = $row['username'];
                           $user_password = $row['user_password'];
                           $user_firstname = $row['user_firstname'];
                           $user_lastname = $row['user_lastname'];
                           $user_email = $row['user_email'];
                           $user_image = $row['user_image'];
                           $user_role = $row['user_role'];
                          

                           echo "<tr>";
                             echo "<td>{$user_id}</td>";
                             echo "<td>{$username}</td>";
                             echo "<td>{$user_firstname}</td>";
                             echo "<td>{$user_lastname}</td>";
                             echo "<td>{$user_email}</td>";
                             echo "<td>{$user_role}</td>";
                      
                            


                             
                             echo "<td><a href='comments.php?approve={}'>Approve</a></td>";
                             echo "<td><a href='comments.php?unapprove={}'>Unapprove</a></td>";

                             
                             echo "<td><a href='comments.php?delete={}'>Delete</a></td>";
                             
                           echo "</tr>";
                           
                          }


                          ?>


                          
                      </tbody>
                      </table>


                      <?php
                         //ako je postavjen get delte onda uradi ovo
                       if(isset($_GET['delete'])){
                         //sačuvaj vrijednost ključa delete u varijabli
                          $the_comment_id = $_GET['delete'];

                          //query za brisanje komentara
                       $query ="DELETE FROM comments WHERE comment_id = {$the_comment_id }";
                       //šaljemo query u bazu
                       $delte_query_post = mysqli_query($connection, $query);

                       //provjera konekcije
                       comfirm($delte_query_post);
                         //refresh da bi promjene bile isntant
                       header("Location: comments.php");

                       }

                       //ako je get postavljen key unapprove u bazu podataka u polje comment status ubaci unapprove
                       if(isset($_GET['unapprove'])){

                        $unapprove_com_id = $_GET['unapprove'];
                         
                        $query ="UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = $unapprove_com_id ";

                        $unaprove_query_send = mysqli_query($connection, $query);

                        comfirm($unaprove_query_send);

                        header("Location: comments.php");

                       }
                       //ako je get postavlje key na approve u bazu podataka u polje comment statsu ubaci approve
                       if(isset($_GET['approve'])){
                           $approve_com_id = $_GET['approve'];

                           $query ="UPDATE comments SET comment_status = 'approved' WHERE comment_id = $approve_com_id  ";
                           $query_approve_send = mysqli_query($connection,$query);

                           comfirm($query_approve_send);

                           header("Location: comments.php");
                       }


                       ?>
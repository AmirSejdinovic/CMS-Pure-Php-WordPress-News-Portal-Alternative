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
                      
                            


                             
                             echo "<td><a href='users.php?change_to_admin={$user_id}'>Admin</a></td>";
                             echo "<td><a href='users.php?change_to_subscriber={$user_id}'>Subscriber</a></td>";

                             echo "<td><a href='users.php?source=edit_user&edit_user={$user_id}'>Edit</a></td>";
                             echo "<td><a href='users.php?delete={$user_id}'>Delete</a></td>";
                             
                             
                           echo "</tr>";
                           
                          }


                          ?>


                          
                      </tbody>
                      </table>


                      <?php
                         //ako je postavjen get delte onda uradi ovo
                       if(isset($_GET['delete'])){
                         
                        //Uvođenje sigurnosti tj provjeramo ako je sesija postavljena na user role onda omogući brisanje
                        if(isset($_SESSION['role'])){


                          //Te ako je user role admin onda mu omogući brisanje usera a ako je bilo koje druga rola onda onemogući
                          if($_SESSION['role'] == 'admin'){

                         

                        
                         //sačuvaj vrijednost ključa delete u varijabli
                          $the_user_id = mysqli_real_escape_string($connection,$_GET['delete']);

                          //query za brisanje komentara
                       $query ="DELETE FROM users WHERE user_id = {$the_user_id}";
                       //šaljemo query u bazu
                       $delte_query_user = mysqli_query($connection, $query);

                       //provjera konekcije
                       comfirm($delte_query_user);
                         //refresh da bi promjene bile isntant
                       header("Location: users.php");

                          }

                        }

                       }

                       //ako je get postavljen key unapprove u bazu podataka u polje comment status ubaci unapprove
                       if(isset($_GET['change_to_admin'])){

                        $the_user_id = $_GET['change_to_admin'];
                         
                        $query ="UPDATE users SET user_role = 'admin' WHERE user_id = $the_user_id ";

                        $change_admin_query = mysqli_query($connection, $query);

                        comfirm($change_admin_query);

                        header("Location: users.php");

                       }
                       //ako je get postavlje key na approve u bazu podataka u polje comment statsu ubaci approve
                       if(isset($_GET['change_to_subscriber'])){
                           $the_user_id = $_GET['change_to_subscriber'];

                           $query ="UPDATE users SET user_role = 'subscriber' WHERE user_id = $the_user_id  ";
                           $change_subscriber_query = mysqli_query($connection,$query);

                           comfirm($change_subscriber_query);

                           header("Location: users.php");
                       }


                       ?>
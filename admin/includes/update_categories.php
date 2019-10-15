<form action="" method="post">
                        <label for="cat_title">Update Category</label>
                        <div class="form-group">
                         <?php
                         //Hvatanje getera sa parametrom edit
                         if(isset($_GET['edit'])){
                          //Ako je kliknuto edit onda hvatamo value od parametra   
                         $edit_cat_id = $_GET['edit'];
                         
                         //query za selektovanje određene kategorije sa id iz get parametra  
                         $query = "SELECT * FROM categories WHERE cat_id = {$edit_cat_id}";
                         $select_categories_edit = mysqli_query($connection, $query);
                          //while loop
                         while($row = mysqli_fetch_assoc($select_categories_edit)){
                           //hvatanje podataka iz bazae za tu konkretnu kategoriju
                           $cat_id = $row['cat_id'];
                           $cat_title = $row['cat_title'];

                          ?>

                          <input value="<?php if(isset($cat_title)){echo $cat_title;}?>" type="text" class="form-control" name="cat_title">

                          <?php
                         }
                        
                         }
                         ?>

                         <?php
                            //Provjera da li je forma za editovanje submitana
                           if(isset($_POST['update_category'])){
                             //hvatanje cat tile iz inputa gore
                             $edit_cat_title = $_POST['cat_title'];
                            //prepare statement update 
                           $stmt = mysqli_prepare($connection,"UPDATE categories SET cat_title = ? WHERE cat_id = ? ");
                           //bind params
                           mysqli_stmt_bind_param($stmt, 'si', $edit_cat_title, $cat_id );
                           //execute param
                           mysqli_stmt_execute($stmt);
                           if(!$stmt){
                             die ("Failed" . mysqli_erorr($connection));
                           }

                           redirect("categories.php");
                           }

                           ?>

                         </div>

                         <div 
                         class="form-group">
                         
                         <input class="btn btn-primary" type="submit" name="update_category" value="Update Category">
                         </div>
                        
                        </form>
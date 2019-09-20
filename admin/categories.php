
<?php include 'includes/header.php'; ?>
<body>

    <div id="wrapper">

<?php include 'includes/nav.php'; ?>



        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">

                        <h1 class="page-header">
                            Welcome to admin
                            <small>Author</small>
                        </h1>

                        <div class="col-xs-6">
                        <?php

                         //provjera da li je forma submitana
                         if(isset($_POST['submit'])){
                           
                           $cat_title = $_POST['cat_title'];
                             //validacija forme
                           if($cat_title == "" || empty($cat_title)){

                            echo "This field shoudl not be empty";

                           }else{
                               //query za insert unosa u bazu podataka
                            $query = "INSERT INTO categories(cat_title) ";
                            $query .= "VALUE('{$cat_title}') ";

                          
                            //prosljeđivanje queryija u bazu
                            $create_category_query = mysqli_query($connection, $query);

                            //provjera konekcije  
                            if(!$create_category_query){
                              die("FAILED" . mysqli_error($connection));
                            }
                               

                           }

                         }


                        ?>


                        <form action="" method="post">
                        <label for="cat_title">Add Category</label>
                         <div class="form-group">
                         
                         <input type="text" class="form-control" name="cat_title">
                         </div>

                         <div 
                         class="form-group">
                         
                         <input class="btn btn-primary" type="submit" name="submit" value="Add Category">
                         </div>
                        
                        </form>

                       <?php
                       if(isset($_GET['edit'])){
                         $cat_id = $_GET['edit'];

                         include "includes/update_categories.php";

                       }
      
                        ?>

                        </div>

                       <div class="col-xs-6">

                      

                       <table class="table table-bordered table-hover">
                         <thead>
                           <tr>
                             <th>Id</th>
                             <th>Category Title</th>

                           </tr>
                         </thead>
                         <tbody>

                         <?php
                           //query za čupanje kategorija iz db
                          $query = "SELECT * FROM categories";
                       
                          $select_categories_admin = mysqli_query($connection, $query);

                         //while loop za prikaz kategorija iz db
                         while($row = mysqli_fetch_assoc($select_categories_admin)){

                            $cat_id = $row['cat_id'];
                           $cat_title = $row['cat_title'];
                        ?>
                          <tr>
                          <td><?php echo $cat_id ?></td>
                          <td><?php echo $cat_title ?></td>
                        <!--pravi link za geter kojim ćemo uhfatiti parametar "delete" i prosljediti mu id od kategorije iz baze-->
                          <td><a href="categories.php?delete=<?php echo $cat_id; ?>">Delete</a></td>

                          <!--pravi link za geter kojim ćemo uhfatiti parametar "edit" i prosljediti mu id od kategorije-->
                          <td><a href="categories.php?edit=<?php echo $cat_id; ?>">Edit</a></td>
                         </tr>


                        <?php

                         }
                         
                         ?>

                         <?php

                          //Provjeravamo da li je poslan get request sa parametrom "delete"
                           if(isset($_GET['delete'])){
                              

                            //ako je poslan get sa gornjim parametrom onda čuvamo cat_id od tog parametra tj od id kategorije iz baze
                              $delete_cat_id = $_GET['delete'];

                              //nakon toga pravimo query sa zadatkom da izbriše kategoriju sa tim id iz baze podataka 
                           $query = "DELETE FROM categories WHERE cat_id = {$delete_cat_id} ";
                            //šaljemo query u bazu
                           $delete_query_send = mysqli_query($connection, $query);

                           //refrešujemo stranicu kako bi odmah na front pageu se vidjele promjene bez da user manuelno refrešuje
                           header("Location: categories.php");



                           }
                         ?>
                         
                       
                         </tbody>
                       </table>
                       
                       
                       </div>

                       
                       
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
<?php include 'includes/footer.php'; ?>
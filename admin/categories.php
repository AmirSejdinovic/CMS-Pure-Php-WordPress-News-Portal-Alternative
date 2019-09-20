
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

                         insert_categories();

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

                       //Ažuriraj i uključi formu na klik na edit dugme
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
                         deleteCategories();
                          
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
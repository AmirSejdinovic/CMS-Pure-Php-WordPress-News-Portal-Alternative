
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
                           if($cat_title = "" || empty($cat_title)){

                            echo "This field shoudl not be empty";

                           }else{
                               //query za insert unosa u bazu podataka
                            $query = "INSERT INTO categories(cat_title) ";
                            $query .= "VALUE('{$_POST['cat_title']}') ";

                          
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
                        </div>

                       <div class="col-xs-6">

                      <?php
                      //query za čupanje kategorija iz db
                       $query = "SELECT * FROM categories";
                       
                       $select_categories_admin = mysqli_query($connection, $query);

                         ?>

                       <table class="table table-bordered table-hover">
                         <thead>
                           <tr>
                             <th>Id</th>
                             <th>Category Title</th>
                           </tr>
                         </thead>
                         <tbody>

                         <?php

                         //while loop za prikaz kategorija iz db
                         while($row = mysqli_fetch_assoc($select_categories_admin)){

                            $cat_id = $row['cat_id'];
                           $cat_title = $row['cat_title'];
                        ?>
                          <tr>
                          <td><?php echo $cat_id ?></td>
                          <td><?php echo $cat_title ?></td>
                          
                         </tr>


                        <?php

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
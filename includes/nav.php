
<!--Uključi sesiju -->
<?php session_start(); ?>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">



            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Light CMS </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">

                 <?php

                 //Query za biranje iz categories tabele svih polja
                $query = "SELECT * FROM categories";
                $select_all_categories_query = mysqli_query($connection, $query);

                //LOOP za uzimanje svih polja iz kategorije i prikaz na frontendu
                while($row = mysqli_fetch_assoc($select_all_categories_query)){

                    $cat_title = $row['cat_title'];
                    $cat_id = $row['cat_id'];

                    echo "<li><a href='category.php?category=$cat_id'>{$cat_title}</a></li>";

                }

                 
                    ?>

                   <li>
                        <a href="admin">Admin</a>
                    </li>

                    <li>
                        <a href="contact.php">Contact us</a>
                    </li>

                    <li>
                        <a href="registration.php">Registration</a>
                    </li>
                 
                 <?php
                 //Ako ima sesija sa rolom usera onda uradi ovo
                 if(isset($_SESSION['role'])){

                    //ako je postavljen get parametara sa p_id tj ako ide na post onda 
                     if(isset($_GET['p_id'])){

                        //uzmi paramtear id iz geta i sačuvaj u varijabli 
                       $curent_id = $_GET['p_id'];

                       //Prikaži link koji upućuje na admin skeciju stranicu edit za taj post i uhvati taj post prema get parametru p_id dakle prema id
                        echo "<li><a href='admin/posts.php?source=edit_post&p_id={$curent_id}'>Edit Post</a></li>";
                     }
                 }
                 
                 ?>
                    

                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
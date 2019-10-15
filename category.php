<?php

   //Inkluzija modula header iz foldera includes 
   include 'includes/header.php';
   include 'admin/functions.php';
   //Inkluzija konekcije sa fajlom koji hendla bazu podataka
   include 'includes/db.php';
?>

<?php include 'includes/nav.php';?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
    <div class="col-md-8">


     <?php


     if(isset($_GET['category'])){
          
         $cat_id_current = $_GET['category'];

     //Ovdje koristimo funkciju koju smo definisali u functions.php i koja nam vraća da li je admin ili nije
    if(is_admin($_SESSION['username'])){

        //Umjesto stare query sada koristimo mysqli funkciju mysqli_prepare() u koju prosjeđujemo dva parametra konekciju i query samo što umjesto unosa dinamički stavljamo upitnik i iste ćemo popuniiti kroz varijable. Kod nas je to id posta
        $stm1 = mysqli_prepare($connection, "SELECT post_id, post_title, post_author, post_date, post_image, post_content  FROM posts WHERE 	post_category_id = ?");




    }else{
        //Umjesto stare query prepare statement za prikaz postova samo onih koji imaju post status sa draft
        $stm2 = mysqli_prepare($connection, "SELECT post_id, post_title, post_author, post_date, post_image, post_content  FROM posts WHERE 	post_category_id = ? AND post_status = ? ");

      //storamo uslov od post statusa
        $published = 'published';
    }

    //provejravamo ako je postavljena prva preper statemen onda uradi ovo
    if(isset($stm1)){
        //mysqli funckija koja spaja preper statement i dinamički sadržaj za koga smo ostavili placehodler u statementu a to je ?. Ova fija ima tri parametra  prvi uslov je statement, drugi je tip podataka koji prosjedjujemo kod nas je intiger tj broj i zato stavljamo i i onda varijablia koja nosi taj sadrzaj
      mysqli_stmt_bind_param($stm1, "i", $cat_id_current);
      //izvrši statement 
      mysqli_stmt_execute($stm1);
     //ova fija spaja statement i ostale rezultate tj polja iz baze podataka
     mysqli_stmt_bind_result($stm1, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content );
       //pravimo varijablu koju popunjavamo podacima iz gore querya
      $stmt = $stm1;

    }else{
        //spajanje, ovdje imamo dva uslva sa dvije vrste podataka tj sa intigerom i stringom i onda postavljamo dvije varijable sa tim unosim
        mysqli_stmt_bind_param($stm2, 'is', $cat_id_current, $published);
        //izvršenja
        mysqli_stmt_execute($stm2);
         //spoji rezultat
         mysqli_stmt_bind_result($stm2,  $post_id, $post_title, $post_author, $post_date, $post_image, $post_content);
        //pravimo varijablu i popunjavamo podacima iz gore navedenog querya
        $stmt = $stm2;
    }

     if(mysqli_stmt_num_rows($stmt) === 0){
         echo "<h1 class='text-center'>No posts available</h1>";
     }

     


    //nova while looop i uslov prilagođeni prepare statements, za ovu vrstu llop ne treba nam da idemo i da hvatamo svaki red iz baze ponaosob nego smo te redove već ranije gore postavili kao varijable

     while( mysqli_stmt_fetch($stmt)):


         

         ?>


<h1 class="page-header">
    Page Heading
    <small>Secondary Text</small>
</h1>

<!-- First Blog Post -->
<h2>
    <a href="post.php?p_id=<?php //postavljanje getera sa post id
    echo $post_id; ?>"><?php echo $post_title; //display title ?></a>
</h2>
<p class="lead">
    by <a href="index.php"><?php echo $post_author; ?></a>
</p>
<p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
<hr>
<a href="post.php?p_id=<?php echo $post_id; ?>">
<img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
</a>
<hr>
<p><?php echo $post_content; ?></p>
<a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

<hr>



<?php

     endwhile;

      mysqli_stmt_close($stmt);

//nastavak whille loop
     }else{
         header("Localtion: index.php");
     }
   ?>

   </div>
<?php include 'includes/sidebar.php' ?>
</div>
        <!-- /.row -->

        <hr>
<?php 
include 'includes/footer.php';

?>
<?php

   //Inkluzija modula header iz foldera includes 
   include 'includes/header.php';
   //Inkluzija konekcije sa fajlom koji hendla bazu podataka
   include 'includes/db.php';
?>

<?php include 'includes/nav.php';?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
    <div class="col-md-8">

    <h1 class="page-header">
    Page Heading
    <small>Secondary Text</small>
</h1>

     <?php
     //Izaberi sve iz post tabele
     $query = "SELECT * FROM posts ";
      //uspostava konekcije sa bazom i prosljeđivanje queriya
     $select_all_posts = mysqli_query($connection, $query);


     //whille loop koja prolazi kroz bazu i čupa sve što se u njoj nalazi po zadanim putanjama dakle preka principu array 

     //mysqli_fetch_assoc je funkcija koja nam daje asocijativnu array dakle sa ključevima po nazivima polja iz tabele koju smo gore selektovali

     while($row = mysqli_fetch_assoc($select_all_posts)){

         //čupanje id iz rowa
         $post_id = $row['post_id'];
         $post_title = $row['post_title'];//čupanje post_title rowa
         $post_author = $row['post_author'];//čupanje post_author rowa iz tablee
         $post_date = $row['post_date'];//čupanje post_date rowa iz tabele
         $post_image = $row['post_image'];//čupanje post_image rowa iz tabele
         $post_content = substr($row['post_content'],0,150);//čupanje post_contene rowa iz rabele, pravljenje putem fije substr excerpta od 0 do 150 karaktera
          $post_status = $row['post_status'];

          if($post_status == 'published'){





          
         //prekid while loop

         ?>




<!-- First Blog Post -->
<h2>
    <a href="post.php?p_id=<?php //postavljanje getera sa post id
    echo $post_id; ?>"><?php echo $post_title; //display title ?></a>
</h2>
<p class="lead">
    by <a href="author_posts.php?author=<?php echo $post_author; ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_author; ?></a>
</p>
<p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
<hr>
<a href="post.php?p_id=<?php echo $post_id; ?>">
<img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
</a>
<hr>
<p><?php echo $post_content; ?></p>
<a class="btn btn-primary" href="post.php?p_id=<?php //postavljanje getera sa post id
    echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

<hr>



<?php
          }
//nastavak whille loop

     }//kraj whille loop
   ?>

   </div>
<?php include 'includes/sidebar.php' ?>
</div>
        <!-- /.row -->

        <hr>
<?php 
include 'includes/footer.php';

?>
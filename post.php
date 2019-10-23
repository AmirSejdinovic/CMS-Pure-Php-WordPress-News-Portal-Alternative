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


     <?php


       if(isset($_GET['p_id'])){
              
          $current_post_id =  $_GET['p_id'];
           //query za updatovanje tabele post_views_count i kada god nek ode na post update se vrši tako što se dodaje 1 u tabelu na osnovu toga možemo da vidimo broj pregleda
          $view_query = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = $current_post_id  ";
          $send_query = mysqli_query($connection, $view_query);

          if(!$view_query){
              die("QUERY FAILED: " . mysqli_error($connection));
          }

          if(isset($_SESSION['role']) && isset($_SESSION['role']) == 'admin'){
            $query = "SELECT * FROM posts WHERE post_id = $current_post_id ";
          }else{
            $query = "SELECT * FROM posts WHERE post_id = $current_post_id AND post_status = 'published' ";
          }
       
     //Izaberi sve iz post tabele
     //$query = "SELECT * FROM posts WHERE post_id = $current_post_id ";
      //uspostava konekcije sa bazom i prosljeđivanje queriya
     $select_all_posts = mysqli_query($connection, $query);

     if(mysqli_num_rows($select_all_posts) < 1){
          echo "<h1 class='text-center'>No posts available</h1>";
     }else{

     


     //whille loop koja prolazi kroz bazu i čupa sve što se u njoj nalazi po zadanim putanjama dakle preka principu array 

     //mysqli_fetch_assoc je funkcija koja nam daje asocijativnu array dakle sa ključevima po nazivima polja iz tabele koju smo gore selektovali

     while($row = mysqli_fetch_assoc($select_all_posts)){

         $post_title = $row['post_title'];//čupanje post_title rowa
         $post_author = $row['post_author'];//čupanje post_author rowa iz tablee
         $post_date = $row['post_date'];//čupanje post_date rowa iz tabele
         $post_image = $row['post_image'];//čupanje post_image rowa iz tabele
         $post_content = $row['post_content'];//čupanje post_contene rowa iz rabele

         //prekid while loop

         ?>


<h1 class="page-header">
    Post
    
</h1>

<!-- First Blog Post -->
<h2>
    <a href="#"><?php echo $post_title; //display title ?></a>
</h2>
<p class="lead">
    by <a href="index.php"><?php echo $post_author; ?></a>
</p>
<p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
<hr>
<img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
<hr>
<p><?php echo $post_content; ?></p>

<div class="row">
 <p class="pull-right"><a class="like" href="#"><span class="glyphicon glyphicon-thumbs-up"> Like</span></a></p>
</div>

<div class="row">
 <p class="pull-right">Like: 10</p>
</div>

<div class="clearfix">
</div>
<hr>



<?php

//nastavak whille loop
     }
    
   ?>


   

                <!-- Blog Comments -->

                <?php
                  if(isset($_POST['create_comment'])){

                    $current_post_id =  $_GET['p_id'];

                    $comment_author = $_POST['comment_author'];
                    $comment_email = $_POST['comment_email'];
                    $comment_content = $_POST['comment_content'];
                     //provjera ako polja nisu prazna onda uradi query ispod i dodaj komentar u bazu podtaka
                    if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content)){
                    
                        
                        $query ="INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content,comment_status, comment_date)";
                    $query .="VALUES($current_post_id, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'unapproved', now())";


                    $create_comment_query = mysqli_query($connection, $query);

                    if(!$create_comment_query){
                        die("QUERY FAILED" . mysqli_error($connection));
                    }
                    //ažuriraj tabelu post_comment_count tako da svaki put kada se desi komentar dodas 1
                    /*$query = "UPDATE posts SET post_comment_count = post_comment_count + 1 ";
                    $query .="WHERE post_id = $current_post_id";

                    $update_comment_count = mysqli_query($connection, $query);*/
                        
                    }else{
                        //ako su polja prazna echo skriptu sa javascript kodom i izvrši funkciju alert
                        echo "<script>alert('Fields cannot be empty')</script>";
                    }
                   
        

                  }
                ?>

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form action="" role="form" method="post">

                    <div class="form-group">
                    <label for="Author">Author</label>
                  <input type="text" class="form-control" name="comment_author">
                        </div>

                        <div class="form-group">
                        <label for="Email">Email</label>
                            <input type="email"  class="form-control" name="comment_email">
                        </div>



                        <div class="form-group">
                        <label for="Email">Your comment</label>
                            <textarea class="form-control" rows="3" name="comment_content"></textarea>
                        </div>
                        <button type="submit"  name="create_comment" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->
                <?php

                 //query za biranje komentara koji su povezani sa postom
                 $query ="SELECT * FROM comments WHERE comment_post_id = {$current_post_id} ";
                 //provjeri status ako je approved onda prikaži
                 $query .="AND comment_status = 'approved' ";
                 //poredaj prema id 
                 $query .="ORDER BY comment_id DESC";
                 //pošalji query u bazu
                 $query_comment_read = mysqli_query($connection,$query);
                 //testiraj query i vrati greške ako ih ima
                 if(!$query_comment_read){
                     die("QUERY FAILED" . mysqli_error($connection));

                 }
                    //While loop za prikaz podataka iz tabele komentara na front end
                 while($row = mysqli_fetch_assoc($query_comment_read)){
                     $comment_author = $row['comment_author'];
                     $comment_date = $row['comment_date'];
                     $comment_content = $row['comment_content'];

                     ?>

                    <!-- Comment -->
                <div class="media">
                
                <a class="pull-left" href="#">
                    <img class="media-object" src="http://placehold.it/64x64" alt="">
                </a>
                <div class="media-body">
                    <h4 class="media-heading"><?php echo $comment_author; ?>
                        <small><?php echo $comment_date; ?></small>
                    </h4>
                    <?php echo $comment_content; ?>
                </div>
            </div>



                     <?php
                 }
                } }else{
                    //Ako nema post id redirektuj
                    header("Location: index.php");
                
               
               
               
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

<script>

//jquery da se izvrši nakon load dokumenta
$(document).ready(function(){
    //biramo emelemt sa klasom like i onda dodajemo funkciju za clikc event
    $('.like').click(function(){
        console.log("It works");
    });
});
</script>
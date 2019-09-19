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


//if statement koja sprječva grešku zbog ne definisane varijable 
//ova greška se često javlja u kontakt formama
//zbog toga provjeravamo da li je kliknuto na submit dugme i tek nakont toga formiramo varajblu iz globalne varijable post
if(isset($_POST['submit'])){

    $serach = $_POST['search'];//pretvaranje inputa u varijablu

$query = "SELECT * FROM posts WHERE post_tags LIKE '%$serach%' ";//query za traženje unosa inputa kroz bazu podataka  

$search_query = mysqli_query($connection, $query);//uspsotava konekcije i prosljeđivanje querya

if(!$search_query){
  die("Query failed" . mysqli_error($connection));
}//funkcija za provjeru kokencije za db

$count = mysqli_num_rows($search_query);//broji redove u bazi koji se podudaraju sa inputpm pretrage
if($count == 0){
    echo "<h1>No result</h1>";//ako je 0 redova u bazi onda prikazi ovaj rezultat
}else{

   


    


     //whille loop koja prolazi kroz bazu i čupa sve što se u njoj nalazi po zadanim putanjama dakle preka principu array 

     //mysqli_fetch_assoc je funkcija koja nam daje asocijativnu array dakle sa ključevima po nazivima polja iz tabele koju smo gore selektovali

     while($row = mysqli_fetch_assoc($search_query)){

         $post_title = $row['post_title'];//čupanje post_title rowa
         $post_author = $row['post_author'];//čupanje post_author rowa iz tablee
         $post_date = $row['post_date'];//čupanje post_date rowa iz tabele
         $post_image = $row['post_image'];//čupanje post_image rowa iz tabele
         $post_content = $row['post_content'];//čupanje post_contene rowa iz rabele

         //prekid while loop

         ?>


<h1 class="page-header">
    Page Heading
    <small>Secondary Text</small>
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
<a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

<hr>



<?php

//nastavak whille loop

     }//kraj whille loop
   


}
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
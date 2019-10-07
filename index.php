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

     //postavljamo broj postova u varijablu kako bi na lak način mogli da mijenjamo i kako bi mogli lako da uradimo funkcionalnost iz admin panela da određujemo koliko članaka želimo da prikažemo prije paginacije. Također ovu varijablu postavljamo na mjesto statičnih brojeva o limitu članak dakle umjesto našeg broja 5 
      $per_page = 2;
      //provjeravamo da li je postavljen get request sa parametrom page, ako je postavlje tj ako je kliknut onda napravi varijablu $page i u nju dodaj parametar tog gea
     if(isset($_GET['page'])){

        
       
        $page = $_GET['page'];
     }else{
         //ako nije onda varijablu $page ostavi praznu
         $page = "";
     }

     //Ako je $page prazna ili ima parametar 1 to znači da se radi o prvoj stranici i tada napravi varijablu $page_1 i dodaj joj vrijednost 0 tako da uvjek prikaže nove postove
     if($page == "" || $page == 1 ){
         $page_1 = 0;
     }else{
         //ako vrijednost page nije prazno ili 1 onda u tu varijablu dodaj ovu jednačinu vrjednost iz varijable $page pomnoži sa 5 i onda oduzmi 5 na taj način na svakoj sledećoj strani dobijamo nove postove
         $page_1 = ($page * $per_page ) - $per_page;
     }


     //Query za selektovanje svih postova pomoću koje ćemo odrediti koliko tačno ima redova u bazi tj postova. Ova informacija pomoći će nam prilikom izrade pagination funkcije
     $posts_query_count = "SELECT * FROM posts";
     //Šaljemo query u bazu podataka
     $post_count_send = mysqli_query($connection, $posts_query_count); 
     //mysqli funkcijom mysqli_num_rows utvrđujemo tačan broj redova u bazi tj tačan broj postova
     $count = mysqli_num_rows($post_count_send);
      
     //Ovdje djelimo broj redova sačuvan u varijabli na 5 i to uokvirujemo u php funkciju ceil() koja vraća cijeli broj tzv intiger jer bez tog cijelog broja neće nam raditi pagiancija. Dakle kada takav broj sačuvamo u varijabli tu varijablu upotrebljavamo na dnu stranice u for loop pomoću koje postavljamo linkove za paginaciju
      $count = ceil($count / $per_page); 

     //Izaberi sve iz post tabele
     $query = "SELECT * FROM posts ORDER BY post_id DESC LIMIT $page_1, $per_page";
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

      <ul class="pager">
      <?php
      //Foor loop za pagianciju dakle ovdje lop ide sve dok je varijabla $i manja ili jednaka broju iz varijable $count tj broju redova baze podatak koja je podjeljena na određeni broj , nakon toga vršimo prikaz tačnog broj tj varijable $i i u href tag dodajemo GET atribut na koga ćemo vezati funkcionalsnost tako da kada se klikne na određeni broj da nas salje konkretnu stranicu.
      for($i = 1; $i <= $count; $i++){
        //Provjeravamo da li je varijabla $i jednaka varijabli $page to znači da se nalazimo na tom broju stranice onda dodaj klasu u page kako bi se pokaza aktivni link
        if($i == $page){
            
            echo "<li><a class='active_link' href='index.php?page={$i}'>{$i}</a></li>";
        }else{
            echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
        }
        
      }
      
      
      ?>
     
      </ul>  
<?php 
include 'includes/footer.php';

?>
<?php
//Kreiranje funkcije pomoću koje ćemo na lak način da vršimo filitranje unosa u bazu podataka tako da se kroz inpute ne mogu unijeti SQL naredbe 
function escape($string){

  global $connection;

  return mysqli_real_escape_string($connection, trim($string));
}

function users_online(){

  if(isset($_GET['onlineusers'])){


   global $connection;

   if(!$connection){
     session_start();
     include("../includes/db.php");

     //Pošto imamo postavljene sesije u incudes/header.php ovdje u varijabli $session postavljamo funkciju za dobivanje id od sesije
   $session = session_id();
   //Dobivamo vrijeme
   $time = time();
   //Vrjeme outputa u sekontama
   $time_out_in_seconds = 05;
   //Računamo
   $time_out = time() - $time_out_in_seconds;
    
   //Query kojom selektujemo sve iz tabele users_online gdje je red sesija jednak id sesije
   $query = "SELECT * FROM users_online WHERE session = '$session'";
   //Šaljemo query u bazu
   $send_query = mysqli_query($connection, $query);
   //brojimo broj redova u tabeli
   $count = mysqli_num_rows($send_query);
   
   //Ako nema redova dakle ako je novi user onda postavi sesion id i sesion time za tog usera
   if($count == NULL ){
     mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session', '$time') ");  
   }else{
       //ako vec postoji user onda vrsimo update tabele
    mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session' "); 

   }
    
   //Ovom query selektujemo sve iz tabele users_online gdje je time veće od vrijednosti varijable $time_out tj 60 sekundi
   $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out' ");
   echo $count_user = mysqli_num_rows($users_online_query);



   }

   
  }//kraj get reuesta

  
}
users_online();


function comfirm($result){
//Provjera konekcije funkcija
global $connection;
  if(!$result){
    die("QUERY FAILED" . mysqli_error($connection));
  }

  
}

function insert_categories(){
   //uspostava globalne konekcije kako bi sve radilo kako treba
  global $connection;

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



}

function deleteCategories(){
  global $connection;
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
}

function recordCount($table){
  global $connection;

  //Query za selektovanje svi redova u tabeli posts
  $query = "SELECT * FROM ".$table;
  //šaljemo query u bazu
  $post_number_query = mysqli_query($connection,$query);
  $result = mysqli_num_rows($post_number_query);

  comfirm($result);

  return $result;
}

?>
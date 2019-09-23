<?php

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


?>
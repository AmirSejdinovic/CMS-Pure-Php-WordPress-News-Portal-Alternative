<?php
//Funcija za redirekciju. U ovoj funkicji nalazi se argument sa varijablom $location i ta varijabla će se puniti prilikom poziva funckije te će izvršiti redirekciju tamo gdje označimo u toj varjabli
function redirect($location){
  return header("Location:" . $location);
}
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


      //mYSQLI perepare statement za insertovanje u bazu, ovdje isto koristimo mysqli_prepare() funkciju u koju unosimo dva parametra i to kokenciju i query, na mjesto gdje treba da ubacimo dinamički podatak postavljamo upitnik i tu onda u funkciji mysqli_stmt_bind_param() ubacujemo query i ostale podatke
   $stmt= mysqli_prepare($connection, "INSERT INTO categories(cat_title) VALUES(?)");

   //Funkcija mysqli_stmt_bind_param() koristi tri parametra i to prvi je parametar query gore napravljeni, drugi je parametar koji je to tip podataka kod nas je string i zbog toga pisemo "s" i nakraju je varijabla koja nosi te podatke
   mysqli_stmt_bind_param($stmt, 's', $cat_title);

   //Ovom funkcijom mysqli_stmt_execute() vršimo egzekuciju querya
   mysqli_stmt_execute($stmt);
   //zatvaranje konekcije sa bazom podataka
   mysqli_stmt_close($stmt);
   


   //provjera konekcije  
   if(!$stmt){
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
//pravimo funkciju u kojoj generušemo kod za selektovanje iz tabela i prikaz u adminu broja članaka komentara usera U ovoj funkciji pravimo varijablu $table koju ćemo kasnije u kodu admina puniti sa nazivom tabele iz koje generisemo rezultat
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
//kreiranje funkcija za prikaz statussa i broja tabela 
function checkStatus($table,$column,$status){
  global $connection;
  $query = "SELECT * FROM $table WHERE $column = '$status' ";
  $result = mysqli_query($connection, $query);
  return mysqli_num_rows($result);
}

function checkUserRole($table,$column,$role){
  global $connection;

   $query = "SELECT * FROM $table WHERE $column = '$role' ";

   $select_all_subscibers = mysqli_query($connection, $query);
   return mysqli_num_rows($select_all_subscibers);
}
//Function za procesuitanje usera na osnovu koje dopuštamo ulazak u određenu stranicu ili ne
function is_admin($username){
   global $connection;

   $query = "SELECT user_role FROM users WHERE username =  '$username'";
   $result = mysqli_query($connection, $query);

   comfirm($result);

   $row = mysqli_fetch_assoc($result);

   if($row['user_role'] == 'admin'){
     return true;
   }else{
     return false;
   }
}
//Kreirana funkcija za ako username već postoji u bazi. Ova funkcija nam vraća true ili false value. Na osnovu toga mi možemo spriječiti da se neko registruje sa istim username. U ovoj funckiji nalazi se u argumentu varijabla $username koju ćemo kada pozovoemo funkciju puniti sa drugom varijablom koja nosi valu inputa i onda na osnovu toga ćemo porediti uneseno ime sa imenom u bazi
function username_exists($username){
   global $connection;
    //query za selektovanje username prema unesenom inputu
   $query = "SELECT  username FROM users WHERE username = '$username' ";
   //Prosljeđivanje querya
   $result = mysqli_query($connection, $query);
   comfirm($result);
   //ako ima vise od 0 redova u bazi sa gore prosljeđenim queryem onda vrati true tj. ako username već postoji
   if(mysqli_num_rows($result) > 0){
       return true;
   }else{
     //ako nema redova vrati false
     return false;
   }
}
//Kreirana funckija za ako email već postoji u bazi. ova fukcija nam vraća true ili false. U funkciji se nalazi argument sa varaijablom $email koja se puni kada pozovoemo funkciju varijablom sa inputom. Na osnovu provjere tog inputa i podataka u bazi omogućavamo ili onemogućavamo useru da se registruje
function email_exists($email){
  global $connection;
  //Query za selektovanje usrname emaila sa unosom
  $query = "SELECT user_email FROM users WHERE user_email = '$email' ";
  $result = mysqli_query($connection,$query);
  //ako ima reodva u bazi sa rezultatom tog querya onda vrati true
  if(mysqli_num_rows($result) > 0){
    return true;
  }else{
    //ako nema vrati false
    return false;
  }
}
//Funkcija za registrovanje usera, ovaj kod smo uzeli sa register.php i postavili ga u fukciju kako bi ga mogli koristiti više puta na lak način bez da pišemo sav kod. U funckiji nalaze se argumenti koji su postavljeni kao varijable $username, $email, $password i koje će se puniti prilikom poziva funckije varijablama sa unosima
function register_user($username, $email, $password){
    global $connection;

    
      //Čišćenje unesenih podataka u input polja tako da se u bazu ne mogu injektovati SQL statements nego idu čisti podaci. Zbog toga su potrebna dva parametra konekcija i input podaci kako bi se sve to procistilo
      $username = mysqli_real_escape_string($connection, $username);
      $email = mysqli_real_escape_string($connection, $email);
      $password = mysqli_real_escape_string($connection, $password);
      
      //novi sistem enkripcije possworda putem password_hash funkcije i radimo tosa BCRYPT koja je slična BLOWFISH enkripciji
      $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
     
     //Provjera default valua za randSalt ključeva koji će nam biti potrebni kod enkripcije sifre
     //$query = "SELECT randSalt FROM users";
    //$select_randSalt_query = mysqli_query($connection, $query);

     /*if(!$select_randSalt_query ){
         die("Query Failed" . mysqli_error($connection));
     }*/
      //Čuvamo u varaijabli samo rand salt kljuc

     /*$row = mysqli_fetch_assoc($select_randSalt_query);

     //Dobijamo valu od rand salta iz defaulut podataka baze podataka
     $salt = $row['randSalt'];
       //crypt funkcijom vršimo kripotvanje pasworda tako da hakeri isti ne bi mogli probiti. Dakle za ovu funkicju potrebna su dva parametra i to sifra iz baze pdotaka i salt ključevi iz iste na onsovu tih podataka ova funkcija generise jak password  
     $password = crypt($password, $salt);*/

       //QUery za insert u bazu podataka input unose usera
     $query = "INSERT INTO users (username, user_email, user_password, user_role, user_image) ";
     $query .= "VALUES('{$username}', '{$email}', '{$password}', 'subscriber', '1.jpg')";
     $register_query_user = mysqli_query($connection, $query);


    comfirm($register_query_user);
      
     //$message = "Your Registration hase been submited";

    
     
  
}

//Funkcija za login usera koju možemo korisitit više puta bez da pišemo ponovno kod. Funkcija ima dva argumenta koja su varijable $usename i $pasword te koji dobijaju value iz poziva funkcije i njenjih argumenata

function login_user($username, $password){

  global $connection;

   //Tim funkcijom vršimo brisanje praznog prostora te storamo samo karatere inputa
   $username = trim($username);
   $password = trim($password);


  //čišćenje inputa tako da se ne može proslijediti neki query kroz input
  $username = mysqli_real_escape_string($connection, $username);
  $password = mysqli_real_escape_string($connection, $password);

  //query za selektovanje usera koji je unio tačan username i password
  $query = "SELECT * FROM users WHERE username = '{$username}' ";
  $select_user_query = mysqli_query($connection, $query);

  //provjera konekcije
  if(!$select_user_query){
    die("QUERY FAILED" . mysqli_error($connection));
  }

  //while loop za čupanje podataka o useru
while($row = mysqli_fetch_assoc($select_user_query)){
  $db_id = $row['user_id'];
  $db_username = $row['username'];
  $db_password = $row['user_password'];
  $db_firstname = $row['user_firstname'];
  $db_lastname = $row['user_lastname'];
  $db_user_role = $row['user_role'];

}

//Ovim obrćemo proces tako da unsesenoj sifri u input dodajemo sifru iz baze i onda na onsovu toga radimo crypt fiju i kasnije možemo da se ulogujemo sa passowrdom koji smo unijeli provobitno
//$password = crypt($password, $db_password );

//If statement koja provjerava uneseni username i pasword sa podacima iz baze podataka ako se ti podaci ne podudaraju onda redirektuje na index.php ako se podudaraju onda redirektuje na admin sekciju ako se bilo šta mimo toga desi npr pogodi ime ali ne pogodi pasword onda opet redirektuje na index.php

//Ovaj if statement je prilagođen za novi password encript sistem i taj sitem radi sa funkcijom password_verify u koju unosimo unešeni password sačuvan u varijablu i password iz baze dakle on sam upoređuje ta dava passworda i ako su isti onda redirektuje u admin panel ako ne onda redirektuje na index.php
if(password_verify($password, $db_password)){
    //Postavljamo sesiju tako što username iz baze postavljamo u globalnu varajablu session i onda kada pozovemo tu varijablu sa tim parametrom imat ćemo podatak o kojem useru se radi
   $_SESSION['username'] = $db_username;
   //hvatamo podatke o firstname i čuvamo
    $_SESSION['firstname'] = $db_firstname;
    //hvatamo podatke o lastname i čuvamo
    $_SESSION['lastname'] = $db_lastname;
    //hvatamo podatke o user role i čuvamo
    $_SESSION['role'] = $db_user_role;

    redirect("/NoviCMS/admin/index.php");
}else{
  redirect("/NoviCMS/index.php");
}

}

?>
<?php  include "includes/db.php"; ?>
 <?php  include "includes/header.php"; ?>
 <?php include 'admin/functions.php'; ?>

  <?php
    //Ovo je novi metod provjere da li je došlo do sumbita a to radimo sa globanom varijablom $_SERVER['REQUEST_MEHTOD'] koji je jednak metodu iz fomre kod nas je to POST
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        
         //uhvati value iz inputa i postavi ih kao vrijednosti varijabli
    $username =  trim($_POST['username']); //trim() funkcija briše sva prazna mjesta koja nastaju prilikom popunjavanja i vraća samo karaktere;
    $email = trim($_POST['email']);
    $pasword = trim($_POST['password']);

    //pravimo varijablu $error sa ascijativnom array  u koju storamo ključeve i vrijednosti. Ključevi su nam nazvani po inputima a vrijednosti su prazne. Vrijednosti ćemo da punimo na osnovu određenog uslova
    $error = [
      
        'username'=>'',
        'email'=>'',
        'password'=>''


    ];
     //Validacija ako je u input username unešeno manje od 4 karaktera onda u asocijativnu array u ključ username unesi sljedeće koje ćemo variti kao grešku na front endu
    if(strlen($username) < 4){

        $error['username'] = 'Username needs to be longer';
    }
    //Validacija ako je username prazno
    if(empty($username)){
        $error['username']='Username cannot be empty'; 
    }
    //Validacija ako username već postoji. Funkcija useraname_exists je već definisana u funcitons.php
    if(username_exists($username)){
        $error['username']='Usrname already exists, pick another one';    
    }
   //Validacija ako je email prazan
    if(empty($email)){
        $error['email']='Email cannot be empty'; 
    }
   //Validacija ako email već postoji. Funkcija email_exits je već definisana u functinons.php
    if(email_exists($email)){
        $error['email']='Email already exists, <a href="index.php">Please Login</a>';    
    }
    //Validacija ako je password polje prazno
    if(empty($pasword)){
        $error['password']='Password cannot be empty';
    }

    //Radimo loop na varijabli $error koja je asocijativna araj i dodjeljujemo je kao kljuc i value
    foreach($error as $key => $value){

        //Ako je value prazno tj ako nema grešaka u array onda uradi ovaj kod tj izvrši register_user funkciju
        if(empty($value)){
            
            unset($error[$key]);
            
        }
    }//foreach kraj

    if(empty($error)){
       
        //Register user funkcija sa parametrima koji su varijable sa unosima inputa te koje se prenose u argumente funkcije i onda na osnovu toga funkcija procesuira i vraća određeni rezulate
        register_user($username, $email, $pasword);
        //Funckija login_user sa parametraima varijablama sa inputima koje prenosi u argumente funkcije i onda radi kod koji je definisan u funkciji. Ovdje konkretno se radi o logiranju usera koji već postoji u bazi
        login_user($username, $pasword);
    }

   

        

       
    }
  
  ?>
    <!-- Navigation -->
    
    <?php  include "includes/nav.php"; ?>
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                  
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username"
                            autocomplete="on"

                            value="<?php echo isset($username)? $username : '' ?>">

                            <p><?php echo isset($error['username'])? $error['username'] : '' ?></p>



                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com"
                            autocomplete="on"
                            value="<?php echo isset($email) ? $email : '' ?>">
                            <p><?php echo isset($error['email'])? $error['email'] : '' ?></p>
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password"
                            >
                            <p><?php echo isset($error['password'])? $error['password'] : '' ?></p>
                        </div>
                
                        <input type="submit" name="register" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>

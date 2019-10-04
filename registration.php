<?php  include "includes/db.php"; ?>
 <?php  include "includes/header.php"; ?>

  <?php
    //Ako je kliknuto na formu sa metodom post i name register onda uradi ovo ispod
    if(isset($_POST['register'])){
        //uhvati value iz inputa i postavi ih kao vrijednosti varijabli
       $username =  $_POST['username'];
       $email = $_POST['email'];
       $pasword = $_POST['password'];

       //Ako polja nisu prazna onda uradi kod ispod i ispisi poruku da je uspjesno registrovana
       if(!empty($username) && !empty($email) && !empty($pasword)){
            
         //Čišćenje unesenih podataka u input polja tako da se u bazu ne mogu injektovati SQL statements nego idu čisti podaci. Zbog toga su potrebna dva parametra konekcija i input podaci kako bi se sve to procistilo
         $username = mysqli_real_escape_string($connection, $username);
        $email = mysqli_real_escape_string($connection, $email);
        $password = mysqli_real_escape_string($connection, $pasword);

         //Provjera default valua za randSalt ključeva koji će nam biti potrebni kod enkripcije sifre
        $query = "SELECT randSalt FROM users";
        $select_randSalt_query = mysqli_query($connection, $query);

        if(!$select_randSalt_query ){
            die("Query Failed" . mysqli_error($connection));
        }
         //Čuvamo u varaijabli samo rand salt kljuc
        $row = mysqli_fetch_assoc($select_randSalt_query);

        //Dobijamo valu od rand salta iz defaulut podataka baze podataka
        $salt = $row['randSalt'];
          //crypt funkcijom vršimo kripotvanje pasworda tako da hakeri isti ne bi mogli probiti. Dakle za ovu funkicju potrebna su dva parametra i to sifra iz baze pdotaka i salt ključevi iz iste na onsovu tih podataka ova funkcija generise jak password  
        $password = crypt($password, $salt);

          //QUery za insert u bazu podataka input unose usera
        $query = "INSERT INTO users (username, user_email, user_password, user_role, user_image) ";
        $query .= "VALUES('{$username}', '{$email}', '{$password}', 'subscriber', '1.jpg')";
        $register_query_user = mysqli_query($connection, $query);
        //Provjera konekcije
        if(!$register_query_user){
            die("QUERY FAILED" . mysqli_error($connection));
        }
         
        $message = "Your Registration hase been submited";

       }else{

        //Ako su polja prazna onda ispisi ovo
           $message = "Fields canot be empty";
       }
        
     

        

       
    }else{
        //Trik da nam ne pirakzuje nedefinisanu varijablu
        $message = "";
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
                    <h6 class="text-center"><?php echo $message; ?></h6>
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username">
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
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

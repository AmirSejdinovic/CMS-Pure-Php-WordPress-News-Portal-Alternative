<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

//zahtjevamo fajl iz configa a to su psotavke naše i klasa
require './classes/config.php';



?>

<?php 
  if(!ifItIsMehod('get') && !isset($_GET['forgot'])){
    redirect('index');
  }

  if(ifItIsMehod('post')){
    
    if(isset($_POST['email'])){

      $email = $_POST['email'];

      $length = 50;

      $token = bin2hex(openssl_random_pseudo_bytes($length));

      if(email_exists($email)){
        
        if($stmt = mysqli_prepare($connection, "UPDATE users SET token = '{$token}' WHERE user_email = ?")){


          mysqli_stmt_bind_param($stmt, "s", $email);
          mysqli_stmt_execute($stmt);
          mysqli_stmt_close($stmt);

        //Konfiguracija PHP Mailera
        $mail = new PHPMailer();

        
          //Server settings
       
          //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
          $mail->isSMTP();                                            // Send using SMTP
          $mail->Host       = Config::SMTP_HOST;          
          $mail->SMTPAuth   = true;                          
          $mail->Username   = Config::SMTP_USER;              
          $mail->Password   = Config::SMTP_PASSWORD;          
          $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; $mail->Port       = Config::SMTP_PORT;  
          $mail ->CharSet = 'UTF-8'; 
          $mail->isHTML(true);


          
          $mail->setFrom('amir@goo.com', 'Amir Sejdinovic');
          $mail->addAddress($email, 'Joe User');

          $mail->Subject = 'Here is the subject';
          $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
          $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

          $mail->send();
          echo 'Message has been sent';
          

           

        
         

        }else{
          echo mysqli_error($connection);
        }
        


      }

    }

  }


?>


<!-- Page Content -->
<div class="container">

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">


                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Forgot Password?</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">




                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input id="email" name="email" placeholder="email address" class="form-control"  type="email">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>

                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>

                                </div><!-- Body-->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <hr>

    <?php include "includes/footer.php";?>

</div> <!-- /.container -->


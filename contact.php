<?php  include "includes/db.php"; ?>
 <?php  include "includes/header.php"; ?>

  <?php
     //ako je kliknuto na input sa contact paremetrom uradio ovo
    if(isset($_POST['contact'])){
      //storaj u varijable vrijednosti inputa
       $to = "suport@amir.com";
       $subject = wordwprap($_POST['subject'], 70);
       $body = $_POST['body'];
       $header = "From:" .$_POST['email'];

         //mail PHP funkcija koja šalje email na zadani email
        mail($to, $subject, $body, $header);
     

        

       
    }else{
      $message = 'sss';
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
                <h1>Contact</h1>
                    <form role="form" action="" method="post" id="login-form" autocomplete="off">
                    <h6 class="text-center"><?php echo $message; ?></h6>
                        
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email">
                        </div>
                        <div class="form-group">
                            <label for="subject" class="sr-only">Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter your subject">
                        </div>
                         <div class="form-group">
                           <textarea class="form-control" name="body" id="body" cols="30" rows="10"></textarea>
                        </div>
                
                        <input type="submit" name="contact" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Submit">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>

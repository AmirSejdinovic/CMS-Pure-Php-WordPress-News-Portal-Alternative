
<?php include 'includes/header.php'; ?>
<body>

    <div id="wrapper">

<?php include 'includes/nav.php'; ?>



        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                    <h1 class="page-header">
                            Welcome to admin
                            <small>Author</small>
                        </h1>
                      

                      <?php
                      //Ako je postavljen get request uzmi value od tog get requesta i sačuvaj u varijabli
                     if(isset($_GET['source'])){
                       $source = $_GET['source'];

                     }else {//ako nema get requesta onda podesi varijablu bez podataka
                        $source = '';
                     }

                      //switch izjava kojom testiramo uslove, ako je usluv iz switcha pogođen onda prikaži kod iz određenog casea a ako niti jedan od uslova nije pogođen onda pokaži kod iz defaulta  a to je inkluzija tabele sa podacima iz baze podataka
                     switch($source){
                      

                      //akoj je parametar get keya (?source=add_post) add_post onda uključi fajl add_post.php iz direktorija includes unutar admin foldera
                      case 'add_post';
                      include 'includes/add_post.php';
                      break;

                      //ako je parametar get keya (?source=edit_post) edit post onda uključi fajl edit_post.php iz direktorija includes unutar admin foldera

                      case 'edit_post';
                      include 'includes/edit_post.php';
                      break;


                      case '340';
                      echo "Nicee";
                      break;

                      case '346';
                      echo "Nice4";
                      break;

                      default:
                      include "includes/view_all_comments.php";
                      break;

                     }

                     


                    ?>
                      
                       
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
<?php include 'includes/footer.php'; ?>
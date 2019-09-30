
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
                            
                            <small><?php
                            //Prikazujemo ime usera koji se logovo. To smo omogućili na način što smo u login.php postavili sesije i sačuvali podatke o useru u globalnim varijablima. Nakon toga u ovom fajlu uključili smo sesije i samo pozivamo sa globalnom varijablom sa paremetrom iz login.php i vršimo echo
                             echo $_SESSION['username'];
                            ?></small>
                        </h1>
                       
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
<?php include 'includes/footer.php'; ?>
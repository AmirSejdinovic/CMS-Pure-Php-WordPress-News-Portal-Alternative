
<?php include 'includes/header.php'; ?>

<body>

    <div id="wrapper">

    <?php
      
    ?>

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
                        <h1>
                        
                      </h1>
                    </div>
                </div>

            
                <!-- /.row -->


                       
                <!-- /.row -->
                
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-file-text fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">

                    <?php 
                    //Query za selektovanje svi redova u tabeli posts
                     $query = "SELECT * FROM posts";
                     //šaljemo query u bazu
                     $post_number_query = mysqli_query($connection,$query);
                      //Provjera da li ima grešaka u queryu
                     if(!$post_number_query){
                         die("Query failed" . mysqli_error($connection));
                     }
                      //mysqli_num_rows funkcija koja broji broj redova u tabeli i taj broj redova čuvamo u varijabli i kasnije isti prikazujemo na front endu
                     $post_counts = mysqli_num_rows($post_number_query);
                    
                    ?>
                  <div class='huge'><?php echo $post_counts; ?></div>
                        <div>Posts</div>
                    </div>
                </div>
            </div>
            <a href="posts.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <?php 
                        //Selektovanje redova iz tabele comments
                        $query = "SELECT * FROM comments";
                        //šaljemo query
                        $count_comments_query = mysqli_query($connection, $query);
                        //provjera querya
                        if(!$count_comments_query){
                            die("Query failed" . mysqli_error($connection));
                        }
                        //brojanje redova u tabeli putem mysqli_num_rows funkcije
                        $comment_count = mysqli_num_rows($count_comments_query);
                        ?>
                     <div class='huge'><?php echo $comment_count; ?></div>
                      <div>Comments</div>
                    </div>
                </div>
            </div>
            <a href="comments.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <?php
                        //Selektovanje svih redova u tabeli users
                        $query = "SELECT * FROM users";
                        //šaljemo query
                        $count_users_query = mysqli_query($connection, $query);
                        //provjera konekcije
                        if(!$count_comments_query){
                            die("Query error" . mysqli_error($connection));
                        }
                        //brojimo redove u tabeli users 
                        $count_of_users = mysqli_num_rows($count_users_query);
                        
                        ?>
                    <div class='huge'><?php echo $count_of_users; ?></div>
                        <div> Users</div>
                    </div>
                </div>
            </div>
            <a href="users.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-list fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <?php
                        
                        $query = "SELECT * FROM categories";
                        $count_categories_query = mysqli_query($connection, $query);

                        if(!$count_categories_query){
                            die("Query failed" . mysqli_error($connection));
                        }

                        $count_of_categories = mysqli_num_rows($count_categories_query);
                        
                        ?>
                        <div class='huge'><?php echo $count_of_categories; ?></div>
                         <div>Categories</div>
                    </div>
                </div>
            </div>
            <a href="categories.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>
                <!-- /.row -->



                <?php 
                  $query = "SELECT * FROM posts WHERE post_status = 'published' ";
                  $all_published_posts = mysqli_query($connection, $query);
                  $published_posts = mysqli_num_rows($all_published_posts);
                  
                  $query = "SELECT * FROM posts WHERE post_status = 'draft'";
                  $select_all_draft_posts = mysqli_query($connection, $query);
                  $post_draft_count = mysqli_num_rows($select_all_draft_posts);

                  $query = "SELECT * FROM comments WHERE comment_status = 'unapproved'";
                  $select_all_unapproved_comments = mysqli_query($connection, $query);
                  $comments_unaproved_count = mysqli_num_rows($select_all_unapproved_comments);

                  $query = "SELECT * FROM users WHERE user_role = 'subscriber'";
                  $select_all_users_subscriber = mysqli_query($connection, $query);
                  $users_subscriber_count = mysqli_num_rows($select_all_users_subscriber);


                    ?>
                <div class="row">
                <script type="text/javascript">
                //Dodavanje gogole chartsa
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Data', 'Count'],

          //izlazak iz javascripta i prelazak u php u kome pravimo dvije array od kojih je jedna statična a druga je dinamična sa brojevima iz baze podataka nakon toga vršimo for lop na tim areyima i vršimo echo u obliku elementa javascripta 
          <?php

          $elemnt_text = ['AllPosts','Active Posts','Draft Posts', 'Comments','Unapproved comments' ,'Users','Subscribers','Categories'];
          $elemnt_count = [$post_counts, $published_posts , $post_draft_count , $comment_count , $comments_unaproved_count,$count_of_users,$users_subscriber_count, $count_of_categories];

          for($i = 0; $i < 8; $i++){
            
            echo "['{$elemnt_text[$i]}'" . "," . "{$elemnt_count[$i]}],";

          }
          ?>

         // ['posts', 1000],

         //izlazak iz php i prelazak u javascript
          
        ]);

        var options = {
          chart: {
            title: '',
            subtitle: '',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>

<div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
<?php include 'includes/footer.php'; ?>
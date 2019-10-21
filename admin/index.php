
<?php include 'includes/header.php'; ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" integrity="sha256-ENFZrbVzylNbgnXx0n3I1g//2WeO47XxoPe0vkp3NC8=" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js" integrity="sha256-3blsJd4Hli/7wCQ+bmgXfOdK7p/ZUMtPXY08jmxSSgk=" crossorigin="anonymous"></script>

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

                    
                  <div class='huge'><?php echo $post_counts = recordCount('posts'); ?></div>
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
                        
                     <div class='huge'><?php echo $comment_count = recordCount('comments'); ?></div>
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
                      
                    <div class='huge'><?php echo $count_of_users = recordCount('users'); ?></div>
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
                      
                        <div class='huge'><?php echo $count_of_categories = recordCount('categories'); ?></div>
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
                  
                  $published_posts = checkStatus('posts','post_status','published');

                  $post_draft_count  = checkStatus('posts','post_status','draft');
                  
                  $comments_unaproved_count = checkStatus('comments','comment_status','unapproved');

                  $users_subscriber_count = checkUserRole('users','user_role','subscriber');


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
<script src="https://js.pusher.com/5.0/pusher.min.js"></script>

<script>
  $(document).ready(function(){
  
  Pusher.logToConsole = true;

var pusher = new Pusher('16a276e832c30cc4ef02', {
  cluster: 'eu',
  forceTLS: true
});
var channel = pusher.subscribe('my-channel');

    channel.bind('my-event', function(data) {
        var message = data.message;
        tosttr.success(`${message} just register`);

    });
    

  });
</script>


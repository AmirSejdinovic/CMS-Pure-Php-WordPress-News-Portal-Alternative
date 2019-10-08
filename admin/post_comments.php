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
                            Welcome to Comments
                            <small>Author</small>
                        </h1>


<table class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Author</th>
                            <th>Comment</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>In Response to</th>
                            <th>Date</th>
                            <th>Approve</th>
                            <th>Unapprove</th>
                            
                            <th>Delete</th>
                          </tr>
                        </thead>
                        <tbody>
                        

                          <?php
                          //query za selektovanje svih polja unutar tabele comments u bazi podataka
                          $query ="SELECT * FROM comments WHERE comment_post_id =". $_GET['id']." ";
                          
                          //uspostava konekcije i prosljeđivanje querya
                          $comments_display_query = mysqli_query($connection, $query);

                          //Testiranje konekcije 
                          if(!$comments_display_query){
                            die('FAILED'. mysqli_error($connection));
                          }

                          //While loop koja čupa sve informacije iz polja unutar tabele comments u bazi podataka
                          while($row = mysqli_fetch_assoc($comments_display_query)){

                           $comment_id = $row['comment_id'];
                           $comment_post_id = $row['comment_post_id'];
                           $comment_author = $row['comment_author'];
                           $comment_email = $row['comment_email'];
                           $comment_content = $row['comment_content'];
                           $comment_status = $row['comment_status'];
                           $comment_date = $row['comment_date'];
                          

                           echo "<tr>";
                             echo "<td>{$comment_id}</td>";
                             echo "<td>{$comment_author}</td>";
                             echo "<td>{$comment_content}</td>";
                             echo "<td>{$comment_email}</td>";
                             echo "<td>{$comment_status}</td>";
                             

                             //Na osnovu id posta kojeg smo dobili kroz super globalnu varijablu get unutar post.php formiramo u bazi taj unos i onda na osnovu tog unosa imamo id posta u coment_post_id i onda na osnovu tog id biramo tačno post na kome je izvršen komentar putem query WHERE post_id = $comment_post_id
                             $query ="SELECT * FROM posts WHERE post_id = $comment_post_id ";
                             //slanje querya
                             $select_post_title_by_id = mysqli_query($connection, $query);

                              //testiranje konekcije i querya
                             comfirm($select_post_title_by_id);

                             //while loop koja prolazi kroz sve postove i čupa nazive postova prema id na kome su izvršeni komentari
                             while($row = mysqli_fetch_assoc($select_post_title_by_id)){
                               //pohranjujemo post id i post title u varijable
                               $post_id = $row['post_id'];
                               $post_title = $row['post_title'];
                                //prikaz sadržaja varijabli tj naslova posta i id posta te uspostava linka putem kojeg idemo na taj post
                               echo "<td><a href='../post.php?p_id=$post_id'>{$post_title}</a></td>";
                             }

                            


                             echo "<td>{$comment_date}</td>";
                             echo "<td><a href='comments.php?approve={$comment_id}'>Approve</a></td>";
                             echo "<td><a href='comments.php?unapprove={$comment_id}'>Unapprove</a></td>";

                             
                             echo "<td><a href='post_comments.php?delete={$comment_id}&id=".$_GET['id']."'>Delete</a></td>";
                             
                           echo "</tr>";
                           
                          }


                          ?>


                          
                      </tbody>
                      </table>


                      <?php
                         //ako je postavjen get delte onda uradi ovo
                       if(isset($_GET['delete'])){
                         //sačuvaj vrijednost ključa delete u varijabli
                          $the_comment_id = $_GET['delete'];

                          //query za brisanje komentara
                       $query ="DELETE FROM comments WHERE comment_id = {$the_comment_id }";
                       //šaljemo query u bazu
                       $delte_query_post = mysqli_query($connection, $query);

                       //provjera konekcije
                       comfirm($delte_query_post);
                         //refresh da bi promjene bile isntant
                       header("Location: post_comments.php?id=". $_GET['id'] ."");

                       }

                       //ako je get postavljen key unapprove u bazu podataka u polje comment status ubaci unapprove
                       if(isset($_GET['unapprove'])){

                        $unapprove_com_id = $_GET['unapprove'];
                         
                        $query ="UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = $unapprove_com_id ";

                        $unaprove_query_send = mysqli_query($connection, $query);

                        comfirm($unaprove_query_send);

                        header("Location: comments.php");

                       }
                       //ako je get postavlje key na approve u bazu podataka u polje comment statsu ubaci approve
                       if(isset($_GET['approve'])){
                           $approve_com_id = $_GET['approve'];

                           $query ="UPDATE comments SET comment_status = 'approved' WHERE comment_id = $approve_com_id  ";
                           $query_approve_send = mysqli_query($connection,$query);

                           comfirm($query_approve_send);

                           header("Location: comments.php");
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
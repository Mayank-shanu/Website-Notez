<!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title>Website Notez</title>
     <link rel="icon" href="../images/N/res/mipmap-mdpi/N.png">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
     <script defer src="https://use.fontawesome.com/releases/v5.0.1/js/all.js"></script>
     <link href="https://fonts.googleapis.com/css?family=Arima+Madurai" rel="stylesheet">
     <link href="https://fonts.googleapis.com/css?family=Cinzel+Decorative" rel="stylesheet">
     <link rel="stylesheet" href="../css/master.css">
     <style media="screen">
     body{
       /* background: url("../images/night-sky3.jpg"); */
       background-repeat: no-repeat;
       background-size: 100% 100%;
       background-attachment: fixed;
       /* color: white; */
       height: 100%;
       min-height: 100%;
       color: black;
     }
     #sort_id{

     }
     textarea{
       height: auto;
       width: 100%;

     }
     #create_note{
       margin-top: 25px;
       color: white;
       margin-top: 25px;
       background-color:rgba(0, 0, 0, 0.53);
       border-radius: 35px;
       padding-top: 15px;
       padding-bottom: 15px;
       height: auto;
       display: block;
     }
     .user_note_para {
       font-size: 105%;
       font-family: 'Arima Madurai', cursive;
     }
     .date_share{

       font-style: italic;
       font-weight: bold;
       font-size: 80%;
     }
     .date_share p{
       width: 100%;
     }
     .main_display_content{
       padding-top: 25px;
       border-top: 1px rgb(167, 194, 189) solid;
       border-bottom: 1px rgb(167, 194, 189) solid;
     }
     .user_note_title{
       font-family: 'Cinzel Decorative', cursive;
       font-weight: bold;
       font-size: 120%;
     }

     </style>
     <?php
       session_start();
       if(!$_SESSION["username"]){
         echo "
         <script type=\"text/javascript\">
               alert(\"Session Expired try login again\");
               window.location.href=\"../sign_in.html\";
         </script>
         ";
       }
       if(!$_GET["sort"]){
           $_GET["sort"] = "date";
       }
      ?>
   </head>
   <body>
     <nav class="navbar navbar-dark bg-dark navbar-expand-lg nav_control">
       <a href="..\index.html" class="navbar-brand"><img src="..\images\N\res\mipmap-xxhdpi\N.png" alt="" id="logo_image">Notez</a>
       <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
       </button>
       <div class="collapse navbar-collapse" id="navbarSupportedContent">
         <ul class="navbar-nav mr-auto">
           <li class="nav-item active">
             <a class="nav-link" href="./home.php"><i class="fas fa-home"></i>&nbsp;My home page <span class="sr-only">(current)</span></a>
           </li>
           <li class="nav-item">
             <a class="nav-link navbar_links" href="./all_notes_shared.php"><i class="fas fa-comment-alt"></i>&nbsp;Share Forum</a>
           </li>
           <li class="nav-item">
             <a class="nav-link navbar_links" href="./logout_validation.php"><i class="fas fa-sign-out-alt"></i>&nbsp;Logout</a>
           </li>
         </ul>
       </div>
     </nav>

     <div class="container">
       <?php
          $link = mysqli_connect("*****","*****","*****","*****");
          if(mysqli_connect_errno()>0){
            echo "usable to conntect to database ".mysqli_connect_error();
          }
          else{
            $username = $_SESSION["username"];
            if(strpos($username,"@"))
            $tblName = substr($username,0,strpos($username,"@"));
            else
            $tblName = $username;
            $q = "select * from " .$tblName;
            $res = mysqli_query($link,$q);
            if(!$res){
              $query = "create table ".$tblName."(note_id varchar(50) PRIMARY KEY NOT NULL,title LONGTEXT NOT NULL,note LONGTEXT NOT NULL,likes INT NOT NULL,dislikes INT NOT NULL,views INT NOT NULL,sharestatus INT NOT NULL,date varchar(30) NOT NULL)";
              if(mysqli_query($link,$query))
              echo "";
              else
              echo "unable to make directoy to store your notes.".mysqli_connect_error();
            }
            //else {
            //  echo "tbl already exist";
            //}
          }
        ?>
        <div class="row justify-content-center">
          <h2 id="welcome">Welcome <?php echo substr($_SESSION["username"],0,strpos($_SESSION["username"],"@")); ?> </h2>
        </div>

        <div class="row" style="margin-top:25px;">
          <div class="col-4">
            <button type="button" name="add_note" class="btn btn-success" onclick="toggle_note()"><i class="fas fa-edit"></i>&nbsp;Create new note</button>
          </div>
          <div class="col-4 offset-4 justify-content-right text-right" id="sort_id">
            <select class="custom-select" id="sort" onchange="update_content()">
              <option selected>Sort By</option>
              <option value="name">Name</option>
              <option value="time_a">time ascending</option>
              <option value="time_d">time desc</option>
              <option value="likes">Likes</option>
              <option value="views">Views</option>
            </select>
          </div>
        </div>
        <div class="row" id="create_note">
           <div class="col-12">
             <form  method="post" id="note_id" onsubmit="return vaidate_input()" action="note_validation.php">
               <div class="form-group">
                 <p> <label for="title"><strong>Title:</strong></label></p>
                 <input type="text" name="title" id="title" value="" placeholder="title" class="form-control">
                 <p id="title_err" class="error"></p>
               </div>
              <div class="form-group">
                <p> <label for="note"> <strong>Note:</strong> </label></p>
                <textarea name="note_textarea" rows="8" placeholder="enter your note here" id="note_textarea"></textarea>
                <p id="note_textarea_err" class="error"></p>
              </div>
              <button type="submit" class="btn btn-success" name="note_submit" style="width:100%;" onclick="vaidate_input()">Submit</button>
              <br>
             </form>
           </div>

        </div>

     </div>

  <div class="container" style="margin-top:25px;">
       <!-- <div class="row main_display_content">
             <div class="col-1 text-center justify-content-center">
             <p class="text-success"><i class="fas fa-thumbs-up"></i></p>
             <p class="text-success">21</p>
             </div>
             <div class="col-1 text-center justify-content-center">
               <p class="text-danger"><i class="fas fa-thumbs-down"></i></p>
               <p class="text-danger">5</p>
             </div>
             <div class="col-1 text-center justify-content-center">
               <p class="text-primary"><i class="fas fa-eye"></i></p>
               <p class="text-primary">5</p>
             </div>
       <div class="col-8 offset-1">
             <div class="row justify-content-center user_note_title">
               <p>Title</p>
             </div>
             <div class="row user_note_para">
               <p> this is a note  this is a note  this is a note  this is a note  this is a note  this is a note  this is a note  this is a note  this is a note </p>
             </div>
             <div class="row date_share">
               <hr width="35%" color="black">
               <p class="text-right">date: 27-mar-2022</p>
               <p class="text-right">Shared</p>
             </div>
       </div>
     </div>

     <div class="row main_display_content">
       <div class="col-1 text-center justify-content-center">
       <p class="text-success"><i class="fas fa-thumbs-up"></i></p>
       <p class="text-success">21</p>
       </div>
       <div class="col-1 text-center justify-content-center">
         <p class="text-danger"><i class="fas fa-thumbs-down"></i></p>
         <p class="text-danger">5</p>
       </div>
       <div class="col-1 text-center justify-content-center">
         <p class="text-primary"><i class="fas fa-eye"></i></p>
         <p class="text-primary">5</p>
       </div>
     <div class="col-8 offset-1">
             <div class="row justify-content-center user_note_title">
               <p>Title</p>
             </div>
             <div class="row user_note_para">
               <p> this is a note  this is a note  this is a note  this is a note  this is a note  this is a note  this is a note  this is a note  this is a note </p>
             </div>
             <div class="row date_share">
               <hr width="35%" color="black">
               <p class="text-right">date: 27-mar-2022</p>
               <p class="text-right">Shared</p>
             </div>
     </div>
   </div> -->

   <?php
        $tblname = substr($_SESSION['username'],0,strpos($_SESSION['username'],"@"));
        $link = mysqli_connect("*****","*****","*****","*****");
        if(mysqli_connect_errno()>0){
          echo "
          <div>unable to connect to server </div>
          ";
        }
        else {

            switch ($_GET["sort"]){
                case "name" : $add = " ORDER BY title";break;
                case "time_d" : $add = " ORDER BY date DESC";break;
                case "time_a" : $add = " ORDER BY date";break;
                case "views" : $add = " ORDER BY views DESC";break;
                case "likes" : $add = " ORDER BY likes DESC";break;
            }

          $q_t = "select title from $tblname".$add;
          $res_title = mysqli_query($link,$q_t);

          $q_n = "select note from $tblname".$add;
          $res_note = mysqli_query($link,$q_n);

          $q_d = "select date from $tblname".$add;
          $res_date = mysqli_query($link,$q_d);

          $q_share_stat = "select sharestatus from $tblname".$add;
          $res_share = mysqli_query($link,$q_share_stat);

          $q_l = "select likes from $tblname".$add;
          $res_likes = mysqli_query($link,$q_l);

          $q_dis = "select dislikes from $tblname".$add;
          $res_dislikes = mysqli_query($link,$q_dis);

          $q_v = "select views from $tblname".$add;
          $res_views = mysqli_query($link,$q_v);

          $date = mysqli_fetch_all($res_date);
          $title = mysqli_fetch_all($res_title);
          $note = mysqli_fetch_all($res_note);
          $share = mysqli_fetch_all($res_share);
          $likes = mysqli_fetch_all($res_likes);
          $dislikes = mysqli_fetch_all($res_dislikes);
          $views = mysqli_fetch_all($res_views);

          $no_of_rows = mysqli_num_rows($res_date);
          $i=0;
          while($i<$no_of_rows)
          {echo "

                    <div class=\"row main_display_content\">
                          <div class=\"col-1 text-center justify-content-center\">
                          <p class=\"text-success\"><i class=\"fas fa-thumbs-up\"></i></p>
                          <p class=\"text-success\">".$likes[$i][0]."</p>
                          </div>
                          <div class=\"col-1 text-center justify-content-center\">
                            <p class=\"text-danger\"><i class=\"fas fa-thumbs-down\"></i></p>
                            <p class=\"text-danger\">".$dislikes[$i][0]."</p>
                          </div>
                          <div class=\"col-1 text-center justify-content-center\">
                            <p class=\"text-primary\"><i class=\"fas fa-eye\"></i></p>
                            <p class=\"text-primary\">".$views[$i][0]."</p>
                          </div>
                    <div class=\"col-8 offset-1\">
                          <div class=\"row justify-content-center user_note_title\">
                            <p>".$title[$i][0]."</p>
                          </div>
                          <div class=\"row user_note_para\">
                            <p>".$note[$i][0]."</p>
                          </div>
                          <div class=\"row date_share\">
                            <hr width=\"35%\" color=\"black\">
                            <p class=\"text-right\">".$date[$i][0]."</p>
                            <p class=\"text-right\">Shared</p>
                          </div>
                    </div>
                    </div>


                    ";
                    $i = $i+1;
                  }
        }
    ?>

</div>

     <footer class="footer">
       <div class="container-fluid">
         <div class="row text-center" id="footer_content">
           <div class="col-sm-12 col-lg-4">
             <a href="index.html">Home&nbsp;<i class="fas fa-home"></i></a>
           </div>
           <div class="col-sm-12 col-lg-4">
             <a href="#">Sign in/up&nbsp;<i class="fas fa-sign-in-alt"></i></a>
           </div>
           <div class="col-sm-12 col-lg-4">
             <a href="#">Contact Us&nbsp;<i class="fab fa-contao"></i></a>
           </div>
         </div>
         <div class="row text-center justify-content-center" id="social_icon">
              <div class="col-12">
                <i class="fab fa-facebook fa-2x" id="facebook"></i>&nbsp;&nbsp;&nbsp;
                <i class="fab fa-twitter fa-2x" id="twitter"></i>&nbsp;&nbsp;&nbsp;
                <i class="fab fa-github-square fa-2x" id="github"></i>&nbsp;&nbsp;&nbsp;
                <i class="fab fa-whatsapp fa-2x" id="whatsapp"></i>
              </div>
         </div>
       </div>
     </footer>

     <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
     <script type="text/javascript">
           window.onload = function () {
            document.getElementById("create_note").style.display = "none";
            document.getElementById("welcome").style.display = "block";
            setTimeout(disable_welcome,3000);
           }

             function toggle_note() {
                var note_display = document.getElementById("create_note").style.display;
                if(note_display == "block"){
                  document.getElementById("create_note").style.display = "none";

                }
                if(note_display == "none"){
                  document.getElementById("create_note").style.display = "block";
                }
             }
             function disable_welcome() {
               document.getElementById("welcome").style.display = "none";

             }

             function vaidate_input() {
               var title = document.getElementById("title").value;
               var note  = document.getElementById("note_textarea").value;

               var title_err = document.getElementById("title_err");
               var note_err  = document.getElementById("note_textarea_err");

               if(!title) title_err.innerHTML = "enter title";
               else title_err.innerHTML = "";

               if(!note) note_err.innerHTML = "enter your note";
               else title_err.innerHTML = "";

               if (note && title) {
                 return true;
               }

               return false;
             }
             function update_content() {
                 var value = document.getElementById("sort").value;
                 window.location.href = "./home.php?sort="+value;
             }
     </script>
   </body>
 </html>

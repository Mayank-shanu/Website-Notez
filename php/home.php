<!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title>Website Notez</title>
     <link rel="icon" href="../images/N/res/mipmap-mdpi/N.png">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
     <script defer src="https://use.fontawesome.com/releases/v5.0.1/js/all.js"></script>
     <link rel="stylesheet" href="../css/master.css">
     <style media="screen">
     body{
       background: url("../images/night-sky3.jpg");
       background-repeat: no-repeat;
       background-size: 100% 100%;
       background-attachment: fixed;
       color: white;
       height: 100%;
       min-height: 100%;
     }
     #sort_id{

     }
     textarea{
       height: auto;
       width: 100%;

     }
     #create_note{
       color: white;
       margin-top: 25px;
       background-color:rgba(0, 0, 0, 0.53);
       border-radius: 35px;
       padding-top: 15px;
       height: auto;
       display: block;
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
      ?>
   </head>
   <body>
     <nav class="navbar navbar-dark bg-dark navbar-expand-lg nav_control">
       <a href="index.html" class="navbar-brand"><img src="..\images\N\res\mipmap-xxhdpi\N.png" alt="" id="logo_image">Notez</a>
       <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
       </button>
       <div class="collapse navbar-collapse" id="navbarSupportedContent">
         <ul class="navbar-nav mr-auto">
           <li class="nav-item active">
             <a class="nav-link" href="index.html">Home <span class="sr-only">(current)</span></a>
           </li>
           <li class="nav-item">
             <a class="nav-link navbar_links" href="#">About</a>
           </li>
           <li class="nav-item">
             <a class="nav-link navbar_links" href="#">Contact Us</a>
           </li>
           <li class="nav-item">
             <a class="nav-link navbar_links" href="sign_in.html">Sign in</a>
           </li>
           <li class="nav-item">
             <a class="nav-link navbar_links" href="sign_up.html">Sign up</a>
           </li>
         </ul>
       </div>
     </nav>

     <div class="container">
       <?php
          $link=mysqli_connect("localhost","*****","*****","*****");
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
              $query = "create table ".$tblName."(note_id INT AUTO_INCREMENT PRIMARY KEY,note LONGTEXT,likes INT)";
              if(mysqli_query($link,$query))
              echo "tbl created";
              else
              echo "tbl not created ".mysqli_connect_error();
            }
            else {
              echo "tbl already exist";
            }
          }
        ?>
        <div class="row justify-content-center">
          <h2 id="welcome">Welcome <?php echo substr($_SESSION["username"],0,strpos($_SESSION["username"],"@")); ?> </h2>
        </div>

        <div class="row">
          <div class="col-4">
            <button type="button" name="add_note" class="btn btn-success" onclick="toggle_note()"><i class="fas fa-edit"></i>&nbsp;Create new note</button>
          </div>
          <div class="col-4 offset-4 justify-content-right text-right" id="sort_id">
            <select class="custom-select" name="sort">
              <option selected>Sort By</option>
              <option value="name">Name</option>
              <option value="time_asc">time ascending</option>
              <option value="time_desc">time desc</option>
              <option value="likes">Likes</option>
              <option value="views">Views</option>
            </select>
          </div>
        </div>
        <div class="row" id="create_note">
           <div class="col-12">
             <form  method="post">
               <div class="form-group">
                 <p> <label for="title"><strong>Title:</strong></label></p>
                 <input type="text" name="title" id="title" value="" placeholder="title" class="form-control">
               </div>
              <div class="form-group">
                <p> <label for="note"> <strong>Note:</strong> </label></p>
                <textarea name="name" rows="8" placeholder="enter your note here"></textarea>
              </div>
              <button type="submit" class="btn btn-success" name="button" style="width:100%;">Submit</button>
              <br>
             </form>
           </div>

        </div>
        <div class="row justify-content-center" style="margin-top:15px;">
          <h1>your notes</h1>
        </div>
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
     </script>
   </body>
 </html>

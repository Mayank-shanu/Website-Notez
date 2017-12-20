<?php

  $username = $_POST["username"];
  $password = $_POST["password"];

  $username =  filter_var($username,FILTER_SANITIZE_STRING);
  $password = filter_var($password,FILTER_SANITIZE_STRING);

  if($username && $password){

      $link = mysqli_connect("localhost","*****","*****","*****");
      if(mysqli_connect_errno()>0){
        echo "Error in connection";
      }
      else {
        $q = "select * from user where email='$username' and password='$password'";
        $res = mysqli_query($link,$q);
        $no_of_rows = mysqli_num_rows($res);
        //echo "no of rows $no_of_rows";
        if($no_of_rows == 0){
          echo "
          <script type=\"text/javascript\">
                alert(\"incorrect email id or password\");
                window.location.href=\"../sign_in.html\";
          </script>
          ";
        }
        else {
            echo "
            <script type=\"text/javascript\">
                  alert(\"sign in done\");
            </script>
            ";
        }
      }

  }
  else {
    echo "
    <script type=\"text/javascript\">
          alert(\"Unexpected input\");
          window.location.href=\"../sign_in.html\";
    </script>
    ";
  }
 ?>

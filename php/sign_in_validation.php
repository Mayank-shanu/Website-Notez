<?php

  $username = $_POST["username"];
  $password = $_POST["password"];

  $username =  filter_var($username,FILTER_SANITIZE_STRING);
  $password = filter_var($password,FILTER_SANITIZE_STRING);

  if($username && $password){

      $link = mysqli_connect("*****","*****","*****","*****");
      if(mysqli_connect_errno()>0){
        echo "Error in connection";
      }
      else {
         // and password='$password'
        $q = "select * from user where email='$username'";
        $res = mysqli_query($link,$q);
        $no_of_rows = mysqli_num_rows($res);
        if($no_of_rows == 0){
          echo "
          <script type=\"text/javascript\">
                alert(\"incorrect email id or password\");
                window.location.href=\"../sign_in.html\";
          </script>
          ";
        }
        else {
            $row = mysqli_fetch_array($res,MYSQLI_ASSOC);
            $st_pass = $row["password"];
            $password_verify = password_verify($password,$st_pass);
            if($password_verify){
            session_start();
            $_SESSION["username"] = "$username";
            header('Location: home.php');
            }
            else {
              echo "
              <script type=\"text/javascript\">
                    alert(\"incorrect email id or password\");
                    window.location.href=\"../sign_in.html\";
              </script>
              ";
            }
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

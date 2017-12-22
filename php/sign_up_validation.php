<?php


  $username = $_POST["username"];
  $password = $_POST["password"];
  $securityQues = $_POST["security_ques"];
  $securityAns = $_POST["security_ques_ans"];

  $username = filter_var($username,FILTER_SANITIZE_EMAIL);
  $username = filter_var($username,FILTER_VALIDATE_EMAIL);

  $password = filter_var($password,FILTER_SANITIZE_STRING);
  $securityQues = filter_var($securityQues,FILTER_SANITIZE_STRING);
  $securityAns = filter_var($securityAns,FILTER_SANITIZE_STRING);

  if($username && $password && $securityAns && $securityQues){
    $link = mysqli_connect('localhost','*****','*****','*****');
    if(mysqli_connect_errno()>0){
      echo "
      <script type=\"text/javascript\">
            alert(\"unable to connect\");
      </script>
      ";
    }
     else{
       $q = "select * from user where email='$username'";
       $res = mysqli_query($link,$q);
       $num_rows = mysqli_num_rows($res);
      if($num_rows == 0){
        $query = "insert into user (email,password,security_question,security_answer) values('$username','$password','$securityQues','$securityAns')";
        $result=mysqli_query($link,$query);

            session_start();
            $_SESSION["username"] = "$username";
            header('Location: home.php');
        echo "
        <script type=\"text/javascript\">
              alert(\"Welcome to notez\");
        </script>
        ";
      }
      else {
        echo "
        <script type=\"text/javascript\">
              alert(\"username already exist try login\");
              window.location.href='../sign_up.html';
        </script>
        ";
      }
    }
  }
 ?>

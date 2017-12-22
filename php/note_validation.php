<?php
  $note = $_POST["note_textarea"];
  $title = $_POST["title"];

  $note = filter_var($note,FILTER_SANITIZE_STRING);
  $title = filter_var($title,FILTER_SANITIZE_STRING);

  if($note && $title){
    $link = mysqli_connect("localhost","*****","*****","*****");

    if (mysqli_connect_errno()>0) {
      echo "unable to connect to database";
    }

    else {
      session_start();
      $tab_name = substr($_SESSION["username"],0,strpos($_SESSION["username"],"@"));
      $date = date("d-M-y h:m a");
      //echo "$date    $tab_name";
      $q="select * from $tab_name";
      $res = mysqli_query($link,$q);
      $no_of_rows = mysqli_num_rows($res);
      //echo "<br> $no_of_rows";
      $id = $tab_name.$no_of_rows;
      // $q = "insert into $tab_name(note_id,title,note,sharestatus,likes,dislikes,view,date) values('$id','$title','$note','1','0','0','0','$date')";
      $q ="INSERT INTO ".$tab_name."(note_id,title,note,likes,dislikes,views,sharestatus,date) values ('$id','$title','$note','0','0','0','1','$date')";
      $res = mysqli_query($link,$q);
      if($res){
        echo "
        <script>
          window.location.href = 'home.php';
        </script>
        ";
      }
      else {
        echo "
        <script>
          alert(\"unable to add your note\");
          window.location.href = 'home.php';
        </script>
        ";
      }
    }
  }
  else {
    echo "
    <script>
    alert(\"unexpected input\");
    // window.location.href = 'home.php';
    </script>
    ";
  }
 ?>

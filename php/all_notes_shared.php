<?php
    session_start();
    if(!$_SESSION["username"])
    {
        echo "
        <script>
        alert(\"your session has expired\");
        window.location.href = '../sign_in.html';
        </script>
        ";
    }

    if(!$_GET["sort"]){
        $_GET["sort"] = "date";
    }

    $link = mysqli_connect("*****","*****","*****","*****");
    if(mysqli_connect_errno()>0){
        echo " <h1><b>unable o connect to server</b></h1>";
    }

    if(!$_POST["reset"]){
        $_POST["reset"]="reset";
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Website Notez</title>
    <link rel="icon" href="../images/N/res/mipmap-xhdpi/N.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <script defer src="https://use.fontawesome.com/releases/v5.0.1/js/all.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Arima+Madurai" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Cinzel+Decorative" rel="stylesheet">
    <style>
        .container{
            margin-top: 15px;
        }
        .content_row{
            /*border-top:1px gray solid;*/
            border-bottom:1px  gray solid;
            padding-top: 5px;
            padding-bottom: 5px;
            margin-top: 0;
            margin-bottom: 0;
        }
        .title{
            font-family: 'Cinzel Decorative', cursive;
            font-weight: bold;
            overflow-x: auto;
            max-lines: 2;
        }
        .description{
            margin-top: 15px;
            font-family: 'Arima Madurai', cursive;
            overflow-x: auto;
            max-lines: 3;
        }
        .link{
            color: black;
        }
        .via_username{
            font-style: italic;
            font-weight: bold;
            font-family: 'Cinzel Decorative', cursive;
            overflow-x: auto;
            font-size: 80%;
        }
        #sort_row{
            margin-bottom: 10px;
            border-bottom:1px  gray solid;
            padding-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row" id="sort_row">

        <select class="custom-select" onchange="changed_sort()" id="sort">
            <option selected>Sort By:</option>
            <option value="likes">Likes</option>
            <option value="views">Views</option>
            <option value="date">Date</option>
        </select>

    </div>
    <?php
        if($_POST["reset"] == "reset"){
            echo "
            <script>
            window.console.log('reset called');
            </script>
            ";
            $_POST["reset"] = "do_not_reset";
            $q = "defined";
            switch ($_GET["sort"]){
                case "views": $q = "SELECT * FROM all_shared_notes ORDER BY views DESC";break;
                case "likes": $q = "SELECT * FROM all_shared_notes ORDER BY likes-dislikes DESC";break;
                case "date": $q = "SELECT * FROM all_shared_notes ORDER BY date DESC";break;
            }
            $result  = mysqli_query($link,$q);
            echo "<form method='post'>";
            while ($arr = mysqli_fetch_array($result,MYSQLI_ASSOC)){

                echo "<br/>";
                $note = $arr["note"];
                $title = $arr["title"];
                $date = $arr["date"];
                $views = $arr["views"];
                $likes = $arr["likes"];
                $dislikes = $arr["dislikes"];
                $note_id = $arr["note_id"];
                $email = $arr["email"];
                $likes_per = 0;
                if($likes>=$dislikes) {
                    $display = "Likes";
                    $num = $likes;
                }
                else {
                    $display = "Dislikes";
                    $num = $dislikes;
                }
                echo "
                
                <div class=\"row content_row\">
            <div class=\"col-2 text-center justify-content-center\">
                <p><button type='submit' class='btn btn-success'  name='like_it' value='$note_id'><i class='fa fa-thumbs-up'></i></button> </p>
                <p class=\"text-primary\">$display &nbsp; $num </p>
                <p> <button type=\"submit\" class=\"btn btn-danger\"  name='dislike_it' value='$note_id'><i class='fa fa-thumbs-down'></i></button></p>
            </div>
            <div class=\"col-9 offset-1\">
                <div class=\"row title text-center justify-content-center\">
                    <p class=\"text-center justify-self-center\"><a href=\"#\" class=\"link\"> $title </a></p>
                    <p> <hr width=\"35%\"> </p>
                </div>
                <div class=\"row description\">
                    <p > $note </p>
                    <p> <hr width=\"35%\"> </p>
                </div>
                <div class=\"row\">
                    <div class=\"col-1 offset-6 justify-content-center text-center justify-self-right\">
                        <p class=\"bottom_heading text-success\"> <i class=\"fas fa-thumbs-up\"></i> </p>
                        <p class=\"bottom_heading_content\">$likes</p>
                    </div>
    
                    <div class=\"col-1 justify-content-center text-center justify-self-right\">
                        <p class=\"bottom_heading text-danger\"> <i class=\"fas fa-thumbs-down\"></i> </p>
                        <p class=\"bottom_heading_content\">$dislikes</p>
                    </div>
    
                    <div class=\"col-1 justify-content-center text-center justify-self-right\">
                        <p class=\"bottom_heading text-primary\"> <i class=\"fas fa-eye\"></i> </p>
                        <p class=\"bottom_heading_content\"> $views </p>
                    </div>
                    <div class=\"col-3 justify-content-center text-center justify-self-right\">
                        <p class=\"via_username\">By: &nbsp; $email </p>
                        <p class=\"via_username\">Dated: &nbsp; $date</p>
                    </div>
                </div>
            </div>
        </div>        
                
                ";
            }
        echo "</form>";
        }
    ?>

</div>
<?php
    if($_POST["like_it"]){
        $note_id = $_POST["like_it"];
        $q = "SELECT * FROM all_shared_notes where note_id='$note_id'";
        $res = mysqli_query($link,$q);
        $arr = mysqli_fetch_array($res,MYSQLI_ASSOC);
        $likes_num =$arr['likes']+1;
        $email = $arr['email'];

        $q = "UPDATE all_shared_notes SET likes='$likes_num' WHERE note_id='$note_id'";
        $res = mysqli_query($link,$q);

        $tblname = substr($email,0,strpos($email,"@"));
        $q = "UPDATE $tblname SET likes='$likes_num' WHERE note_id='$note_id'";
        $res2 = mysqli_query($link,$q);

        if($res&&$res2)
        {
            $_POST["reset"]="reset";

        }
    }

    if($_POST["dislike_it"]){
        $note_id = $_POST["dislike_it"];
        $q = "SELECT * FROM all_shared_notes where note_id='$note_id'";
        $res = mysqli_query($link,$q);
        $arr = mysqli_fetch_array($res,MYSQLI_ASSOC);
        $likes_num =$arr['dislikes']+1;
        $email = $arr['email'];

        $q = "UPDATE all_shared_notes SET dislikes='$likes_num' WHERE note_id='$note_id'";
        $res = mysqli_query($link,$q);

        $tblname = substr($email,0,strpos($email,"@"));
        $q = "UPDATE $tblname SET dislikes='$likes_num' WHERE note_id='$note_id'";
        $res2 = mysqli_query($link,$q);

        if($res&&$res2)
        {
            $_POST["reset"]="reset";
        }
    }
?>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
<script>

    function changed_sort() {
        var sort_val = document.getElementById('sort').value;

        switch (sort_val){
            case "likes" : window.location.href = './all_notes_shared.php?sort=likes'; break;
            case "date" : window.location.href = './all_notes_shared.php?sort=date'; break;
            case "views" : window.location.href = './all_notes_shared.php?sort=views'; break;
        }

    }

</script>
</body>
</html>


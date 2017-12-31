<?php
    session_start();
    if(!$_SESSION["username"]){
        echo "
        <script>
        alert(\"You need to login first\");
        window.location.href = '../sign_in.html';
        </script>
        ";
    }
    else{
        session_destroy();
        echo "
        <script>        
        window.location.href = '../sign_in.html';
        </script>
        ";
    }
?>
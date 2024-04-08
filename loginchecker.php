<?php
    //checks if user is logged in...
    session_start();
    if ((!isset($_SESSION["username"])) || (!isset($_SESSION["password"]))) {
        $_SESSION["loginError"] = true;
        header("Location: index.php");
        exit;
    }

    echo '<span id="document_target" style="display: none;">'.$_SESSION["username"].'</span>'

?>
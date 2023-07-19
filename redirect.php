<?php 
    session_start();

    if(!$_SESSION['Name']){
        header('location: landingPage.php');
    }
?>
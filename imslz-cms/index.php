<?php
    require('session.php');
    if(empty($_SESSION)){
        header('Location: ../index.php');
    } else{
        header('Location: cms.php');
    }
?>
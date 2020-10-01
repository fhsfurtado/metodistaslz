<?php
    session_start();
    session_unset($_SESSION);
    session_destroy();
    unset($_SESSION['user']);
    unset($_SESSION['nivel']);
    $_SESSION = array();
    $_SESSION['user'] = NULL;
    $_SESSION['nivel'] = NULL;
    header('Location: ../index.php');
?>
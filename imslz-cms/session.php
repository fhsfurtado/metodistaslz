    <?php
    session_start();
    if($_SESSION == '' || $_SESSION == NULL){
        header('Location: ../index.php');
        die();
    } else{
        $user = $_SESSION['user'];
        $level = $_SESSION['nivel'];
    }
    ?>
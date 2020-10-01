<?php
    $idUser=NULL;
    if(isset($_GET['gd'])){
        $idUser = $_GET['gd'];
        require_once('../connect.php');
        $stmt = $bd->prepare('DELETE FROM tb_agenda_covid WHERE id_agenda = :idUser');
        $stmt->bindParam(':idUser',$idUser);
        $stmt->execute();
        $msgExit = "Removido com sucesso";
        $confirmar = 'onclick="return confirm('.$msgExit.');"';
        header('Location: ../cms.php');
    }
?>
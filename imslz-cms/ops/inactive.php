<?php
    $idUser=NULL;
    if(isset($_GET['gd'])){
        $idUser = $_GET['gd'];
        require_once('../../connect.php');
        $stmt = $bd->prepare('UPDATE tb_membros SET ativo=0 WHERE id_membro = :idUser');
        $stmt->bindParam(':idUser',$idUser);
        $stmt->execute();
        $msgExit = "Cadastro Inativado com sucesso";
        $confirmar = 'onclick="return confirm('.$msgExit.');"';
        header('Location: ../cms.php?act=inactive_member');
    }
?>
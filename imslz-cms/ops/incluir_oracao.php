<?php
    require_once('../../connect.php');
    date_default_timezone_set('America/Fortaleza');
    $alert=NULL;

    if(isset($_POST)){
        $nome=$_POST['inputNome'];
        $oracao=$_POST['textOracao'];
        $culto=$_POST['dataCultoOracao'];
        $data=date('Y-m-d');

        $stmt = $bd->prepare('INSERT INTO tb_pray(nome,pray,data_pray,date_culto_oracao) VALUES (:nome,:oracao,:data_pray,:data_culto)');
        $stmt->bindParam(':nome',$nome);
        $stmt->bindParam(':oracao',$oracao);
        $stmt->bindParam(':data_pray',$data);
        $stmt->bindParam(':data_culto',$culto);
        $stmt->execute();
        if(isset($_SESSION)){
            header('Location: ../cms.php?act=member');
        } else{
            header('Location: oraremos.php');
        }
        
    } else{
        header('Location: falha.php');
    }    
?>
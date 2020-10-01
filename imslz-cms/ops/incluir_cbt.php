<?php
    //echo var_dump($_POST);
    require_once('../../connect.php');
    if(isset($_POST)){
        $nomeCompleto = $_POST['inputNomeCBT'];
        $nascimento = $_POST['inputDataNascCBT'];
        $sexo = $_POST['radioGenderCBT'];
        $denominacao = $_POST['inputNomeIgrejaCBT'];
        $endereco = $_POST['inputEnderecoComplCBT'];
        $bairro = $_POST['selectBairro'];
        $telFixo = $_POST['inputFixoCBT'];
        $telCelular = $_POST['inputCelularCBT'];
        $isWhats = $_POST['radioWhatsCBT'];
        $dataInscricao=date('Y-m-d H:i:s');

        $stmt = $bd->prepare('INSERT INTO tb_cbt(nome,data_nasc,sexo,denominacao,endereco,bairro,fixo,celular,iswhats,data_inscricao) VALUES (:nome,:data_nasc,:sexo,:denominacao,:endereco,:bairro,:fixo,:celular,:iswhats,:data_inscricao)');
        $stmt->bindParam(':nome',$nomeCompleto);
        $stmt->bindParam(':data_nasc',$nascimento);
        $stmt->bindParam(':sexo',$sexo);
        $stmt->bindParam(':denominacao',$denominacao);
        $stmt->bindParam(':endereco',$endereco);
        $stmt->bindParam(':bairro',$bairro);
        $stmt->bindParam(':fixo',$telFixo);
        $stmt->bindParam(':celular',$telCelular);
        $stmt->bindParam(':iswhats',$isWhats);
        $stmt->bindParam(':data_inscricao',$dataInscricao);
        $stmt->execute();
        header('Location: inscritoCBT.php');
    } else{
        header('Location: falha.php');
    }
?>
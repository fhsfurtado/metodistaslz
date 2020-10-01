<?php
    function soNumero($str) {
        return preg_replace("/[^0-9]/", "", $str);
    }
    require_once('../../connect.php');
    $alert=NULL;

    if(isset($_POST)){
        $nome=$_POST['inputNome'];
        $dataConv=$_POST['inputDataConversao'];
        $dataNasc=$_POST['inputDataNasc'];
        $dataCadastro=date('Y-m-d');
        $genero=$_POST['radioGender'];
        $endereco=$_POST['inputEndereco'];
        $bairro=$_POST['selectBairro'];
        $fixo=$_POST['inputFixo'];
        $celular=$_POST['inputCelular'];
        $isWhats=$_POST['radioWhats'];
        $ativo = true;

        $stmt = $bd->prepare('INSERT INTO tb_membros(nome_membro,sexo,endereco,bairro,telefone,celular,isWhatsapp,data_nascimento,data_cadastro,data_conversao,ativo) VALUES (:nome_membro,:sexo,:endereco,:bairro,:telefone,:celular,:isWhatsapp,:data_nascimento,:data_cadastro,:data_conversao,:ativo)');
        $stmt->bindParam(':nome_membro',$nome);
        $stmt->bindParam(':data_conversao',$dataConv);
        $stmt->bindParam(':data_nascimento',$dataNasc);
        $stmt->bindParam(':data_cadastro',$dataCadastro);
        $stmt->bindParam(':sexo',$genero);
        $stmt->bindParam(':endereco',$endereco);
        $stmt->bindParam(':bairro',$bairro);
        $stmt->bindParam(':telefone',$fixo);
        $stmt->bindParam(':celular',$celular);
        $stmt->bindParam(':isWhatsapp',$isWhats);
        $stmt->bindParam(':ativo',$ativo);
        $stmt->execute();
        header('Location: ../cms.php?act=member');
    } else{
        header('Location: falha.php');
    }    
?>
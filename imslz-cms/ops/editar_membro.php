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
        $id=$_POST['idMembro'];
        $ativo = true;

        $stmt = $bd->prepare('UPDATE tb_membros SET nome_membro = :nome_membro, sexo = :sexo, endereco = :endereco, bairro = :bairro, telefone = :telefone, celular = :celular, isWhatsapp = :isWhatsapp, data_nascimento = :data_nascimento, data_cadastro = :data_cadastro, data_conversao = :data_conversao WHERE id_membro = :id');
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
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        header('Location: ../cms.php?act=edit_member');
    } else{
        header('Location: falha.php');
    }    
?>
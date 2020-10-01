<?php
    function soNumero($str) {
        return preg_replace("/[^0-9]/", "", $str);
    }
    require_once('../../connect.php');
    $alert=NULL;

    if(isset($_POST)){
        $data=$_POST['dataCulto'];
        $nome=$_POST['inputNome'];
        $idade=$_POST['inputIdade'];
        $celular= soNumero($_POST['inputCelular']);
        $whats=$_POST['radioWhats'];
        $membro=$_POST['radioMember'];
        if(($idade<18)||($idade>60)){
            header('Location: falha.php');
            die();
        }

        $stmt = $bd->prepare('INSERT INTO tb_agenda_covid(data_culto,nome_completo,idade,celular,isWhatsapp,isMember) VALUES (:dataCulto,:nome,:idade,:celular,:isWhatsapp,:isMember)');
        $stmt->bindParam(':dataCulto',$data);
        $stmt->bindParam(':nome',$nome);
        $stmt->bindParam(':idade',$idade);
        $stmt->bindParam(':celular',$celular);
        $stmt->bindParam(':isWhatsapp',$whats);
        $stmt->bindParam(':isMember',$membro);
        $stmt->execute();
        header('Location: sucesso.php');
    } else{
        header('Location: falha.php');
    }    
?>
<?php
    require_once('../../connect.php');
    date_default_timezone_set('America/Fortaleza');
    //tratando foto
    if(isset($_POST)){
        $id = $_POST['idNoticia'];
        $titulo=$_POST['inputTitulo'];
        $noticia=$_POST['textNoticia'];
        if($_FILES['inputFoto']['name']!='' || $_FILES['inputFoto']['type']!= '' ){
            $extensao = strtolower(substr($_FILES['inputFoto']['name'],-4)); //Pegando extensão do arquivo
            $new_name = date("Y-m-d--H-i-s") . $extensao; //Definindo um novo nome para o arquivo
            $dir = '../../img/informativos/'; //Diretório para uploads
            $foto = 'img/informativos/'.$new_name;
            move_uploaded_file($_FILES['inputFoto']['tmp_name'], $dir.$new_name); //Fazer upload do arquivo
            $stmt = $bd->prepare('UPDATE tb_noticias SET titulo = :titulo, corpo = :corpo, foto = :foto WHERE id_noticia = :id');
            $stmt->bindParam(':titulo',$titulo);
            $stmt->bindParam(':corpo',$noticia);
            $stmt->bindParam(':foto',$foto);
            $stmt->bindParam(':id',$id);
            $stmt->execute();
            header('Location: ../cms.php?act=edit_news');
        }else{
            $stmt = $bd->prepare('UPDATE tb_noticias SET titulo = :titulo, corpo = :corpo WHERE id_noticia = :id');
            $stmt->bindParam(':titulo',$titulo);
            $stmt->bindParam(':corpo',$noticia);
            $stmt->bindParam(':id',$id);
            $stmt->execute();
            header('Location: ../cms.php?act=edit_news');
        }
    }else{
        header('Location: falha.php');
    }
?>
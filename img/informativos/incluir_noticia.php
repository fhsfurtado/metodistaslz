<?php
    require_once('../../connect.php');
    date_default_timezone_set('America/Fortaleza');
    //tratando foto
    if(isset($_POST)){
        $titulo=$_POST['inputTitulo'];
        $noticia=$_POST['textNoticia'];
        $extensao = strtolower(substr($_FILES['inputFoto']['name'],-4)); //Pegando extensão do arquivo
        $new_name = date("Y-m-d--H-i-s") . $extensao; //Definindo um novo nome para o arquivo
        $dir = '../../img/informativos/'; //Diretório para uploads
        $foto = 'img/informativos/'.$new_name;
        move_uploaded_file($_FILES['inputFoto']['tmp_name'], $dir.$new_name); //Fazer upload do arquivo
        
        $stmt = $bd->prepare('INSERT INTO tb_noticias(data_noticia,titulo,corpo,foto) VALUES (NOW(),:titulo,:corpo,:foto)');
        $stmt->bindParam(':titulo',$titulo);
        $stmt->bindParam(':corpo',$noticia);
        $stmt->bindParam(':foto',$foto);
        $stmt->execute();
        header('Location: ../cms.php?act=news');
    }else{
        header('Location: falha.php');
    }
?>
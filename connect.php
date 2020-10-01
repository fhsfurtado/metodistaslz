<?php
    date_default_timezone_set('America/Fortaleza');
    try{
        $bd = new PDO('mysql:host=m3t0d1st4slz.mysql.dbaas.com.br;dbname=m3t0d1st4slz;charset=utf8', "m3t0d1st4slz", "M3t0d1st4@!#");
        $bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
    catch (PDOException $e) {
        echo 'ERRO: ', $e->getMessage();
    }
?>

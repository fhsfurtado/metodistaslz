
<?php
$msgGet = NULL;
if(isset($_GET['act'])){
    $action = @$_GET['act'];
    if($action=='member'){
        $msgGet = '<div class="alert alert-success" role="alert"> Novo membro adicionado com sucesso! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
    }
    if($action=='edit_member'){
        $msgGet = '<div class="alert alert-warning" role="alert"> Membro editado com sucesso! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
    }
    if($action=='news'){
        $msgGet = '<div class="alert alert-success" role="alert"> Nova notícia adicionada com sucesso! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
    }
    if($action=='edit_news'){
        $msgGet = '<div class="alert alert-warning" role="alert"> Notícia editada com sucesso! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
    }
    if($action=='erase_news'){
        $msgGet = '<div class="alert alert-danger" role="alert"> Notícia excluída com sucesso! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
    }
    if($action=='pray'){
        $msgGet = '<div class="alert alert-success" role="alert"> Pedido de oração adicionado com sucesso! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
    }
    if($action=='inactive_member'){
        $msgGet = '<div class="alert alert-warning" role="alert"> Membro inativado com sucesso! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
    }
}

require('session.php');
require('isMobile.php');
$msgExit = "'Tem certeza que deseja sair?'";
$confirmar = 'onclick="return confirm('.$msgExit.');"';

?>
<!DOCTYPE html>
<html>
<head>
    <title>Gerenciador de Conteudo - Metodista SLZ</title>
    <meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />    
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Fabio Henrique Silva furtado" content="">

    <link rel="shortcut icon" href="../img/shortcut.png" type="image/x-icon" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">

    <!-- Bootstrap core CSS-->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap core CSS-->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Page level plugin CSS-->
    <link rel="stylesheet" type="text/css" href="../vendor/DataTables/datatables.min.css"/>
 
    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Editor de Texto-->
    <script src="https://cdn.ckeditor.com/ckeditor5/22.0.0/classic/ckeditor.js"></script>

    <!-- Script de Loading da página -->
    <script type="text/javascript">
    /* Máscaras ER */
  function mascara(o,f){
      v_obj=o
      v_fun=f
      setTimeout("execmascara()",1)
  }
  function execmascara(){
      v_obj.value=v_fun(v_obj.value)
  }
  function mtel(v){
      v=v.replace(/\D/g,"");             //Remove tudo o que não é dígito
      v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
      v=v.replace(/(\d)(\d{4})$/,"$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
      return v;
  }
  function id( el ){
    return document.getElementById( el );
  }
    </script>
    <style type="text/css">
        body{
            background: #ddd9ce;
        }
        nav{
            background-color: black;
            height: 80px;
        }
        #sidebar{
            background: #ADADAD;
        }
        #content{
            text-align: center;
        }
        #pesquisa{
            position: fixed;
            right: 0%;
        }
        .footer{
            position:fixed;
            bottom:0;
            width:100%;
            background-color: black;
        }
        hr{
            border-color:#aaa;
            box-sizing:border-box;
            width:100%;  
        }
        .loading{
    	position: absolute;
	    left: 25%;
	    top: 25%;
	    width: 50%;
	    height: 50%;
	    z-index: 9999;
	    }
        .details-text{
            left: 20%;
            right: 20%
        }    
     </style> 
</head>
<body>
    <div id="sidebar">
        <nav class="navbar navbar-expand static-top" role="navigation">
            <a class="navbar-brand" href="cms.php"><img src="../img/logo.png" width="150" class="d-inline-block align-top" alt="MetodistaSLZ"></a>
            <div class="btn-group btn-group-sm" role="group" aria-label="Menu IMSLZ-CMS">
                <div class="btn-group btn-group-sm" role="group">
                    <button id="btnGroupGerenciar" type="button" class="btn btn-outline-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Gerenciar</button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                    <a class="dropdown-item" onclick="main_carregar('manager/membresia.php');" href="#">Membresia</a>
                    <a class="dropdown-item" onclick="main_carregar('manager/noticias.php');" href="#">Notícias</a>
                    </div>
                </div>
                <div class="btn-group btn-group-sm" role="group">
                    <button id="btnGroupGerenciar" type="button" class="btn btn-outline-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Listas</button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                    <a class="dropdown-item" onclick="main_carregar('manager/oracao.php');" href="#">Oração</a>
                    <a class="dropdown-item" onclick="main_carregar('manager/lista-covid.php');" href="#">Agenda Culto</a>
                    <a class="dropdown-item" onclick="main_carregar('manager/ctb.php');" href="#">Lista CTB</a>
                    </div>
                </div>
                <a class="btn btn-outline-light" href="signout.php" <?php echo $confirmar?>>Sair</a>
            </div> 
        </nav>
        <?php
            if ($isMobile==false){
                echo '<div id="timer" class="container" align="center" ><span class="badge badge-pill badge-warning" id="data-hora"></span></div>';
            }
        ?>
    </div>
    <div class="container-fluid" id="content">
            <?php echo $msgGet;?>
    </div>
    <?php
        if ($isMobile==true){
            echo '<div id="timer" class="container" align="center" ><span class="badge badge-pill badge-warning" id="data-hora"></span></div>';
        }
    ?>
<div class="footer">
    <div class="container">
        <p class="m-0 text-center text-white small">2020 - Powered by <img src="../img/dragoncoder-white.png" width="200px" alt="Dragon Coder"> &copy;</p>
    </div>
</div>
</body>
<script type="text/javascript">
    function main_carregar(pagina){
        $("#content").load(pagina);
    }
    const zeroFill = n => {
				return ('0' + n).slice(-2);
			}
    // Cria intervalo
    const interval = setInterval(() => {
        // Pega o horário atual
        const now = new Date();

        // Formata a data conforme dd/mm/aaaa hh:ii:ss
        const dataHora = zeroFill(now.getUTCDate()) + '/' + zeroFill((now.getMonth() + 1)) + '/' + now.getFullYear() + ' ' + zeroFill(now.getHours()) + ':' + zeroFill(now.getMinutes()) + ':' + zeroFill(now.getSeconds());

        // Exibe na tela usando a div#data-hora
        document.getElementById('data-hora').innerHTML = dataHora;
    }, 1000);
</script>
<script src="../vendor/jquery/jquery.min.js"></script>
<script type="text/javascript" src="../vendor/DataTables/datatables.min.js"></script>
<script type="text/javascript" src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

</html>
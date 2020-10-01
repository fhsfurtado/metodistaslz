
<?php

header( "refresh:10;url=../../index.php" );

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

    <link rel="shortcut icon" href="img/shortcut.png" type="image/x-icon" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">

    <!-- Bootstrap core CSS-->
    <link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap core CSS-->
    <link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Page level plugin CSS-->
    <link rel="stylesheet" type="text/css" href="../vendor/DataTables/datatables.min.css"/>
 
    <!-- Custom Fonts -->
    <link href="../../vendor/font-awesome/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Script de Loading da página -->
    <script type="text/javascript">

    $(window).load(function() {
        document.getElementById("loading").style.display = "none";
        document.getElementById("sidebar").style.display = "inline";
        document.getElementById("content").style.display = "inline";
    });
    </script>
    <style type="text/css">
        body{
            background: white;
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
            <a class="navbar-brand" href="index.php"><img src="../../img/logo.png" width="150" class="d-inline-block align-top" alt="BabyBet"></a>
        </nav>
    </div>
    <div class="row justify-content-center" align="center" id="content">
    <div class="card col-lg-6">
          
          <div class="card-body">
            <h5 class="card-title"><i class="fas fa-check fa-lg"> Tudo certo!</i></h5>
            <p class="card-text"><h6>Seu pedido de oração foi adicionado com sucesso à lista!</h6></p>
            <p class="card-text"><h6>Que a Graça de Deus seja sobre nós, que derrame suas bênçãos e que, acima de tudo, o Seu Santo querer aconteça!</h6></p>
            <p class="card-text"><h6>Amém!</h6></p>
            <p class="card-footer"><a href="../../index.php" class="btn btn-outline-primary rounded-pill"> Voltar pro Site</a></p>
          </div>
        </div>
    </div>
<div class="footer">
    <div class="container">
        <p class="m-0 text-center text-white small">2020 - Powered by <img src="../../img/dragoncoder-white.png" width="200px" href="index.php" alt="Dragon Coder"> &copy;</p>
    </div>
</div>
</body>
<script type="text/javascript">
    function main_carregar(pagina){
        $("#content").load(pagina);
    }
</script>
<script type="text/javascript" src="../../vendor/DataTables/datatables.min.js"></script>
<script type="text/javascript" src="../../vendor/DataTables/dataTables.bootstrap4.min.js"></script>
</html>
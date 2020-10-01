<?php
    require_once('../connect.php');
    $erro = NULL;
    $msg = NULL;
    if(isset($_POST)){
        $user = @$_POST['inputLogin'];
        $psw = @md5($_POST['inputSenha']);
        $stmt = $bd->prepare('SELECT * FROM tb_user');
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        foreach($result as $res){
            if($user == $res->user && $psw == $res->passwd){
                if($res->active == 1){
                    $save = $bd->prepare('INSERT INTO tb_login (login) VALUES (:logged)');
                    $save->bindParam(':logged',$user);
                    $save->execute();
                    session_start();
                    $_SESSION['user'] = $res->user;
                    $_SESSION['nivel'] = $res->nivel_user;
                    header('Location: cms.php');
                    exit();
                } else{
                    $erro = 'desabilitado';
                }
            } else{
                $erro = 'inexistente';
            }
        }
    }

    switch($erro){
        case "desabilitado":
            $msg = '<div class="alert alert-danger" role="alert">Usuário desabilitado. Favor entrar em contato com o administrador do sistema.</div>';
            break;
        case "inexistente":
            $msg = '<div class="alert alert-warning" role="alert">Usuário e/ou senha estão incorretos. Por favor verifique seus dados.</div>';
            break;
        default:
            $msg = NULL;
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title> Login - Igreja Metodista em São Luís </title>
    <meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />    
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Fabio Henrique Silva furtado" content="">

    <link rel="shortcut icon" href="../img/shortcut.png" type="image/x-icon" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Bootstrap core CSS-->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Page level plugin CSS-->
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link href="../vendor/font-awesome/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../vendor/font-awesome/css/fontawesome.min.css" rel="stylesheet" type="text/css">

    <script type="text/javascript">

    $(window).load(function() {
        document.getElementById("loading").style.display = "none";
        document.getElementById("login").style.display = "inline";
    });
    </script>
    <style type="text/css">
        body{
            background: white;
        }
        nav{
            background-color: black;
        }
        #footer{
            bottom: 0%;
            position: fixed;
            width: 100%;
        }
        .loading{
            position: absolute;
            left: 25%;
            top: 25%;
            width: 50%;
            height: 50%;
            z-index: 9999;
	    }
        #login{
            display: flex;
            align-items: center;
            justify-content: center;
        }
        #foo{
            background-color: #ee7600;
            color: black;
        }
     </style> 
</head>
<body>
<div id="loading" style="display: block" class="loading" align="center">
	<img src="img/preloader.gif"><br>
	Carregando...
</div>
</br></br>
<div id="login" class="container d-flex p-auto">
    <div class="row" align="center">
        <div class="card">
            <div class="card-header">
            <a class="navbar-brand mr-1" href="index.php"><img src="../img/newlogo.fw.png" width="250" alt="MetodistaSLZ"></a>
            </div>
            <div class="card-body">
                <h5 class="card-title">Login</h5>
                <form action="login.php" method="POST">
                    <p class="card-text">
                        <div class="form-group">
                            <input type="text" class="form-control" id="inputLogin" name="inputLogin" placeholder="Login" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="inputSenha" name="inputSenha" placeholder="Senha" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Entrar</button>
                        <?php echo $msg;?>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="footer" class="row" align="center">
    <div class="col">
        <span id="foo" class="badge badge-pill">2020 ~ Powered by: DragonCoder &copy;</span>
    </div>
</div>
</body>
</html>
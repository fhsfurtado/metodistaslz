<?php
  header('Content-Type: text/html; charset=utf-8');
// CALCULO DO PRÓXIMO DOMINGO - PARA AGENDAMENTO DO CULTO PRESENCIAL
  $hoje = date('Y-m-d');
  $quarta = date('Y-m-d');
  $diaoracao = NULL;
  $dia = NULL;
  $i = 0;
  $j = 0;
  for($i=1;$i<=3;$i++){
      $diasemana_numero = date('w', strtotime($hoje));
      if($diasemana_numero==0){
          $dia =  date('d/m/Y',strtotime($hoje));
          $i = 5;
          break;
      } else{
          $i--;
      }
      $j++;
      $hoje = date('Y-m-d', strtotime('+'.$j.' days'));
  }
  $j=0;
  for($i=1;$i<=3;$i++){
    $diasemana_numero = date('w', strtotime($quarta));
    if($diasemana_numero==3){
        $diaoracao =  date('d/m/Y',strtotime($quarta));
        $i = 5;
        break;
    } else{
        $i--;
    }
    $j++;
    $quarta = date('Y-m-d', strtotime('+'.$j.' days'));
}
  // carregar as noticias
  require_once('connect.php');
  $stmt = $bd->prepare('SELECT * FROM tb_noticias ORDER BY data_noticia DESC LIMIT 5');
  $stmt->execute();
  $noticias = $stmt->fetchAll(PDO::FETCH_OBJ);

  // carregar a quantidade de pessoas que já tem pro culto
  $modalAgenda = NULL;
  $stmt = $bd->prepare('SELECT * FROM tb_agenda_covid WHERE data_culto=:culto');
  $stmt->bindParam(':culto',$hoje);
  $stmt->execute();
  $inscritos = $stmt->rowCount();
  if($inscritos>=20){
    $modalAgenda = '#modalCheio';
  } else{
    $modalAgenda = '#modalAgendamento';
  }

  //limitar os caracteres
  function limita_caracteres($texto, $limite, $quebra = true){
    $tamanho = strlen($texto);
    if($tamanho <= $limite){ //Verifica se o tamanho do texto é menor ou igual ao limite
       $novo_texto = $texto;
    }else{ // Se o tamanho do texto for maior que o limite
       if($quebra == true){ // Verifica a opção de quebrar o texto
          $novo_texto = trim(substr($texto, 0, $limite))."...";
       }else{ // Se não, corta $texto na última palavra antes do limite
          $ultimo_espaco = strrpos(substr($texto, 0, $limite), " "); // Localiza o útlimo espaço antes de $limite
          $novo_texto = trim(substr($texto, 0, $ultimo_espaco))."..."; // Corta o $texto até a posição localizada
       }
    }
    return $novo_texto; // Retorna o valor formatado
 }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>

  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="img/shortcut.png" type="image/x-icon" />

  <title>Igreja Metodista em São Luís</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Fonts do FontAwesome-->
  <link href="vendor/font-awesome/css/all.min.css" rel="stylesheet">
  <link href="vendor/font-awesome/css/fontawesome.min.css" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/one-page-wonder.min.css" rel="stylesheet">

  <!-- Page level plugin CSS-->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.css"/>

  <!-- Máscara JS para formatar celular-->
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
  window.onload = function(){
    id('inputCelular').onkeydown = function(){
      mascara( this, mtel );
    }
    id('inputCelularCBT').onkeydown = function(){
      mascara( this, mtel );
    }
    id('inputFixoCBT').onkeydown = function(){
      mascara( this, mtel );
    }
  }
  </script>
</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#"><img src="img/logo.png" width="200px" href="index.php" alt="Igreja Metodista em São Luís"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="#programacao"><i class="far fa-calendar-alt"> Programação</i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#news"><i class="far fa-newspaper"> Notícias</i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#about"><i class="fas fa-fingerprint"> Sobre Nós</i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="modal" data-target="<?php echo $modalAgenda?>" href="#"><i class="fas fa-calendar-check"> Agenda - Culto </i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="modal" data-target="#modalCBT" href="#"><i class="fas fa-user-edit"> Inscrição CBT </i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="modal" data-target="#modalLogin" href="#"><i class="fas fa-sign-in-alt"> Login</i></a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  </br></br></br></br>
  <header class="masthead text-center text-white" style="background-image: url('img/wallpaper.jpg');">
    <div class="masthead-content">
      <div class="container">
      <h2 class="masthead-subheading mr-0"><span class="badge badge-pill text-uppercase" style="background-color: rgb(87,87,87,.5)">Uma Igreja a serviço do Reino</span></h2>
        <a href="#about" class="btn btn-outline-light btn-xl rounded-pill mt-5"> Visite-nos!</a>
      </div>
    </div>
  </header>
  </br>
  <section id="programacao" name="programacao" align="center">
    <div class="container">
    </br></br></br></br>
      <h3 align="center">Nossa Programação</h3>
      <hr>
      <div class="row align-items-center">
        <!-- PROGRAMAÇÕES 4ª FEIRA-->
        <div class="card col-lg-3">
          <img class="card-img-top" src="img/programacao/oracao.jpg" width="75px" alt="Notícias">
          <div class="card-body">
            <h5 class="card-title"><span class="badge badge-pill badge-warning">4ª Feira</span><span class="badge badge-pill badge-primary">19:00</span></h5>
            <p class="card-text"><h6>Culto de Oração</h6></p>
            <p class="card-text">Um momento de comunhão com o Senhor, onde juntos buscamos ao Senhor e cuidamos de vidas por meio da oração.</p>
            <p class="card-footer">Devido a pandemia da COVID-19, este momento está ocorrendo somente online pelo nosso <a href="https://www.instagram.com/metodistaslz/">Instagram</a>.</p>
          </div>
        </div>
        <!-- PROGRAMAÇÕES SÁBADO-->
        <div class="card col-lg-3">
          <img class="card-img-top" src="img/programacao/youth.jpg" width="75px" alt="Notícias">
          <div class="card-body">
            <h5 class="card-title"><span class="badge badge-pill badge-warning">Sábado</span><span class="badge badge-pill badge-primary">19:00</span></h5>
            <p class="card-text"><h6>Culto de Jovens - Upper</h6></p>
            <p class="card-text">O Culto Upper é um momento de papo direto de jovem para jovem, falando abertamente sobre o que Deus tem para nós.</p>
            <p class="card-footer">Devido a pandemia da COVID-19, este momento está temporariamente suspenso em nossa agenda.</p>
          </div>
        </div>
        <!-- PROGRAMAÇÕES DOMINGO ED-->
        <div class="card col-lg-3">
          <img class="card-img-top" src="img/programacao/ed.jpg" width="75px" alt="Notícias">
          <div class="card-body">
            <h5 class="card-title"><span class="badge badge-pill badge-warning">Domingo</span><span class="badge badge-pill badge-primary">09:00</span></h5>
            <p class="card-text"><h6>Escola Dominical</h6></p>
            <p class="card-text">Um momento muito especial de aprendizado e partilha da Palavra de Deus, onde juntos crescemos e edificamos a Casa de Deus.</p>
            <p class="card-footer">Devido a pandemia da COVID-19, este momento está ocorrendo somente online pelo nosso <a href="https://www.instagram.com/metodistaslz/">Instagram</a>.</p>
          </div>
        </div>
        <!-- PROGRAMAÇÕES DOMINGO CULTO-->
        <div class="card col-lg-3">
          <img class="card-img-top" src="img/programacao/family.jpg" width="75px" alt="Notícias">
          <div class="card-body">
            <h5 class="card-title"><span class="badge badge-pill badge-warning">Domingo</span><span class="badge badge-pill badge-primary">18:30</span></h5>
            <p class="card-text"><h6>Culto da Família</h6></p>
            <p class="card-text">Nada melhor que iniciar a semana com chave de ouro, estando na Casa do Pai com amigos e aprendendo muito do Senhor.</p>
            <p class="card-footer">Devido a pandemia da COVID-19, para participar presencialmente desse evento é necessário <a data-toggle="modal" data-target="<?php echo $modalAgenda?>" href="#">agendar aqui</a>.</p>
          </div>
        </div>
      </div>
    </div>
    </br></br>
  </section>
  <section id="pedido-oracao" class="dark-bg" align="center" style="background-color: black;">
    <div class="container justify-content-center" align="center">
      </br></br>
      <h3 align="center" class="text-white">Pedidos de Oração</h3>
      <hr>
      <div class="row align-items-center">
        <div class="card col">
          <div class="card-body">
            <h5 class="card-title">Faça seu pedido de oração</h5>
            <p>Vamos orar por você!</p>
          </div>
          <div class="card-footer">
            <a class="btn btn-outline-primary" data-toggle="modal" data-target="#modalPray" href="#">Quero oração</a>
          </div>
        </div>
      </div>
    </div>
    </br></br>
  </section>
  </br>
  </br>
  <section id="news" name="news">
    <div class="container">
      </br></br></br></br>
      <h3 align="center">Notícias</h3>
      <hr>
      <div class="row align-content-center">
        <?php
        foreach($noticias as $news){
            echo '<div class="card col-lg" align="center">';
              echo '<img class="rounded mx-auto d-block" height="200px" src="'.$news->foto.'" alt="Notícia'.$news->id_noticia.'">';
              echo '<div class="card-body">';
                echo '<h5 class="card-title">'.$news->titulo.'</h5>';
                echo '<p class="card-text">'.limita_caracteres($news->corpo, 150).'</p>';
                echo '<a class="btn btn-outline-primary" data-toggle="modal" data-target="#modalNoticias'.$news->id_noticia.'" href="#"> Ver notícia completa </a>';
              echo '</div>';
            echo '</div>';
        }
        ?>
      </div>
    </div>
  </section>
  </br>
  </br>
  <section id="about" name="about">
    <div class="container" align="center">
    </br></br></br></br>
      <h3 align="center">Sobre Nós</h3>
      <hr>
      <div class="row">
        <div class="col-lg-6 card">
          </br><p>
            <h3>Igreja Metodista em São Luís</h3>
            <h5>Endereço: Rua 62, nº 4. Vinhais.</h5>
            <h5>Pastor: Rev. Luís Fernando "Fliper"</h5>
          </p>
            <h4>Nossas Redes Sociais</h4>
            <h6><a class="btn" style="background-color: #3b5999; color: white; width: 50%;" href="https://pt-br.facebook.com/MetodistaSLZ"><i class="fab fa-facebook"> MetodistaSLZ</i></a></h6>
            <h6><a class="btn" style="background-image: linear-gradient(to right, #fcaf2d , #ac1f90); color: white; width: 50%;" href="https://www.instagram.com/metodistaslz/"><i class="fab fa-instagram"></i> @metodistaslz</a></h6>
            <h6><a class="btn btn-danger" style="color: white; width: 50%;"  href="https://www.youtube.com/channel/UC62xRmFJAghRq-4dLVT2wFQ/"><i class="fab fa-youtube"></i> Igreja Metodista SLZ</a></h6>
            <h6><a class="btn" style="background-color: #25d366; color: white; width: 50%;"  href="https://api.whatsapp.com/send?phone=559891285429"><i class="fab fa-whatsapp"></i> Whatsapp Pastoral</a></h6>
          <p>

          </p>

        </div>
        <div class="col-lg-6 card">
          <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7971.9647798427395!2d-44.250740099038154!3d-2.5126455708870825!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x4e08595342b85499!2sIgreja%20Metodista%20em%20S%C3%A3o%20Lu%C3%ADs!5e0!3m2!1spt-BR!2sbr!4v1597972389758!5m2!1spt-BR!2sbr" width="100%" height="400" frameborder="0" style="border:0;" allowfullscreen="false" aria-hidden="false" tabindex="0"></iframe>
        </div>
      </div>
    </div>
  </section>
  </br>
  <!-- Footer -->
  <footer class="py-5 bg-black">
    <div class="container">
      <p class="m-0 text-center text-white small">2020 - Powered by <img src="img/dragoncoder-white.png" width="200px" href="index.php" alt="Dragon Coder"> &copy;</p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.js"></script>
  <!-- Modal Agendamento -->
  <div class="modal fade" id="modalAgendamento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel"> Agendamento de Culto Presencial </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <!-- INICIO DO FORM -->
                  <p><h6>Data do Próximo Culto:  <?php echo $dia;?></h6></p>
                  <form name="cadAgenda" method="POST" action="imslz-cms/ops/incluir_agenda.php">
                      <input type="text" class="form-control d-none" name="dataCulto" value="<?php echo $hoje;?>">
                      <div class="row">
                        <div class="col form-group">
                            <label for="nome">Nome Completo:</label>
                            <input type="text" class="form-control" name="inputNome" id="inputNome" aria-describedby="nome" placeholder="Seu nome completo" required>
                        </div>
                        <div class="col form-group">
                            <label for="nome">Idade:</label>
                            <input type="number" class="form-control" name="inputIdade" id="inputIdade" aria-describedby="nome" placeholder="Idade" min="18" max="60" required>
                            <small class="text-muted">Por segurança, só poderão se inscrever adultos entre 18 e 60 anos.</small>
                        </div>
                      </div>
                      <div class="row">
                      <div class="col form-group">
                          <label for="nome">Eu...</label></br>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="radioMember" id="radioMember1" value="1" checked>
                            <label class="form-check-label" for="exampleRadios1">
                              Sou membro.
                            </label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="radioMember" id="radioMember0" value="0">
                            <label class="form-check-label" for="exampleRadios2">
                              Sou visitante.
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col form-group">
                          <label for="nome">Celular:</label>
                          <input type="tel" class="form-control" name="inputCelular" id="inputCelular" aria-describedby="nome" placeholder="(XX)X XXXX-XXXX" maxlength="15" required>
                        </div>
                        <div class="col form-group">
                          <label for="nome">É Whatsapp?</label></br>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="radioWhats" id="radioWhats1" value="1" checked>
                            <label class="form-check-label" for="exampleRadios1">
                              Sim
                            </label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="radioWhats" id="radioWhats0" value="0">
                            <label class="form-check-label" for="exampleRadios2">
                              Não
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                          <button type="submit" class="btn btn-outline-primary">Agendar</button>
                      </div>
                  </form>
                  <!-- FIM DO FORM -->
              </div>
          </div>
      </div>
  </div>
    <!-- Fim Modal Agendamento-->
    <!-- Modal Inscrição CBT -->
  <div class="modal fade" id="modalCBT" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">
                    Informações:
                  </h5>
                  <h6>
                  </br> Período: 1 (um) ano.
                  </br> Investimento: R$50,00/ mês (cinquenta reais por mês).
                  </br> Para inscrever-se, digite abaixo seus dados:
                  </h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <!-- INICIO DO FORM -->
                  <form name="cadCBT" method="POST" action="imslz-cms/ops/incluir_cbt.php">
                      <h4>Sobre Você:</h4><hr>
                      <div class="row">
                        <div class="col form-group">
                            <label for="nome">Nome Completo:</label>
                            <input type="text" class="form-control" name="inputNomeCBT" id="inputNomeCBT" aria-describedby="nome" placeholder="Seu nome completo" required>
                        </div>
                        <div class="col form-group">
                            <label for="nome">Data de Nacimento:</label>
                            <input type="date" class="form-control" name="inputDataNascCBT" id="inputDataNascCBT" aria-describedby="nome" placeholder="Data de Nascimento" required>
                        </div>
                      </div>
                      <div class="row" align="center">
                        <div class="col form-group">
                            <label for="nome">Sexo</label></br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="radioGenderCBT" id="radioGender1" value="1" checked>
                                <label class="form-check-label" for="exampleRadios1">
                                    <img src="img/male-icon.png" width="20" height="20" class="d-inline-block align-top" alt="Masculino"> Masculino
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="radioGenderCBT" id="radioGender0" value="0">
                                <label class="form-check-label" for="exampleRadios2">
                                    <img src="img/female-icon.png" width="20" height="20" class="d-inline-block align-top" alt="Feminino"> Feminino
                                </label>
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col form-group">
                            <label for="nome">Denominação Congregacional:</label>
                            <input type="text" class="form-control" name="inputNomeIgrejaCBT" id="inputNomeIgrejaCBT" aria-describedby="nome" placeholder="Nome da sua Igreja" required>
                        </div>
                      </div>
                      <h4>Endereço:</h4><hr>
                      <div class="row">
                        <div class="col form-group">
                            <label for="nome">Endereço Completo:</label>
                            <input type="text" class="form-control" name="inputEnderecoComplCBT" id="inputEnderecoComplCBT" aria-describedby="nome" placeholder="Seu endereço completo" required>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col form-group">
                          <label for="nome">Bairro:</label>
                          <select name="selectBairro" id="selectBairro" required>
                              <option value="Alemanha">Alemanha</option>
                              <option value="Angelim">Angelim</option>
                              <option value="Anil">Anil</option>
                              <option value="Anjo da Guarda">Anjo da Guarda</option>
                              <option value="Aurora">Aurora</option>
                              <option value="Alto da Esperança">Alto da Esperança</option>
                              <option value="Alto do Calhau">Alto do Calhau</option>
                              <option value="Apeadouro">Apeadouro</option>
                              <option value="Apicum">Apicum</option>
                              <option value="Areinha">Areinha</option>
                              <option value="Bacanga">Bacanga</option>
                              <option value="Bairro de Fátima">Bairro de Fátima</option>
                              <option value="Barreto">Barreto</option>
                              <option value="Belira">Belira</option>
                              <option value="Bequimão">Bequimão</option>
                              <option value="Bom Jesus">Bom Jesus</option>
                              <option value="Bom Milagre">Bom Milagre</option>
                              <option value="Calhau">Calhau</option>
                              <option value="Camboa">Camboa</option>
                              <option value="Cantinho do Céu">Cantinho do Céu</option>
                              <option value="Caratatiua">Caratatiua</option>
                              <option value="Chácara Brasil">Chácara Brasil</option>
                              <option value="Cidade Olímpica">Cidade Olímpica</option>
                              <option value="Cidade Operária">Cidade Operária</option>
                              <option value="Codozinho">Codozinho</option>
                              <option value="Cohab Anil I">Cohab Anil I</option>
                              <option value="Cohab Anil II">Cohab Anil II</option>
                              <option value="Cohab Anil III">Cohab Anil III</option>
                              <option value="Cohab Anil IV">Cohab Anil IV</option>
                              <option value="Cohab Anil V">Cohab Anil V</option>
                              <option value="Cohafuma">Cohafuma</option>
                              <option value="Cohajap">Cohajap</option>
                              <option value="Cohatrac I">Cohatrac I</option>
                              <option value="Cohatrac II">Cohatrac II</option>
                              <option value="Cohatrac III">Cohatrac III</option>
                              <option value="Cohatrac IV">Cohatrac IV</option>
                              <option value="Cohatrac V">Cohatrac V</option>
                              <option value="Cohama">Cohama</option>
                              <option value="Cohapam">Cohapam</option>
                              <option value="Cohaserma">Cohaserma</option>
                              <option value="Coheb">Coheb</option>
                              <option value="Conjunto Alexandra Tavares">Conjunto Alexandra Tavares</option>
                              <option value="Conjunto Dom Sebastião">Conjunto Dom Sebastião</option>
                              <option value="Conjunto Primavera">Conjunto Primavera</option>
                              <option value="Conjunto Radional">Conjunto Radional</option>
                              <option value="Conjunto São Raimundo">Conjunto São Raimundo</option>
                              <option value="Coroado">Coroado</option>
                              <option value="Coroadinho">Coroadinho</option>
                              <option value="Coqueiro">Coqueiro</option>
                              <option value="Cruzeiro do Anil">Cruzeiro do Anil</option>
                              <option value="Cutim">Cutim</option>
                              <option value="Diamante">Diamante</option>
                              <option value="Distrito Industrial">Distrito Industrial</option>
                              <option value="Divineia">Divineia</option>
                              <option value="Estiva">Estiva</option>
                              <option value="Fabril">Fabril</option>
                              <option value="Fé em Deus">Fé em Deus</option>
                              <option value="Filipinho">Filipinho</option>
                              <option value="Forquilha">Forquilha</option>
                              <option value="Fumacê">Fumacê</option>
                              <option value="Gapara">Gapara</option>
                              <option value="Gancharia">Gancharia</option>
                              <option value="Goiabal">Goiabal</option>
                              <option value="Habitacional Turu">Habitacional Turu</option>
                              <option value="Igaraú">Igaraú</option>
                              <option value="Ilha da Paz">Ilha da Paz</option>
                              <option value="Ilhinha">Ilhinha</option>
                              <option value="Ipase">Ipase</option>
                              <option value="Ipem São Cristóvão">Ipem São Cristóvão</option>
                              <option value="Ipem Turu">Ipem Turu</option>
                              <option value="Itapiracó">Itapiracó</option>
                              <option value="Itaqui">Itaqui</option>
                              <option value="Ivar Saldanha">Ivar Saldanha</option>
                              <option value="Jambeiro">Jambeiro</option>
                              <option value="Jaracaty">Jaracaty</option>
                              <option value="Jardim América">Jardim América</option>
                              <option value="Jardim das Margaridas">Jardim das Margaridas</option>
                              <option value="Jardim de Allah">Jardim de Allah</option>
                              <option value="Jardim Atlântico">Jardim Atlântico</option>
                              <option value="Jardim de Fátima">Jardim de Fátima</option>
                              <option value="Jardim Eldorado">Jardim Eldorado</option>
                              <option value="Jardim Renascença">Jardim Renascença</option>
                              <option value="Jardim São Cristóvão I">Jardim São Cristóvão I</option>
                              <option value="Jardim São Cristóvão II">Jardim São Cristóvão II</option>
                              <option value="Jardim São Francisco">Jardim São Francisco</option>
                              <option value="Jardim São Raimundo">Jardim São Raimundo</option>
                              <option value="João de Deus">João de Deus</option>
                              <option value="João Paulo">João Paulo</option>
                              <option value="Jordoa">Jordoa</option>
                              <option value="Liberdade">Liberdade</option>
                              <option value="Lira">Lira</option>
                              <option value="Macaúba">Macaúba</option>
                              <option value="Madre Deus">Madre Deus</option>
                              <option value="Maioba">Maioba</option>
                              <option value="Maiobinha">Maiobinha</option>
                              <option value="Maiobão">Maiobão</option>
                              <option value="Maracanã">Maracanã</option>
                              <option value="Maranhão Novo">Maranhão Novo</option>
                              <option value="Monte Castelo">Monte Castelo</option>
                              <option value="Nova Betel">Nova Betel</option>
                              <option value="Novo Angelim">Novo Angelim</option>
                              <option value="Olho d'Água">Olho d'Água</option>
                              <option value="Outeiro da Cruz">Outeiro da Cruz</option>
                              <option value="Pão de Açúcar">Pão de Açúcar</option>
                              <option value="Parque Amazonas">Parque Amazonas</option>
                              <option value="Parque Atenas">Parque Atenas</option>
                              <option value="Parque Atlântico">Parque Atlântico</option>
                              <option value="Parque Aurora">Parque Aurora</option>
                              <option value="Parque dos Nobres">Parque dos Nobres</option>
                              <option value="Parque dos Sabiás">Parque dos Sabiás</option>
                              <option value="Parque Pindorama">Parque Pindorama</option>
                              <option value="Parque Shalom">Parque Shalom</option>
                              <option value="Parque Timbira">Parque Timbira</option>
                              <option value="Parque Universitário">Parque Universitário</option>
                              <option value="Pedrinhas">Pedrinhas</option>
                              <option value="Pirapora">Pirapora</option>
                              <option value="Piquizeiro">Piquizeiro</option>
                              <option value="Planalto Anil I">Planalto Anil I</option>
                              <option value="Planalto Anil II">Planalto Anil II</option>
                              <option value="Planalto Anil III">Planalto Anil III</option>
                              <option value="Planalto Anil IV">Planalto Anil IV</option>
                              <option value="Planalto Ipase">Planalto Ipase</option>
                              <option value="Planalto Pingão">Planalto Pingão</option>
                              <option value="Planalto Turu I">Planalto Turu I</option>
                              <option value="Planalto Turu II">Planalto Turu II</option>
                              <option value="Planalto Turu III">Planalto Turu III</option>
                              <option value="Planalto Vinhais">Planalto Vinhais</option>
                              <option value="Ponta d'Areia">Ponta d'Areia</option>
                              <option value="Ponta do Farol">Ponta do Farol</option>
                              <option value="Pontal da Ilha">Pontal da Ilha</option>
                              <option value="Porto Grande">Porto Grande</option>
                              <option value="Primavera do Bom Jesus">Primavera do Bom Jesus</option>
                              <option value="Quebra Pote">Quebra Pote</option>
                              <option value="Quintas do Calhau">Quintas do Calhau</option>
                              <option value="Quitandinha">Quitandinha</option>
                              <option value="Recanto dos Nobres">Recanto dos Nobres</option>
                              <option value="Recanto dos Pássaros">Recanto dos Pássaros</option>
                              <option value="Recanto dos Vinhais">Recanto dos Vinhais</option>
                              <option value="Recanto Canaã">Recanto Canaã</option>
                              <option value="Recanto Fialho">Recanto Fialho</option>
                              <option value="Recanto Verde">Recanto Verde</option>
                              <option value="Redenção">Redenção</option>
                              <option value="Renascença">Renascença</option>
                              <option value="Residencial 2000">Residencial 2000</option>
                              <option value="Residencial Ana Jansen">Residencial Ana Jansen</option>
                              <option value="Residencial Amendoeira">Residencial Amendoeira</option>
                              <option value="Residencial Batatã">Residencial Batatã</option>
                              <option value="Residencial Francisco Lima">Residencial Francisco Lima</option>
                              <option value="Residencial Ilha Bela">Residencial Ilha Bela</option>
                              <option value="Residencial Ivaldo Rodrigues">Residencial Ivaldo Rodrigues</option>
                              <option value="Residencial João do Vale">Residencial João do Vale</option>
                              <option value="Residencial José Reinaldo Tavares">Residencial José Reinaldo Tavares</option>
                              <option value="Residencial João Alberto">Residencial João Alberto</option>
                              <option value="Residencial Marcelo Dino">Residencial Marcelo Dino</option>
                              <option value="Residencial Nova Vida">Residencial Nova Vida</option>
                              <option value="Residencial Parque das Palmeiras">Residencial Parque das Palmeiras</option>
                              <option value="Residencial Olímpico">Residencial Olímpico</option>
                              <option value="Residencial Paraíso">Residencial Paraíso</option>
                              <option value="Residencial Primavera">Residencial Primavera</option>
                              <option value="Residencial Resende">Residencial Resende</option>
                              <option value="Residencial Ribeira">Residencial Ribeira</option>
                              <option value="Residencial Rio Anil">Residencial Rio Anil</option>
                              <option value="Residencial São Domingos">Residencial São Domingos</option>
                              <option value="Residencial Santo Antônio">Residencial Santo Antônio</option>
                              <option value="Retiro Natal">Retiro Natal</option>
                              <option value="Rio dos Cachorros">Rio dos Cachorros</option>
                              <option value="Rio Grande">Rio Grande</option>
                              <option value="Sá Viana">Sá Viana</option>
                              <option value="Sacavém">Sacavém</option>
                              <option value="Santa Bárbara">Santa Bárbara</option>
                              <option value="Santa Clara">Santa Clara</option>
                              <option value="Santa Cruz">Santa Cruz</option>
                              <option value="Santa Efigênia">Santa Efigênia</option>
                              <option value="Santa Helena">Santa Helena</option>
                              <option value="Santa Rosa">Santa Rosa</option>
                              <option value="Santana">Santana</option>
                              <option value="Santo Antônio">Santo Antônio</option>
                              <option value="São Bernardo">São Bernardo</option>
                              <option value="São Cristóvão">São Cristóvão</option>
                              <option value="São Francisco">São Francisco</option>
                              <option value="São Marcos">São Marcos</option>
                              <option value="São Raimundo">São Raimundo</option>
                              <option value="Sítio São Raimundo">Sítio São Raimundo</option>
                              <option value="Sol e Mar">Sol e Mar</option>
                              <option value="Solar dos Lusitanos">Solar dos Lusitanos</option>
                              <option value="Tajaçuaba">Tajaçuaba</option>
                              <option value="Tibiri">Tibiri</option>
                              <option value="Tirirical">Tirirical</option>
                              <option value="Turu">Turo</option>
                              <option value="Vera Cruz">Vera Cruz</option>
                              <option value="Vicente Fialho">Vicente Fialho</option>
                              <option value="Vila Alexandra Tavares">Vila Alexandra Tavares</option>
                              <option value="Vila Ayrton Senna">Vila Ayrton Senna</option>
                              <option value="Vila Ariri">Vila Ariri</option>
                              <option value="Vila Brasil">Vila Brasil</option>
                              <option value="Vila Cascavel">Vila Cascavel</option>
                              <option value="Vila Capim">Vila Capim</option>
                              <option value="Vila Collier">Vila Collier</option>
                              <option value="Vila Conceição">Vila Conceição</option>
                              <option value="Vila Cruzado">Vila Cruzado</option>
                              <option value="Vila Dom Luís">Vila Dom Luís</option>
                              <option value="Vila dos Frades">Vila dos Frades</option>
                              <option value="Vila Embratel">Vila Embratel</option>
                              <option value="Vila Esperança">Vila Esperança</option>
                              <option value="Vila Funil">Vila Funil</option>
                              <option value="Vila Geniparana">Vila Geniparana</option>
                              <option value="Vila Industrial">Vila Industrial</option>
                              <option value="Vila Isabel">Vila Isabel</option>
                              <option value="Vila Isabel Cafeteira">Vila Isabel Cafeteira</option>
                              <option value="Vila Itamar">Vila Itamar</option>
                              <option value="Vila Janaína">Vila Janaína</option>
                              <option value="Vila Luizão">Vila Luizão</option>
                              <option value="Vila Madureira">Vila Madureira</option>
                              <option value="Vila Maracujá">Vila Maracujá</option>
                              <option value="Vila Maranhão">Vila Maranhão</option>
                              <option value="Vila Mauro Fecury I">Vila Mauro Fecury I</option>
                              <option value="Vila Mauro Fecury II">Vila Mauro Fecury II</option>
                              <option value="Vila Nova">Vila Nova</option>
                              <option value="Vila Nova República">Vila Nova República</option>
                              <option value="Vila Palmeira">Vila Palmeira</option>
                              <option value="Vila Passos">Vila Passos</option>
                              <option value="Vila Riod">Vila Riod</option>
                              <option value="Vila Romário">Vila Romário</option>
                              <option value="Vila São Luís">Vila São Luís</option>
                              <option value="Vila Sarney">Vila Sarney</option>
                              <option value="Vila Samara">Vila Samara</option>
                              <option value="Vila Sete de Setembro">Vila Sete de Setembro</option>
                              <option value="Vila Vitória">Vila Vitória</option>
                              <option value="Village dos Jasmins">Village dos Jasmins</option>
                              <option value="Vinhais">Vinhais</option>
                              <option value="Vinhais Velho">Vinhais Velho</option>
                              <option value="Vivendas do Turu">Vivendas do Turu</option>
                          </select>
                        </div>
                      </div>
                      <h4>Contato</h4><hr>
                      <div class="row">
                          <div class="col-lg-3 form-group">
                              <label for="nome">Telefone Fixo:</label>
                              <input type="tel" class="form-control" name="inputFixoCBT" id="inputFixoCBT" aria-describedby="nome" placeholder="(XX)XXXX-XXXX" maxlength="15">
                          </div>
                          <div class="col-lg-3 form-group">
                              <label for="nome">Celular:</label>
                              <input type="tel" class="form-control" name="inputCelularCBT" id="inputCelularCBT" aria-describedby="nome" placeholder="(XX)X XXXX-XXXX" maxlength="15" required>
                          </div>
                          <div class="col-lg-3 form-group">
                              <label for="nome">É Whatsapp?</label></br>
                              <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="radioWhatsCBT" id="radioWhatsCBT1" value="1" checked>
                              <label class="form-check-label" for="exampleRadios1">
                                  Sim
                              </label>
                              </div>
                              <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="radioWhatsCBT" id="radioWhatsCBT0" value="0">
                              <label class="form-check-label" for="exampleRadios2">
                                  Não
                              </label>
                              </div>
                          </div>
                      </div>
                      <div class="modal-footer">
                          <button type="submit" class="btn btn-outline-primary">Inscrever-se</button>
                      </div>
                  </form>
                  <!-- FIM DO FORM -->
              </div>
          </div>
      </div>
  </div>
    <!-- Fim Modal Inscrição CBT-->
    <!-- Modal Notícia -->
  <?php
  foreach($noticias as $news){
  echo '<div class="modal fade justify-content-center" id="modalNoticias'.$news->id_noticia.'" tabindex="-1" role="dialog" aria-labelledby="modalNoticias'.$news->id_noticia.'" aria-hidden="true" align="center">';
    echo '<div class="modal-dialog modal-lg" role="document">';
      echo '<div class="modal-content">';
        echo '<div class="modal-header">';
          echo '<h5 class="modal-title" id="exampleModalLabel">('.@date("d/m/Y",strtotime($news->data_noticia)).'): '.$news->titulo.'</h5>';
          echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        echo '</div>';
        echo '<div class="modal-body">';
          echo '<p><img class="rounded mx-auto d-block" width="200px" src="'.$news->foto.'" alt="Notícia'.$news->id_noticia.'"></p>';
          echo '<p>'.$news->corpo.'</p>';
        echo '</div>';
      echo '</div>';
    echo '</div>';
  echo '</div>';
  }
  ?>
  <!-- Fim Modal Noticia-->
  <!-- Modal Culto Cheio-->
  <div class="modal fade justify-content-center" id="modalCheio" tabindex="-1" role="dialog" aria-labelledby="modalCheio" aria-hidden="true" align="center">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> Atingimos a nossa capacidade! </h5>
        </div>
        <div class="modal-body">
          <p>Infelizmente não poderemos ter você conosco no nosso próximo culto por já termo atingido a capacidade do nosso templo</p>
          <p>Fizemos essa limitação por conta das medidas de segurança recomendadas pelo Governo referentes à pandemia da COVID-19</p>
          <p>Mas, por favor, não deixe de nos acompanhar! Nosso culto será transmitido ao vivo pelo nosso Instagram, que podes ver <a href="#about">aqui</a>.</p>
        </div>
      </div>
    </div>
  </div>
  <!-- FIm Modal Culto Cheio-->
  <!-- Modal Login-->
  <div class="modal fade justify-content-center" id="modalLogin" tabindex="-1" role="dialog" aria-labelledby="modalCheio" aria-hidden="true" align="center">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> Login </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="imslz-cms/login.php" method="POST">
          <div class="col form-group">
              <label for="nome">Login</label>
              <input type="text" class="form-control" name="inputLogin" id="inputLogin" aria-describedby="Login" placeholder="Login" required>
          </div>
          <div class="col form-group">
              <label for="nome">Senha</label>
              <input type="password" class="form-control" name="inputSenha" id="inputSenha" aria-describedby="Senha" placeholder="Senha"required>
          </div>
          <div class="col form-group">
            <button type="submit" class="btn btn-outline-primary">Acessar o sistema</button>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- FIm Modal Login-->
  <!-- Modal Oração-->
  <div class="modal fade justify-content-center" id="modalPray" tabindex="-1" role="dialog" aria-labelledby="modalCheio" aria-hidden="true" align="center">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> Queremos orar por você! </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <blockquote class="blockquote"> “Orai uns pelos outros, para serem curados. Muito pode, por sua eficácia, a oração do justo"<footer class="blockquote-footer">(Tg 5.16)</footer></blockquote>
          <p>Uma das formas mais amorosas de cuidado com quem nos importamos se dá por meio da oração. Tiago nos orientou, assim como Paulo, quando fala sempre aos irmãos pedindo por oração em <abbr title="Irmãos, orai por nós" class="initialism"><strong>1 Ts 5.25</strong></abbr>.
          Queremos, por isso, orar por você! Colocaremos os seus pedidos de oração aos pés do Senhor!</p>
          <p><h6>Data do Próximo Culto de Oração:  <?php echo $diaoracao;?></h6></p>
          <form action="imslz-cms/ops/incluir_oracao.php" method="POST">
          <input type="text" class="form-control d-none" name="dataCultoOracao" value="<?php echo $quarta;?>">
          <div class="col form-group">
              <label for="nome">Nome:</label>
              <input type="text" class="form-control" name="inputNome" id="inputNome" aria-describedby="Nome" placeholder="Por quem iremos orar?" required>
          </div>
          <div class="col form-group">
              <label for="nome">Pedido de oração:</label>
              <textarea class="form-control" id="exampleFormControlTextarea1" name="textOracao" rows="4" required></textarea>
          </div>
          <div class="col form-group">
            <button type="submit" class="btn btn-outline-primary">Orar!</button>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- FIm Modal Oração-->
</body>
</html>

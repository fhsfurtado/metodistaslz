<?php
    // calcular o próximo dia de culto de oração
    $i = 0;
    $j = 0;
    $quarta = date('Y-m-d');
    $diaoracao = NULL;
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
    // consulta à tabela de oração, para carregar os pedidos de oração da semana
    require_once('../../connect.php');
    $stmt = $bd->prepare('SELECT * FROM tb_pray WHERE date_culto_oracao = :dataCultoOracao');
    $stmt->bindParam(':dataCultoOracao',$quarta);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
?>
<div class="col card mb-3">
    <div class="tab-pane fade show active" id="verOracao" role="tabpanel" aria-labelledby="verOracao">
        <!-- TAB VISUALIZAR ORAÇÕES-->
        <div class="card-header">
            <i class="fas fa-address-card fa-2x"> Pedidos de Oração </i>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTableMembers" width="100%" cellspacing="0">
                    <thead class="bg-danger text-light">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Pedido</th>
                            <th scope="col">Data do Pedido</th>
                            <th scope="col">Data do Culto</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $certeza = "'Tem certeza que deseja inativar este membro?'";
                        $confirm = 'onclick="return confirm('.$certeza.');"';
                        foreach( $result as $res){
                            $color = "";
                            echo '<tr>';
                            echo '<td>'. $res->id_pray .'</td>';
                            echo '<td>'. $res->nome .'</td>';
                            echo '<td>'. $res->pray .'</td>';
                            echo '<td>'. date('d/m/Y',strtotime($res->data_pray)).'</td>';
                            echo '<td>'. date('d/m/Y',strtotime($res->date_culto_oracao)).'</td>';
                            echo '</tr>';
                        } 
                    ?>
                    </tbody>
                </table>
            <div class="card-footer small text-muted">Atualizado em: <span><?php echo date("d/m/Y H:i:s"); ?></span> </div>
        </div>
    </div>
</div>
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
          <blockquote class="blockquote"> “Orai uns pelos outros, para serem curados. Muito pode, por sua eficácia, a oração do justo<footer class="blockquote-footer">(Tg 5.16)</footer></blockquote>.
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
<script>
    $('#myTab a').on('click', function (e) {
        e.preventDefault()
        $(this).tab('show')
    })
    $(document).ready(function() {
        $('#dataTableMembers').DataTable({
            "language": {
        "sProcessing":    "Processando...",
        "sLengthMenu":    "Mostrar _MENU_ registros",
        "sZeroRecords":   "Ops! Não há nenhum registro.",
        "sEmptyTable":    "Nenhum dado disponível.",
        "sInfo":          "Mostrando registros de _START_ a _END_ de um total de _TOTAL_ registros",
        "sInfoEmpty":     "Mostrando registros de 0 a 0 de um total de 0 registros",
        "sInfoFiltered":  "(filtrado de um total de _MAX_ registros)",
        "sInfoPostFix":   "",
        "sSearch":        "Buscar:",
        "sUrl":           "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Carregando...",
        "oPaginate": {
            "sFirst":    "Primeiro",
            "sLast":    "Último",
            "sNext":    "Seguinte",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending":  ": Ativar para ordenar a coluna de forma ascendente",
            "sSortDescending": ": Ativar para ordenar a coluna de forma descendente"
        }
    }
        });
    } );
</script>
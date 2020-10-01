<?php
// CALCULO DO PRÓXIMO DOMINGO - PARA AGENDAMENTO DO CULTO PRESENCIAL
$hoje = date('Y-m-d');
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
    require_once('../../connect.php');
    $stmt = $bd->prepare('SELECT * FROM tb_agenda_covid WHERE data_culto=:dia');
    $stmt->bindParam(':dia',$hoje);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    $cont = $stmt->rowCount();
?>

<div class="col card">
  <div class="card-header">
      <i class="fas fa-address-card fa-2x"> Lista de Agendamento - Culto Presencial </i>
  </div>
  <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered text-center"id="dataTableAgenda" width="100%" cellspacing="0">
            <thead class="bg-danger text-light">
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Data do Culto</th>
                <th scope="col">Nome Completo</th>
                <th scope="col">Idade</th>
                <th scope="col">Celular</th>
                <th scope="col">Whatsapp?</th>
                <th scope="col">É membro?</th>
                <th scope="col">Opções</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $certeza = "'Tem certeza que deseja remover esta pessoa da lista?'";
                $confirm = 'onclick="return confirm('.$certeza.');"';
                foreach( $result as $res){
                    echo '<tr>';
                    echo '<th scope="row">'. $res->id_agenda .'</th>';
                    echo '<td>'. @date('d/m/Y', strtotime($res->data_culto)) .'</td>';
                    echo '<td>'. $res->nome_completo .'</td>';
                    echo '<td>'. $res->idade .'</td>';
                    echo '<td>'. $res->celular .'</td>';
                    if($res->isWhatsapp == 1){
                        echo '<td><a class="btn" href="https://api.whatsapp.com/send?phone=55'.$res->celular.'" target="_blank"><img src="../img/whats-icon.png" value="isWhats" id="isWhats" width="20" height="20" class="d-inline-block align-top" alt="isWhats"><span class="d-none">sim</span></a></td>';
                    } else{
                        echo '<td><img src="../img/void-icon.png" value="notWhats" id="notWhats" width="20" height="20" class="d-inline-block align-top" alt="notWhats"><span class="d-none">não</span></td>';
                    };
                    if($res->isMember == 1){
                        echo '<td><img src="../img/check-icon.png" value="isMember" id="isMember" width="20" height="20" class="d-inline-block align-top" alt="isMember"><span class="d-none">sim</span></td>';
                    } else{
                        echo '<td><img src="../img/void-icon.png" value="notMember" id="notMember" width="20" height="20" class="d-inline-block align-top" alt="notMember"><span class="d-none">não</span></td>';
                    };
                    echo '<td><a style="color: red" href="remove_agenda.php?gd='.$res->id_agenda.'" '.$confirm.'><i class="fas fa-trash"></i></a></td>';
                    echo '</tr>';
                } 
            ?>
            </tbody>
        </table>
      </div>
    <div class="card-footer small text-muted">
      Atualizado em: <span><?php echo date("d/m/Y H:i:s"); ?></span>
    </div>
  </div>
</div>
<script>
    $(document).ready(function() {
    $('#dataTableAgenda').DataTable({
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
<!-- Modal Agendamento -->
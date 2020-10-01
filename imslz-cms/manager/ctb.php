<?php
    function soNumero($str) {
        return preg_replace("/[^0-9]/", "", $str);
    }
    $celular = NULL;
    require_once('../../connect.php');
    $stmt = $bd->prepare('SELECT * FROM tb_cbt');
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
?>

<div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-address-card fa-2x"> Inscritos no Curso Básico em Teologia</i>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-center"id="dataTableCTB" width="100%" cellspacing="0">
                    <thead class="bg-danger text-light">
                        <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nome Completo</th>
                        <th scope="col">Data Nasc.</th>
                        <th scope="col">Sexo</th>
                        <th scope="col">Endereço</th>
                        <th scope="col">Bairro</th>
                        <th scope="col">Igreja</th>
                        <th scope="col">Telefone</th>
                        <th scope="col">Celular</th>
                        <th scope="col">Whatsapp</th>
                        <th scope="col">Data Inscrição</th>
                        </tr>
                    <tbody>
                    <?php
                        foreach( $result as $res){
                            echo '<tr>';
                            echo '<th scope="row">'. $res->id_inscricao .'</th>';
                            echo '<td>'. $res->nome .'</td>';
                            echo '<td>'. date('d/m/Y',strtotime($res->dat_nasc)) .'</td>';
                            if($res->sexo == 1){
                                echo '<td><img src="../img/male-icon.png" value="male" id="male" width="30" height="30" class="d-inline-block align-top" alt="male"><span class="d-none">masculino</span></td>';
                            } else{
                                echo '<td><img src="../img/female-icon.png" value="female" id="female" width="30" height="30" class="d-inline-block align-top" alt="female"><span class="d-none">feminino</span></td>';
                            }
                            echo '<td>'. $res->endereco .'</td>';
                            echo '<td>'. $res->bairro .'</td>';
                            echo '<td>'. $res->denominacao .'</td>';
                            echo '<td>'. $res->fixo .'</td>';
                            echo '<td>'. $res->celular .'</td>';
                            $celular = soNumero($res->celular);
                            if($res->isWhatsapp == 1){
                                echo '<td><a href="https://api.whatsapp.com/send?phone=55'.$celular.'"><img src="../img/whats-icon.png" value="male" id="male" width="30" height="30" class="d-inline-block align-top" alt="male"></a><span class="d-none">sim</span></td>';
                            } else{
                                echo '<td><img src="../img/void-icon.png" value="female" id="female" width="30" height="30" class="d-inline-block align-top" alt="female"><span class="d-none">não</span></td>';
                            };
                            $celular = NULL;
                            echo '<td>'. @date('d/m/Y H:i:s', strtotime($res->data_inscricao)) .'</td>';
                            echo '</tr>';
                        } 
                    ?>
                    </tbody> <a href=""></a>
                </table>
              </div>
            </div>
        <div class="card-footer small text-muted">Atualizado em: <span><?php echo date("d/m/Y H:i:s"); ?></span> </div>
        </div>
    </div>
    <script>
    $(document).ready(function() {
    $('#dataTableCTB').DataTable({
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
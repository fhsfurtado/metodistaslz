<?php
    require_once('../../connect.php');
    $stmt = $bd->prepare('SELECT * FROM tb_membros');
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
?>
<div class="col card mb-3">
    <a class="btn btn-lg btn-danger" onclick="main_carregar('manager/addMembro.php');" href="#"><i class="fas fa-plus-square"> Adicionar Novo Membro</i></a>
    <div class="card-header">
        <i class="fas fa-address-card fa-2x"> Membresia</i>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTableMembers" width="100%" cellspacing="0">
                <thead class="bg-danger text-light">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Sexo</th>
                        <th scope="col">Endereço</th>
                        <th scope="col">Bairro</th>
                        <th scope="col">Telefone</th>
                        <th scope="col">Celular</th>
                        <th scope="col">Whatsapp</th>
                        <th scope="col">Dt.Nascimento</th>
                        <th scope="col">Dt.Conversão</th>
                        <th scope="col">Opções</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $certeza = "'Tem certeza que deseja inativar este membro?'";
                    $confirm = 'onclick="return confirm('.$certeza.');"';
                    foreach( $result as $res){
                        $color = "";
                        echo '<tr>';
                        if($res->ativo == 0){
                            $color = 'style="background-color: gray"';
                        }
                        echo '<th scope="row" '.$color.'>'. $res->id_membro .'</th>';
                        echo '<td>'. $res->nome_membro .'</td>';
                        if($res->sexo == 1){
                            echo '<td><img src="../img/male-icon.png" value="male" id="male" width="30" height="30" class="d-inline-block align-top" alt="male"><span class="d-none">masculino</span></td>';
                        } else{
                            echo '<td><img src="../img/female-icon.png" value="female" id="female" width="30" height="30" class="d-inline-block align-top" alt="female"><span class="d-none">feminino</span></td>';
                        }
                        echo '<td>'. $res->endereco .'</td>';
                        echo '<td>'. $res->bairro .'</td>';
                        echo '<td>'. $res->telefone .'</td>';
                        echo '<td>'. $res->celular .'</td>';
                        if($res->isWhatsapp == 1){
                            echo '<td><a class="btn" href="https://api.whatsapp.com/send?phone=55'.$res->celular.'" target="_blank"><img src="../img/whats-icon.png" value="male" id="male" width="30" height="30" class="d-inline-block align-top" alt="male"><span class="d-none">sim</span></a></td>';
                        } else{
                            echo '<td><img src="../img/void-icon.png" value="female" id="female" width="30" height="30" class="d-inline-block align-top" alt="female"><span class="d-none">não</span></td>';
                        };
                        echo '<td>'. @date('d/m/Y', strtotime($res->data_nascimento)) .'</td>';
                        echo '<td>'. @date('d/m/Y', strtotime($res->data_conversao)) .'</td>';
                        echo '<td>';
                        $editarMembro = "'manager/editarMembro.php?membro=".$res->id_membro."'";
                        echo '<a class="btn" style="color: blue" onclick="main_carregar('.$editarMembro.');" href="#"><i class="fas fa-edit"></i></a>';
                        echo '<a style="color: red" href="ops/inactive.php?gd='.$res->id_membro.'" '.$confirm.'><i class="fas fa-trash"></i></a>';
                        echo '</td>';
                        echo '</tr>';
                    } 
                ?>
                </tbody>
            </table>
        <div class="card-footer small text-muted">Atualizado em: <span><?php echo date("d/m/Y H:i:s"); ?></span> </div>
    </div>
</div>
<script>
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
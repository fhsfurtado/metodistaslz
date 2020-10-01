<?php
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
        require_once('../../connect.php');
    $stmt = $bd->prepare('SELECT * FROM tb_noticias');
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    if(isset($_GET['gd'])){
        $erase = $bd->prepare('DELETE FROM tb_noticias WHERE id_noticia = :id');
        $erase->bindParam(':id',$_GET['gd']);
        $erase->execute();
        header('Location: ../cms.php?act=erase_news');
        die();
    }
?>
<div class="col card mb-3">
    <a class="btn btn-lg btn-danger" onclick="main_carregar('manager/addNoticia.php');" href="#"><i class="fas fa-plus-square"> Incluir Notícia</i></a>
    <div class="card-header">
        <i class="fas fa-address-card fa-2x"> Noticias</i>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTableNews" width="100%" cellspacing="0">
                <thead class="bg-danger text-light">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Data</th>
                        <th scope="col">Título</th>
                        <th scope="col">Corpo</th>
                        <th scope="col">Foto</th>
                        <th scope="col">Opções</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $certeza = "'Tem certeza que deseja apagar essa notícia?'";
                    $confirm = 'onclick="return confirm('.$certeza.');"';
                    foreach( $result as $res){
                        echo '<tr>';
                        echo '<th scope="row">'. $res->id_noticia .'</th>';
                        echo '<td>'. date('d/m/Y', strtotime($res->data_noticia)) .'</td>';
                        echo '<td>'. limita_caracteres($res->titulo, 12) .'</td>';
                        echo '<td>'. limita_caracteres($res->corpo, 20) .'</td>';
                        echo '<td>'. $res->foto .'</td>';
                        echo '<td>';
                        $editarNoticia = "'manager/editarNoticia.php?noticia=".$res->id_noticia."'";
                        echo '<a class="btn" style="color: blue" onclick="main_carregar('.$editarNoticia.');" href="#"><i class="fas fa-edit"></i></a>';
                        echo '<a class="btn" style="color: red" href="manager/noticias.php?gd='.$res->id_noticia.'" '.$confirm.'><i class="fas fa-trash"></i></a>';
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
    $('#dataTableNews').DataTable({
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
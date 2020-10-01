<?php
    $idNoticia = $_GET['noticia'];
    require_once('../../connect.php');
    $stmt = $bd->prepare('SELECT * FROM tb_noticias WHERE id_noticia = :noticia');
    $stmt->bindParam(':noticia',$idNoticia);
    $stmt->execute();
    $result = $stmt->fetch();
?>
</br>
<div class="col card mb-6">
    <form name="cadAgenda" method="POST" action="../imslz-cms/ops/editar_noticia.php" enctype="multipart/form-data">
        <h4>Imagem da Notícia</h4><hr>
        <div class="row">
            <div class="col-lg-4 form-group">
                <label for="nome">Selecionar outra foto:</label></br>
                <input type="file" name="inputFoto" accept="image/png, image/jpeg"/> 
            </div>
            <div class="col-lg-6 form-group" align="center">
                <label for="nome">Foto Atual:<i class="fas fa-arrow-alt-square-left    "></i></label>
                <img src="../<?php echo $result['foto']?>" width="150px" alt="Foto Atual"> 
            </div>
        </div>
        <h4>Sobre a notícia</h4><hr>
        <div class="row">
            <div class="col form-group" align="center">
                <label for="nome">Título:</label>
                <input type="text" class="form-control" value="<?php echo $result['titulo']?>" name="inputTitulo" id="inputTitulo" aria-describedby="inputTitulo" placeholder="Título da notícia" required>
            </div>
        </div>
        <div class="row">
            <div class="col form-group">
                <label for="nome">Noticia:</label></br>
                <textarea name="textNoticia" id="textNoticia" cols="100%" rows="10" placeholder="Descrever notícia" required><?php echo $result['corpo']?></textarea>
            </div>
        </div>
        <input type="hidden" name="idNoticia" value="<?php echo $idNoticia?>">
        <div class="modal-footer">
            <button type="reset" class="btn btn-outline-secondary">Limpar</button>
            <button type="submit" class="btn btn-outline-primary">Editar Notícia</button>
        </div>
    </form>
</div></br></br>
<script>
    ClassicEditor
        .create( document.querySelector( '#textNoticia' ), {
            language: 'pt-br',
            toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable', 'undo', 'redo'],
        } )
        .catch( error => {
            console.error( error );
        } );
</script>
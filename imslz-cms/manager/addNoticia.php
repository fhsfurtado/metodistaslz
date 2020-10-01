</br>
<div class="col card mb-6">
    <form name="cadNews" method="POST" action="../imslz-cms/ops/incluir_noticia.php" enctype="multipart/form-data">
        <h4>Imagem da Notícia</h4><hr>
        <div class="row">
            <div class="col form-group">
                <label for="nome">Foto:</label></br>
                <input type="file" name="inputFoto" accept="image/*" required/> 
            </div>
        </div>
        <h4>Sobre a notícia</h4><hr>
        <div class="row">
            <div class="col form-group" align="center">
                <label for="nome">Título:</label>
                <input type="text" class="form-control" name="inputTitulo" id="inputTitulo" aria-describedby="inputTitulo" placeholder="Título da notícia" required>
            </div>
        </div>
        <div class="row">
            <div class="col form-group">
                <label for="nome">Noticia:</label></br>
                <textarea name="textNoticia" id="textNoticia" cols="100%" rows="10" placeholder="Descrever notícia"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="reset" class="btn btn-outline-secondary">Limpar</button>
            <button type="submit" id="submit" class="btn btn-outline-primary">Adicionar Notícia</button>
        </div>
    </form>
</div></br></br>

<script>
        ClassicEditor
        .create( document.querySelector( '#textNoticia' ),{
            language: 'pt-br',
            toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable', 'undo', 'redo'],
        } )
        .catch( error => {
            console.error( error );
        } );
</script>

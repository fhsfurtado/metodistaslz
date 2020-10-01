<?php
    $idMembro = $_GET['membro'];
    require_once('../../connect.php');
    $stmt = $bd->prepare('SELECT * FROM tb_membros WHERE id_membro = :membro');
    $stmt->bindParam(':membro',$idMembro);
    $stmt->execute();
    $result = $stmt->fetch();
?>
<script> 
  window.onkeypress = function(){
    id('inputFixo').onkeypress = function(){
      mascara( this, mtel );
    }
    id('inputCelular').onkeypress = function(){
      mascara( this, mtel );
    }
  }
</script>
</br>
<div class="col card mb-6">
    <form name="cadAgenda" method="POST" action="../imslz-cms/ops/editar_membro.php">
        <input type="hidden" name="idMembro" value="<?php echo $idMembro;?>">
        <h4>Dados Pessoais</h4><hr>
        <div class="row">
            <div class="col-lg-12 form-group" align="center">
                <label for="nome">Nome Completo:</label>
                <input type="text" class="form-control" value="<?php echo $result['nome_membro']?>" name="inputNome" id="inputNome" aria-describedby="nome" placeholder="Seu nome completo" required>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 form-group">
                <label for="nome">Data de Conversão:</label>
                <input type="date" class="form-control" value="<?php echo $result['data_conversao']?>" name="inputDataConversao" id="inputDataConversao" aria-describedby="nome" placeholder="Idade" min="1910-01-01" max="<?echo date('Y-m-d');?>" required>
            </div>
            <div class="col-lg-3 form-group">
                <label for="nome">Data de Nascimento:</label>
                <input type="date" class="form-control" value="<?php echo $result['data_nascimento']?>" name="inputDataNasc" id="inputDataNasc" aria-describedby="nome" placeholder="Idade" min="1910-01-01" max="<?echo date('Y-m-d');?>" required>
            </div>
            <div class="col-lg-6 form-group">
                <label for="nome">Sexo</label></br>
                <?php
                    $male=NULL;
                    $female=NULL;
                    if($result['sexo']==1){
                        $male='checked';
                    } else{
                        $female='checked';
                    }
                ?>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="radioGender" id="radioGender1" value="1" <?php echo $male;?>>
                    <label class="form-check-label" for="exampleRadios1">
                        <img src="../img/male-icon.png" width="20" height="20" class="d-inline-block align-top" alt="Masculino"> Masculino
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="radioGender" id="radioGender0" value="0" <?php echo $female;?>>
                    <label class="form-check-label" for="exampleRadios2">
                        <img src="../img/female-icon.png" width="20" height="20" class="d-inline-block align-top" alt="Feminino"> Feminino
                    </label>
                </div>
            </div>
        </div>
        <h4>Endereço</h4><hr>
        <div class="row">
            <div class="col-lg-8 form-group" align="center">
                <label for="nome">Endereço:</label>
                <input type="text" class="form-control" value="<?php echo $result['endereco']?>" name="inputEndereco" id="inputEndereco" aria-describedby="nome" placeholder="Rua, numero, bloco, apto..." required>
            </div>
            <div class="col-lg-3 form-group" align="center">
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
                <input type="tel" class="form-control" value="<?php echo $result['telefone']?>" name="inputFixo" id="inputFixo" aria-describedby="nome" placeholder="(XX)XXXX-XXXX" maxlength="15">
            </div>
            <div class="col-lg-3 form-group">
                <label for="nome">Celular:</label>
                <input type="tel" class="form-control" value="<?php echo $result['celular']?>" name="inputCelular" id="inputCelular" aria-describedby="nome" placeholder="(XX)X XXXX-XXXX" maxlength="15" required>
            </div>
            <div class="col-lg-3 form-group">
                <label for="nome">É Whatsapp?</label></br>
                <?php
                    $is=NULL;
                    $not=NULL;
                    if($result['isWhatsapp']==1){
                        $is='checked';
                    } else{
                        $not='checked';
                    }
                ?>
                <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="radioWhats" id="radioWhats1" value="1" <?php echo $is;?>>
                <label class="form-check-label" for="exampleRadios1">
                    Sim
                </label>
                </div>
                <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="radioWhats" id="radioWhats0" value="0" <?php echo $not;?>>
                <label class="form-check-label" for="exampleRadios2">
                    Não
                </label>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="reset" class="btn btn-outline-secondary">Limpar</button>
            <button type="submit" class="btn btn-outline-primary">Editar membro</button>
        </div>
    </form>
</div></br></br>
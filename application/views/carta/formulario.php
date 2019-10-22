<style>
.distancia {
    margin-left: 5px;
    margin-right: 10px;
    font-weight: normal;
}
</style>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Formulário de inscrição</h3>
            </div>
            <div class="box-body">
                <?php echo form_open_multipart('carta/formulario/'.$carta_pedido['id'], array('id' => 'form-formulario')); ?>
                <div class="row clearfix">
                    <div class="col-md-2">
                        <label for="numero" class="control-label">Número da Carta</label>
                        <div class="form-group">
                            <input disabled type="text" name="numero"
                                value="<?php echo ($this->input->post('numero') ? $this->input->post('numero') : $carta_pedido['numero']); ?>"
                                class="form-control" id="numero" />
                            <span class="text-danger"><?php echo form_error('numero');?></span>
                        </div>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-md-6">
                        <label for="beneficiado" class="control-label">Atendimento preferencial</label>
                        <div class="form-group">
                            <div class="col-md-8">
                                <input type="radio" value="" name="preferencial"
                                    <?php echo (($this->input->post('preferencial') ? $this->input->post('preferencial') : $carta_pedido['atendimento_preferencial']) == '') ? ' checked' : "";?> /><label
                                    class="distancia">Não</label>
                                <input type="radio" value="Até 1 ano e 11 meses" name="preferencial"
                                    <?php echo (($this->input->post('preferencial') ? $this->input->post('preferencial') : $carta_pedido['atendimento_preferencial']) == 'Até 1 ano e 11 meses') ? ' checked' : "";?> /><label
                                    class="distancia">Até 1 ano e 11 meses</label>
                                <input type="radio" value="Criança PNE" name="preferencial"
                                    <?php echo (($this->input->post('preferencial') ? $this->input->post('preferencial') : $carta_pedido['atendimento_preferencial']) == 'Criança PNE') ? ' checked' : "";?> /><label
                                    class="distancia">Criança PNE</label>
                                <input type="radio" value="Gestante" name="preferencial"
                                    <?php echo (($this->input->post('preferencial') ? $this->input->post('preferencial') : $carta_pedido['atendimento_preferencial']) == 'Gestante') ? ' checked' : "";?> /><label
                                    class="distancia">Gestante</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-md-12">
                        <label for="instituicao" class="control-label">Instituição</label>
                        <div class="form-group">
                            <input disabled type="text" name="instituicao"
                                value="<?php echo ($this->input->post('instituicao') ? $this->input->post('instituicao') : $instituicao['NO_INSTITUICAO']); ?>"
                                class="form-control" id="instituicao" />
                            <span class="text-danger"><?php echo form_error('instituicao');?></span>
                        </div>
                    </div>
                </div>

                <div class="panel panel-primary">
                    <div class="panel-heading">Beneficiado</div>
                    <div class="panel-body">
                        <input type="hidden" name="beneficiado_id" value="<?php echo $beneficiado['id']; ?>" />
                        <div class="row clearfix">
                            <div class="col-md-4">
                                <label for="nome" class="control-label"><span class="text-danger">*</span>Nome da
                                    criança</label>
                                <div class="form-group">
                                    <input type="text" name="nome"
                                        value="<?php echo ($this->input->post('nome') ? $this->input->post('nome') : $beneficiado['nome']); ?>"
                                        class="form-control" id="nome" required />
                                    <span class="text-danger"><?php echo form_error('nome');?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="dataNascimento" class="control-label"><span class="text-danger">*</span>Data
                                    de nascimento</label>
                                <div class="form-group">
                                    <input type="text" name="dataNascimento"
                                        value="<?php echo ($this->input->post('dataNascimento') ? $this->input->post('dataNascimento') : $beneficiado['data_nascimento']); ?>"
                                        class="form-control" id="dataNascimento" required />
                                    <span class="text-danger"><?php echo form_error('dataNascimento');?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="sexo" class="control-label"><span class="text-danger">*</span>Sexo</label>
                                <div class="form-group">
                                    <input type="radio" name="sexo" value="M"
                                        <?php echo (($this->input->post('sexo') ? $this->input->post('sexo') : $beneficiado['sexo']) == 'M') ? 'checked' : ''; ?>
                                        required /><label class="distancia">Masculino</label>
                                    <input type="radio" name="sexo" value="F"
                                        <?php echo (($this->input->post('sexo') ? $this->input->post('sexo') : $beneficiado['sexo']) == 'F') ? 'checked' : ''; ?> /><label
                                        class="distancia">Feminino</label>
                                    <span class="text-danger"><?php echo form_error('sexo');?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-md-4">
                                <label for="escola" class="control-label"><span class="text-danger">*</span>Em qual
                                    escola estuda?</label>
                                <div class="form-group">
                                    <input type="text" name="escola"
                                        value="<?php echo ($this->input->post('escola') ? $this->input->post('escola') : $carta_pedido['escola']); ?>"
                                        class="form-control" id="escola" required />
                                    <span class="text-danger"><?php echo form_error('escola');?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="ano" class="control-label"><span class="text-danger">*</span>Qual
                                    ano?</label>
                                <div class="form-group">
                                    <input type="radio" name="ano" value="0"
                                        <?php echo (($this->input->post('ano') ? $this->input->post('ano') : $carta_pedido['ano']) == 0) ? 'checked' : ''; ?>
                                        required /><label class="distancia">Pré</label>
                                    <input type="radio" name="ano" value="1"
                                        <?php echo (($this->input->post('ano') ? $this->input->post('ano') : $carta_pedido['ano']) == 1) ? 'checked' : ''; ?> /><label
                                        class="distancia">1º</label>
                                    <input type="radio" name="ano" value="2"
                                        <?php echo (($this->input->post('ano') ? $this->input->post('ano') : $carta_pedido['ano']) == 2) ? 'checked' : ''; ?> /><label
                                        class="distancia">2º</label>
                                    <input type="radio" name="ano" value="3"
                                        <?php echo (($this->input->post('ano') ? $this->input->post('ano') : $carta_pedido['ano']) == 3) ? 'checked' : ''; ?> /><label
                                        class="distancia">3º</label>
                                    <input type="radio" name="ano" value="4"
                                        <?php echo (($this->input->post('ano') ? $this->input->post('ano') : $carta_pedido['ano']) == 4) ? 'checked' : ''; ?> /><label
                                        class="distancia">4º</label>
                                    <input type="radio" name="ano" value="5"
                                        <?php echo (($this->input->post('ano') ? $this->input->post('ano') : $carta_pedido['ano']) == 5) ? 'checked' : ''; ?> /><label
                                        class="distancia">5º</label>
                                    <input type="radio" name="ano" value="6"
                                        <?php echo (($this->input->post('ano') ? $this->input->post('ano') : $carta_pedido['ano']) == 6) ? 'checked' : ''; ?> /><label
                                        class="distancia">6º</label>
                                    <input type="radio" name="ano" value="7"
                                        <?php echo (($this->input->post('ano') ? $this->input->post('ano') : $carta_pedido['ano']) == 7) ? 'checked' : ''; ?> /><label
                                        class="distancia">7º</label>
                                    <input type="radio" name="ano" value="8"
                                        <?php echo (($this->input->post('ano') ? $this->input->post('ano') : $carta_pedido['ano']) == 8) ? 'checked' : ''; ?> /><label
                                        class="distancia">8º</label>
                                    <input type="radio" name="ano" value="9"
                                        <?php echo (($this->input->post('ano') ? $this->input->post('ano') : $carta_pedido['ano']) == 9) ? 'checked' : ''; ?> /><label
                                        class="distancia">9º</label>
                                    <span class="text-danger"><?php echo form_error('ano');?></span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="cidade_escola" class="control-label"><span
                                        class="text-danger">*</span>Cidade da escola:</label>
                                <div class="form-group">
                                    <input type="text" name="cidade_escola" id="cidade_escola"
                                        value="<?php echo ($this->input->post('cidade_escola') ? $this->input->post('cidade_escola') : $carta_pedido['cidade_escola']); ?>"
                                        class="form-control" required />
                                    <span class="text-danger"><?php echo form_error('cidade_escola');?></span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="uf_escola" class="control-label"><span class="text-danger">*</span>UF da
                                    escola:</label>
                                <div class="form-group">
                                    <select name="uf_escola" class="form-control" id="uf_escola" required>
                                        <option value="">Selecione</option>
                                        <?php 
        								    foreach($all_ufs as $uf) {
        								        $selected = (($this->input->post('uf_escola') ? $this->input->post('uf_escola') : $carta_pedido['uf_escola']) == $uf['sigla'] ? ' selected' : '');
        
        										echo '<option value="'.$uf['sigla'].'" '.$selected.'>'.$uf['nome'].'</option>';
        									}
        								?>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('uf_escola');?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-md-4">
                                <label for="imagem" class="control-label">Anexar a foto da carta:</label>
                                <div class="form-group">
                                    <input type="file" name="imagem" class="form-control" />
                                </div>
                                <?php 
        						if ($carta_pedido['arquivo']) {
        						?>
                                <div class="form-group">
                                    <a href="<?php echo site_url('uploads/'.$carta_pedido['arquivo']);?>"
                                        target="_blank">Visualizar imagem</a>
                                </div>
                                <?php
        						}
        						?>
                            </div>
                            <div class="col-md-6">
                                Um aplicativo muito prático para tirar as fotos das cartas é o CamScanner. Links para
                                download:
                                <div>
                                    <a href="https://play.google.com/store/apps/details?id=com.intsig.camscanner&hl=pt"
                                        target="_blank">
                                        <img src="<?php echo site_url('resources/img/google-play-store-logo.png');?>"
                                            alt="download" style="width:25%;height:25%">
                                    </a>
                                    <a href="https://itunes.apple.com/br/app/camscanner/id388627783?mt=8"
                                        target="_blank">
                                        <img src="<?php echo site_url('resources/img/app-store-download.png');?>"
                                            alt="download" style="width:20%;height:20%">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading">Brinquedos</div>
                    <div class="panel-body">
                        <div class="row clearfix">
                            <div class="col-md-8" style="color:red;">
                                <label>Informe a descrição dos brinquedos conforme a carta:</label>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <label for="brinquedo1" class="control-label"><span class="text-danger">*</span>1ª
                                    opção:</label>
                                <div class="form-group">
                                    <input type="text" name="brinquedo1"
                                        value="<?php echo ($this->input->post('brinquedo1') ? $this->input->post('brinquedo1') : (array_key_exists(0, $brinquedos) ? $brinquedos[0]['descricao'] : "")); ?>"
                                        class="form-control" required />
                                    <input type="hidden" name="brinquedo1Id"
                                        value="<?php echo ($this->input->post('brinquedo1Id') ? $this->input->post('brinquedo1Id') : (array_key_exists(0, $brinquedos) ? $brinquedos[0]['id'] : "")); ?>"
                                        class="form-control" />
                                    <span class="text-danger"><?php echo form_error('brinquedo1');?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="brinquedo1Tipo" class="control-label"><span
                                        class="text-danger">*</span>Classificação:</label>
                                <div class="form-group">
                                    <select name="brinquedo1Tipo" class="form-control" required>
                                        <option value="">Selecione</option>
                                        <?php 
        								    foreach($brinquedo_classificacoes as $classificacao) {
        								        $selected = ((($this->input->post('brinquedo1Tipo') ? $this->input->post('brinquedo1Tipo') : (array_key_exists(0, $brinquedos) ? $brinquedos[0]['classificacao'] : "")) == $classificacao['id']) ? ' selected' : '');
        
        										echo '<option value="'.$classificacao['id'].'" '.$selected.'>'.$classificacao['nome'].'</option>';
        									} 
        								?>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('brinquedo1Tipo');?></span>
                                </div>

                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <label for="brinquedo2" class="control-label">2ª opção:</label>
                                <div class="form-group">
                                    <input type="text" name="brinquedo2"
                                        value="<?php echo ($this->input->post('brinquedo2') ? $this->input->post('brinquedo2') : (array_key_exists(1, $brinquedos) ? $brinquedos[1]['descricao'] : "")); ?>"
                                        class="form-control" />
                                    <input type="hidden" name="brinquedo2Id"
                                        value="<?php echo ($this->input->post('brinquedo2Id') ? $this->input->post('brinquedo2Id') : (array_key_exists(1, $brinquedos) ? $brinquedos[1]['id'] : "")); ?>"
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="brinquedo2Tipo" class="control-label">Classificação:</label>
                                <div class="form-group">
                                    <select name="brinquedo2Tipo" class="form-control">
                                        <option value="">Selecione</option>
                                        <?php 
        								    foreach($brinquedo_classificacoes as $classificacao)
        									{
        								        $selected = ($this->input->post('brinquedo2Tipo') ? $this->input->post('brinquedo2Tipo') : ((array_key_exists(1, $brinquedos) && $classificacao['id'] == $brinquedos[1]['classificacao']) ? ' selected' : ''));
        
        										echo '<option value="'.$classificacao['id'].'" '.$selected.'>'.$classificacao['nome'].'</option>';
        									} 
        								?>
                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <label for="brinquedo3" class="control-label">3ª opção:</label>
                                <div class="form-group">
                                    <input type="text" name="brinquedo3"
                                        value="<?php echo ($this->input->post('brinquedo3') ? $this->input->post('brinquedo3') : (array_key_exists(2, $brinquedos) ? $brinquedos[2]['descricao'] : "")); ?>"
                                        class="form-control" />
                                    <input type="hidden" name="brinquedo3Id"
                                        value="<?php echo ($this->input->post('brinquedo3Id') ? $this->input->post('brinquedo3Id') : (array_key_exists(2, $brinquedos) ? $brinquedos[2]['id'] : "")); ?>"
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="brinquedo3Tipo" class="control-label">Classificação:</label>
                                <div class="form-group">
                                    <select name="brinquedo3Tipo" class="form-control">
                                        <option value="">Selecione</option>
                                        <?php 
        								    foreach($brinquedo_classificacoes as $classificacao)
        									{
        									    $selected = ($this->input->post('brinquedo3Tipo') ? $this->input->post('brinquedo3Tipo') : ((array_key_exists(2, $brinquedos) && $classificacao['id'] == $brinquedos[2]['classificacao']) ? ' selected' : ''));
        
        										echo '<option value="'.$classificacao['id'].'" '.$selected.'>'.$classificacao['nome'].'</option>';
        									} 
        								?>
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading">Pai/Mãe/Responsável 1</div>
                    <div class="panel-body">
                        <input type="hidden" name="responsavel_id" value="<?php echo $responsavel['id']; ?>"
                            class="form-control" />
                        <div class="row clearfix">
                            <div class="col-md-7">
                                <label for="responsavel1Nome" class="control-label"><span
                                        class="text-danger">*</span>Nome:</label>
                                <div class="form-group">
                                    <input type="text" name="responsavel1Nome"  id="responsavel1Nome"
                                        value="<?php echo ($this->input->post('responsavel1Nome') ? $this->input->post('responsavel1Nome') : $responsavel['nome']); ?>"
                                        class="form-control" required />
                                    <span class="text-danger"><?php echo form_error('responsavel1Nome');?></span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="responsavel1DataNascimento" class="control-label"><span
                                        class="text-danger">*</span>Data de
                                    Nascimento:</label>
                                <div class="form-group">
                                    <input type="text" name="responsavel1DataNascimento" id="responsavel1DataNascimento"
                                        value="<?php echo ($this->input->post('responsavel1DataNascimento') ? $this->input->post('responsavel1DataNascimento') : $responsavel['data_nascimento']); ?>"
                                        class="form-control" id="responsavel1DataNascimento" required />
                                    <span
                                        class="text-danger"><?php echo form_error('responsavel1DataNascimento');?></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="responsavel1NumeroDocumento" class="control-label"><span
                                        class="text-danger">*</span>CPF:</label>
                                <div class="form-group">
                                    <input type="text" name="responsavel1NumeroDocumento"
                                        id="responsavel1NumeroDocumento"
                                        value="<?php echo ($this->input->post('responsavel1NumeroDocumento') ? $this->input->post('responsavel1NumeroDocumento') : $responsavel['documento_numero']); ?>"
                                        class="form-control" required />
                                    <span
                                        class="text-danger"><?php echo form_error('responsavel1NumeroDocumento');?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-md-2">
                                <label for="responsavel1Cep" class="control-label">CEP:</label>
                                <div class="form-group">
                                    <input type="text" name="responsavel1Cep" id="responsavel1Cep"
                                        value="<?php echo ($this->input->post('responsavel1Cep') ? $this->input->post('responsavel1Cep') : $responsavel['cep']); ?>"
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-5">
                                <label for="responsavel1Endereco" class="control-label"><span class="text-danger">*</span>Logradouro:</label>
                                <div class="form-group">
                                    <input type="text" name="responsavel1Endereco" id="responsavel1Endereco"
                                        value="<?php echo ($this->input->post('responsavel1Endereco') ? $this->input->post('responsavel1Endereco') : $responsavel['endereco']); ?>"
                                        class="form-control" required />
                                    <span class="text-danger"><?php echo form_error('responsavel1Endereco');?></span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="responsavel1Numero" class="control-label">Número:</label>
                                <div class="form-group">
                                    <input type="text" name="responsavel1Numero" id="responsavel1Numero"
                                        value="<?php echo ($this->input->post('responsavel1Numero') ? $this->input->post('responsavel1Numero') : $responsavel['numero']); ?>"
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="responsavel1Complemento" class="control-label">Complemento:</label>
                                <div class="form-group">
                                    <input type="text" name="responsavel1Complemento" id="responsavel1Complemento"
                                        value="<?php echo ($this->input->post('responsavel1Complemento') ? $this->input->post('responsavel1Complemento') : $responsavel['complemento']); ?>"
                                        class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-md-4">
                                <label for="responsavel1Bairro" class="control-label"><span
                                        class="text-danger">*</span>Bairro:</label>
                                <div class="form-group">
                                    <input type="text" name="responsavel1Bairro" id="responsavel1Bairro"
                                        value="<?php echo ($this->input->post('responsavel1Bairro') ? $this->input->post('responsavel1Bairro') : $responsavel['bairro']); ?>"
                                        class="form-control" required />
                                    <span class="text-danger"><?php echo form_error('responsavel1Bairro');?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="responsavel1Cidade" class="control-label"><span
                                        class="text-danger">*</span>Cidade:</label>
                                <div class="form-group">
                                    <input type="text" name="responsavel1Cidade" id="responsavel1Cidade"
                                        value="<?php echo ($this->input->post('responsavel1Cidade') ? $this->input->post('responsavel1Cidade') : $responsavel['cidade']); ?>"
                                        class="form-control" required />
                                    <span class="text-danger"><?php echo form_error('responsavel1Cidade');?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="responsavel1UF" class="control-label"><span
                                        class="text-danger">*</span>UF:</label>
                                <div class="form-group">
                                    <select name="responsavel1UF" class="form-control" id="responsavel1UF" required>
                                        <option value="">Selecione</option>
                                        <?php 
        								    foreach($all_ufs as $uf) {
        								        $selected = (($this->input->post('responsavel1UF') ? $this->input->post('responsavel1UF') : $responsavel['uf']) == $uf['sigla'] ? ' selected' : '');
        										echo '<option value="'.$uf['sigla'].'" '.$selected.'>'.$uf['nome'].'</option>';
        									}
        								?>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('responsavel1UF');?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-md-4">
                                <label for="responsavel1Email" class="control-label">E-mail:</label>
                                <div class="form-group">
                                    <input type="text" name="responsavel1Email" id="responsavel1Email"
                                        value="<?php echo ($this->input->post('responsavel1Email') ? $this->input->post('responsavel1Email') : $responsavel['email']); ?>"
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="responsavel1Telefone" class="control-label"><span
                                        class="text-danger">*</span>Telefone:</label>
                                <div class="form-group">
                                    <input type="text" name="responsavel1Telefone" id="responsavel1Telefone"
                                        value="<?php echo ($this->input->post('responsavel1Telefone') ? $this->input->post('responsavel1Telefone') : $responsavel['telefone']); ?>"
                                        class="form-control telefone" required />
                                    <span class="text-danger"><?php echo form_error('responsavel1Telefone');?></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="responsavel1TelefoneOperadora" class="control-label"><span
                                        class="text-danger">*</span>Operadora:</label>
                                <div class="form-group">
                                    <select class="form-control" name="responsavel1TelefoneOperadora" id="responsavel1TelefoneOperadora" required>
                                        <option value="">Selecione</option>
                                        <option value="Claro"
                                            <?php echo (($this->input->post('responsavel1TelefoneOperadora') ? $this->input->post('responsavel1TelefoneOperadora') : $responsavel['telefone_operadora']) == 'Claro') ? 'selected' : ''; ?>>
                                            Claro</option>
                                        <option value="Oi"
                                            <?php echo (($this->input->post('responsavel1TelefoneOperadora') ? $this->input->post('responsavel1TelefoneOperadora') : $responsavel['telefone_operadora']) == 'Oi') ? 'selected' : ''; ?>>
                                            Oi</option>
                                        <option value="Nextel"
                                            <?php echo (($this->input->post('responsavel1TelefoneOperadora') ? $this->input->post('responsavel1TelefoneOperadora') : $responsavel['telefone_operadora']) == 'Nextel') ? 'selected' : ''; ?>>
                                            Nextel</option>
                                        <option value="Tim"
                                            <?php echo (($this->input->post('responsavel1TelefoneOperadora') ? $this->input->post('responsavel1TelefoneOperadora') : $responsavel['telefone_operadora']) == 'Tim') ? 'selected' : ''; ?>>
                                            Tim</option>
                                        <option value="Vivo"
                                            <?php echo (($this->input->post('responsavel1TelefoneOperadora') ? $this->input->post('responsavel1TelefoneOperadora') : $responsavel['telefone_operadora']) == 'Vivo') ? 'selected' : ''; ?>>
                                            Vivo</option>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('responsavel1TelefoneOperadora');?></span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="responsavel1TelefoneWhatsapp" class="control-label"><span
                                        class="text-danger">*</span>Whatsapp:</label>
                                <div class="form-group">
                                    <input type="radio" name="responsavel1TelefoneWhatsapp" value="1"
                                        <?php echo (($this->input->post('responsavel1TelefoneWhatsapp') ? $this->input->post('responsavel1TelefoneWhatsapp') : $responsavel['telefone_whatsapp']) == 1 ? 'checked' : ''); ?>
                                        required /><label style="margin-left:5px;">Sim</label>
                                    <input type="radio" name="responsavel1TelefoneWhatsapp" value="0"
                                        <?php echo (($this->input->post('responsavel1TelefoneWhatsapp') ? $this->input->post('responsavel1TelefoneWhatsapp') : $responsavel['telefone_whatsapp']) == 0 ? 'checked' : ''); ?> /><label
                                        style="margin-left:5px;">Não</label>
                                    <span
                                        class="text-danger"><?php echo form_error('responsavel1TelefoneWhatsapp');?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading">Pai/Mãe/Responsável 2</div>
                    <div class="panel-body">
                        <input type="hidden" name="responsavel2_id" id="responsavel2_id"
                            value="<?php echo $responsavel_adicional['id']; ?>" class="form-control" />
                        <div class="row clearfix">
                            <div class="col-md-7">
                                <label for="responsavel2Nome" class="control-label"><span class="text-danger obrigatorio-resp2">*</span>Nome:</label>
                                <div class="form-group">
                                    <input type="text" name="responsavel2Nome" id="responsavel2Nome"
                                        value="<?php echo ($this->input->post('responsavel2Nome') ? $this->input->post('responsavel2Nome') : $responsavel_adicional['nome']); ?>"
                                        class="form-control" />
                                    <span class="text-danger"><?php echo form_error('responsavel2Nome');?></span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="responsavel2DataNascimento" class="control-label"><span class="text-danger obrigatorio-resp2">*</span>Data de
                                    Nascimento:</label>
                                <div class="form-group">
                                    <input type="text" name="responsavel2DataNascimento" id="responsavel2DataNascimento"
                                        value="<?php echo ($this->input->post('responsavel2DataNascimento') ? $this->input->post('responsavel2DataNascimento') : $responsavel_adicional['data_nascimento']); ?>"
                                        class="form-control" />
                                    <span
                                        class="text-danger"><?php echo form_error('responsavel2DataNascimento');?></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="responsavel2NumeroDocumento" class="control-label"><span class="text-danger obrigatorio-resp2">*</span>CPF:</label>
                                <div class="form-group">
                                    <input type="text" name="responsavel2NumeroDocumento"
                                        id="responsavel2NumeroDocumento"
                                        value="<?php echo ($this->input->post('responsavel2NumeroDocumento') ? $this->input->post('responsavel2NumeroDocumento') : $responsavel_adicional['documento_numero']); ?>"
                                        class="form-control" />
                                    <span
                                        class="text-danger"><?php echo form_error('responsavel2NumeroDocumento');?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="checkbox" value="1" name="mesmoEndereco" id="mesmoEndereco" />
                                    <label class="distancia">Mesmo endereço do responsável 1</label>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-md-2">
                                <label for="responsavel2Cep" class="control-label">CEP:</label>
                                <div class="form-group">
                                    <input type="text" name="responsavel2Cep" id="responsavel2Cep"
                                        value="<?php echo ($this->input->post('responsavel2Cep') ? $this->input->post('responsavel2Cep') : $responsavel_adicional['cep']); ?>"
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-5 mesmo-endereco">
                                <label for="responsavel2Endereco" class="control-label"><span class="text-danger obrigatorio-resp2">*</span>Logradouro:</label>
                                <div class="form-group">
                                    <input type="text" name="responsavel2Endereco" id="responsavel2Endereco"
                                        value="<?php echo ($this->input->post('responsavel2Endereco') ? $this->input->post('responsavel2Endereco') : $responsavel_adicional['endereco']); ?>"
                                        class="form-control" />
                                    <span class="text-danger"><?php echo form_error('responsavel2Endereco');?></span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="responsavel2Numero" class="control-label">Número:</label>
                                <div class="form-group">
                                    <input type="text" name="responsavel2Numero" id="responsavel2Numero"
                                        value="<?php echo ($this->input->post('responsavel2Numero') ? $this->input->post('responsavel2Numero') : $responsavel_adicional['numero']); ?>"
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-3 mesmo-endereco">
                                <label for="responsavel2Complemento" class="control-label">Complemento:</label>
                                <div class="form-group">
                                    <input type="text" name="responsavel2Complemento" id="responsavel2Complemento"
                                        value="<?php echo ($this->input->post('responsavel2Complemento') ? $this->input->post('responsavel2Complemento') : $responsavel_adicional['complemento']); ?>"
                                        class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix mesmo-endereco">
                            <div class="col-md-4">
                                <label for="responsavel2Bairro" class="control-label"><span class="text-danger obrigatorio-resp2">*</span>Bairro:</label>
                                <div class="form-group">
                                    <input type="text" name="responsavel2Bairro" id="responsavel2Bairro"
                                        value="<?php echo ($this->input->post('responsavel2Bairro') ? $this->input->post('responsavel2Bairro') : $responsavel_adicional['bairro']); ?>"
                                        class="form-control" />
                                    <span class="text-danger"><?php echo form_error('responsavel2Bairro');?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="responsavel2Cidade" class="control-label"><span class="text-danger obrigatorio-resp2">*</span>Cidade:</label>
                                <div class="form-group">
                                    <input type="text" name="responsavel2Cidade" id="responsavel2Cidade"
                                        value="<?php echo ($this->input->post('responsavel2Cidade') ? $this->input->post('responsavel2Cidade') : $responsavel_adicional['cidade']); ?>"
                                        class="form-control" />
                                    <span class="text-danger"><?php echo form_error('responsavel2Cidade');?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="responsavel2UF" class="control-label"><span class="text-danger obrigatorio-resp2">*</span>UF:</label>
                                <div class="form-group">
                                    <select name="responsavel2UF" class="form-control" id="responsavel2UF">
                                        <option value="">Selecione</option>
                                        <?php 
        								    foreach($all_ufs as $uf) {
        								        $selected = (($this->input->post('responsavel2UF') ? $this->input->post('responsavel2UF') : $responsavel_adicional['uf']) == $uf['sigla'] ? ' selected' : '');
        										echo '<option value="'.$uf['sigla'].'" '.$selected.'>'.$uf['nome'].'</option>';
        									}
        								?>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('responsavel2UF');?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-md-4">
                                <label for="responsavel2Email" class="control-label">E-mail:</label>
                                <div class="form-group">
                                    <input type="text" name="responsavel2Email" id="responsavel2Email"
                                        value="<?php echo ($this->input->post('responsavel2Email') ? $this->input->post('responsavel2Email') : $responsavel_adicional['email']); ?>"
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="responsavel2Telefone" class="control-label"><span class="text-danger obrigatorio-resp2">*</span>Telefone:</label>
                                <div class="form-group">
                                    <input type="text" name="responsavel2Telefone" id="responsavel2Telefone"
                                        value="<?php echo ($this->input->post('responsavel2Telefone') ? $this->input->post('responsavel2Telefone') : $responsavel_adicional['telefone']); ?>"
                                        class="form-control telefone" />
                                    <span class="text-danger"><?php echo form_error('responsavel2Telefone');?></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="responsavel2TelefoneOperadora" class="control-label"><span class="text-danger obrigatorio-resp2">*</span>Operadora:</label>
                                <div class="form-group">
                                    <select class="form-control" name="responsavel2TelefoneOperadora" id="responsavel2TelefoneOperadora">
                                        <option value="">Selecione</option>
                                        <option value="Claro"
                                            <?php echo (($this->input->post('responsavel2TelefoneOperadora') ? $this->input->post('responsavel2TelefoneOperadora') : $responsavel_adicional['telefone_operadora']) == 'Claro') ? 'selected' : ''; ?>>
                                            Claro</option>
                                        <option value="Oi"
                                            <?php echo (($this->input->post('responsavel2TelefoneOperadora') ? $this->input->post('responsavel2TelefoneOperadora') : $responsavel_adicional['telefone_operadora']) == 'Oi') ? 'selected' : ''; ?>>
                                            Oi</option>
                                        <option value="Nextel"
                                            <?php echo (($this->input->post('responsavel2TelefoneOperadora') ? $this->input->post('responsavel2TelefoneOperadora') : $responsavel_adicional['telefone_operadora']) == 'Nextel') ? 'selected' : ''; ?>>
                                            Nextel</option>
                                        <option value="Tim"
                                            <?php echo (($this->input->post('responsavel2TelefoneOperadora') ? $this->input->post('responsavel2TelefoneOperadora') : $responsavel_adicional['telefone_operadora']) == 'Tim') ? 'selected' : ''; ?>>
                                            Tim</option>
                                        <option value="Vivo"
                                            <?php echo (($this->input->post('responsavel2TelefoneOperadora') ? $this->input->post('responsavel2TelefoneOperadora') : $responsavel_adicional['telefone_operadora']) == 'Vivo') ? 'selected' : ''; ?>>
                                            Vivo</option>
                                    </select>
                                    <span
                                        class="text-danger"><?php echo form_error('responsavel2TelefoneOperadora');?></span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="responsavel2TelefoneWhatsapp" class="control-label"><span class="text-danger obrigatorio-resp2">*</span>Whatsapp:</label>
                                <div class="form-group">
                                    <input type="radio" name="responsavel2TelefoneWhatsapp" value="1"
                                        <?php echo (($this->input->post('responsavel2TelefoneWhatsapp') ? $this->input->post('responsavel2TelefoneWhatsapp') : $responsavel_adicional['telefone_whatsapp']) == 1 ? 'checked' : ''); ?> /><label
                                        style="margin-left:5px;">Sim</label>
                                    <input type="radio" name="responsavel2TelefoneWhatsapp" value="0"
                                        <?php echo (($this->input->post('responsavel2TelefoneWhatsapp') ? $this->input->post('responsavel2TelefoneWhatsapp') : $responsavel_adicional['telefone_whatsapp']) == 0 ? 'checked' : ''); ?> /><label
                                        style="margin-left:5px;">Não</label>
                                    <span
                                        class="text-danger"><?php echo form_error('responsavel2TelefoneWhatsapp');?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading">Informações sócio-econômicas</div>
                    <div class="panel-body">
                        <div class="row clearfix">

                            <?php
                            $all_familia = array('Mãe', 'Pai', 'Irmãos', 'Tio', 'Tia', 'Primos', 'Avô', 'Avó');
                            ?>

                            <div class="col-md-4">
                                <label for="familia[]" class="control-label">Quem mora com a criança?</label>
                                <div class="form-group">

                                    <?php
                                    foreach ($all_familia as $key => $fam) {
                                    ?>
                                    <input type="checkbox" value="<?php echo mb_strtolower($fam); ?>" name="familia[]"
                                        <?php echo (($this->input->post('familia') ? in_array(mb_strtolower($fam), $this->input->post('familia'), true) : !empty($familiares) && in_array(mb_strtolower($fam), $familiares, true)) ? ' checked' : '');?> /><label
                                        class="distancia"><?php echo $fam; ?></label>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="responsavel2" class="control-label">Pais separados?</label>
                                <div class="form-group">
                                    <input type="radio" name="paisSeparados" value="1"
                                        <?php echo (($this->input->post('paisSeparados') ? $this->input->post('paisSeparados') : $beneficiado['pais_separados']) == 1 ? 'checked' : ''); ?> />Sim
                                    <input type="radio" name="paisSeparados" value="0"
                                        <?php echo (($this->input->post('paisSeparados') ? $this->input->post('paisSeparados') : $beneficiado['pais_separados']) == 0 ? 'checked' : ''); ?> />Não
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-md-8">
                                <label for="renda" class="control-label">Renda familiar:</label>
                                <div class="form-group">
                                    <input type="radio" value="Até 1 salário mínimo" name="renda"
                                        <?php echo (($this->input->post('renda') ? $this->input->post('renda') : $carta_pedido['renda_familiar']) == 'Até 1 salário mínimo') ? ' checked' : "";?> /><label
                                        class="distancia">Até 1 salário mínimo</label>
                                    <input type="radio" value="Até 2 salários mínimos" name="renda"
                                        <?php echo (($this->input->post('renda') ? $this->input->post('renda') : $carta_pedido['renda_familiar']) == 'Até 2 salários mínimos') ? ' checked' : "";?> /><label
                                        class="distancia">Até 2 salários mínimos</label>
                                    <input type="radio" value="Mais de 3 salários mínimos" name="renda"
                                        <?php echo (($this->input->post('renda') ? $this->input->post('renda') : $carta_pedido['renda_familiar']) == 'Mais de 3 salários mínimos') ? ' checked' : "";?> /><label
                                        class="distancia">Mais de 3 salários mínimos</label>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-md-8">
                                <label for="moradia" class="control-label">Casa:</label>
                                <div class="form-group">
                                    <input type="radio" value="Própria" name="moradia"
                                        <?php echo (($this->input->post('moradia') ? $this->input->post('moradia') : $carta_pedido['moradia']) == 'Própria') ? ' checked' : "";?> /><label
                                        class="distancia">Própria</label>
                                    <input type="radio" value="Alugada" name="moradia"
                                        <?php echo (($this->input->post('moradia') ? $this->input->post('moradia') : $carta_pedido['moradia']) == 'Alugada') ? ' checked' : "";?> /><label
                                        class="distancia">Alugada</label>
                                    <input type="radio" value="Cedida" name="moradia"
                                        <?php echo (($this->input->post('moradia') ? $this->input->post('moradia') : $carta_pedido['moradia']) == 'Cedida') ? ' checked' : "";?> /><label
                                        class="distancia">Cedida</label>
                                    <input type="radio" value="Casa de Acolhimento" name="moradia"
                                        <?php echo (($this->input->post('moradia') ? $this->input->post('moradia') : $carta_pedido['moradia']) == 'Casa de Acolhimento') ? ' checked' : "";?> /><label
                                        class="distancia">Casa de Acolhimento</label>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-md-8">
                                <label for="responsavel1Ocupacao" class="control-label">Ocupação principal do
                                    responsável 1:</label>
                                <div class="form-group">
                                    <input type="text" name="responsavel1Ocupacao"
                                        value="<?php echo ($this->input->post('responsavel1Ocupacao') ? $this->input->post('responsavel1Ocupacao') : $responsavel['ocupacao']); ?>"
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="responsavel1Escolaridade" class="control-label">Escolaridade do responsável
                                    1:</label>
                                <div class="form-group">
                                    <select class="form-control" name="responsavel1Escolaridade">
                                        <option value="">Selecione</option>
                                        <option value="Analfabeto"
                                            <?php echo ($responsavel['escolaridade'] == 'Analfabeto') ? 'selected' : ''; ?>>
                                            Analfabeto</option>
                                        <option value="Alfabetizado"
                                            <?php echo ($responsavel['escolaridade'] == 'Alfabetizado') ? 'selected' : ''; ?>>
                                            Alfabetizado</option>
                                        <option value="1ª à 4ª serie"
                                            <?php echo ($responsavel['escolaridade'] == '1ª à 4ª serie') ? 'selected' : ''; ?>>
                                            1ª à 4ª serie</option>
                                        <option value="5ª à 9ª série"
                                            <?php echo ($responsavel['escolaridade'] == '5ª à 9ª série') ? 'selected' : ''; ?>>
                                            5ª à 9ª série</option>
                                        <option value="Ensino médio completo"
                                            <?php echo ($responsavel['escolaridade'] == 'Ensino médio completo') ? 'selected' : ''; ?>>
                                            Ensino médio completo</option>
                                        <option value="Ensino médio incompleto"
                                            <?php echo ($responsavel['escolaridade'] == 'Ensino médio incompleto') ? 'selected' : ''; ?>>
                                            Ensino médio incompleto</option>
                                        <option value="Ensino superior incompleto"
                                            <?php echo ($responsavel['escolaridade'] == 'Ensino superior incompleto') ? 'selected' : ''; ?>>
                                            Ensino superior incompleto</option>
                                        <option value="Ensino superior completo"
                                            <?php echo ($responsavel['escolaridade'] == 'Ensino superior completo') ? 'selected' : ''; ?>>
                                            Ensino superior completo</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-md-8">
                                <label for="responsavel2Ocupacao" class="control-label">Ocupação principal do
                                    responsável 2:</label>
                                <div class="form-group">
                                    <input type="text" name="responsavel2Ocupacao"
                                        value="<?php echo ($this->input->post('responsavel2Ocupacao') ? $this->input->post('responsavel2Ocupacao') : $responsavel_adicional['ocupacao']); ?>"
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="responsavel2Escolaridade" class="control-label">Escolaridade do responsável
                                    2:</label>
                                <div class="form-group">
                                    <select class="form-control" name="responsavel2Escolaridade">
                                        <option value="">Selecione</option>
                                        <option value="Analfabeto"
                                            <?php echo ($responsavel_adicional['escolaridade'] == 'Analfabeto') ? 'selected' : ''; ?>>
                                            Analfabeto</option>
                                        <option value="Alfabetizado"
                                            <?php echo ($responsavel_adicional['escolaridade'] == 'Alfabetizado') ? 'selected' : ''; ?>>
                                            Alfabetizado</option>
                                        <option value="1ª à 4ª serie"
                                            <?php echo ($responsavel_adicional['escolaridade'] == '1ª à 4ª serie') ? 'selected' : ''; ?>>
                                            1ª à 4ª serie</option>
                                        <option value="5ª à 9ª série"
                                            <?php echo ($responsavel_adicional['escolaridade'] == '5ª à 9ª série') ? 'selected' : ''; ?>>
                                            5ª à 9ª série</option>
                                        <option value="Ensino médio completo"
                                            <?php echo ($responsavel_adicional['escolaridade'] == 'Ensino médio completo') ? 'selected' : ''; ?>>
                                            Ensino médio completo</option>
                                        <option value="Ensino médio incompleto"
                                            <?php echo ($responsavel_adicional['escolaridade'] == 'Ensino médio incompleto') ? 'selected' : ''; ?>>
                                            Ensino médio incompleto</option>
                                        <option value="Ensino superior incompleto"
                                            <?php echo ($responsavel_adicional['escolaridade'] == 'Ensino superior incompleto') ? 'selected' : ''; ?>>
                                            Ensino superior incompleto</option>
                                        <option value="Ensino superior completo"
                                            <?php echo ($responsavel_adicional['escolaridade'] == 'Ensino superior completo') ? 'selected' : ''; ?>>
                                            Ensino superior completo</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <?php

                $all_programacoes = array('Valorização da Educação', 'Financiamento de Imóveis', 'Educação Financeira', 'Saúde Mental', 'Saúde Bucal', 'Saúde e bem-estar', 'Alcoólicos Anônimos', 'Narcóticos Anônimos', 'Outros');

                ?>

                <div class="panel panel-primary">
                    <div class="panel-heading">Programação</div>
                    <div class="panel-body">
                        <div class="row clearfix">
                            <div class="col-md-8">
                                <label for="programacao[]" class="control-label"><span
                                        class="text-danger">*</span>Selecione até 3 programações (mínimo 1
                                    obrigatoriamente)</label>
                                <div class="form-group">

                                    <?php foreach($all_programacoes as $key => $prog) {
                                    ?>
                                    <div>
                                        <input type="checkbox" value="<?php echo $prog; ?>" name="programacao[]"
                                            <?php echo ($this->input->post('programacao') ? in_array($prog, $this->input->post('programacao'), true) : (!empty($programacoes) && in_array($prog, $programacoes, true)) ? ' checked' : '');?> /><label
                                            class="distancia"><?php echo $prog; ?></label>
                                    </div>
                                    <?php } ?>

                                    <span class="text-danger"><?php echo form_error('programacao[]');?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-success" id="salvar-formulario">
                    <i class="fa fa-check"></i> Salvar
                </button>
            </div>
        </div>
    </div>
</div>
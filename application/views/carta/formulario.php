<style>
    .distancia {
    margin-left:5px;
    margin-right:10px;
    font-weight:normal;
    }
</style>
<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title">Formulário de inscrição</h3>
            </div>
			<?php echo form_open_multipart('carta/formulario/'.$carta_pedido['id']); ?>
			<div class="box-body">
				<div class="row clearfix">
					<div class="col-md-2">
						<label for="numero" class="control-label">Carta</label>
						<div class="form-group">
							<input disabled type="text" name="numero" value="<?php echo ($this->input->post('numero') ? $this->input->post('numero') : $carta_pedido['numero']); ?>" class="form-control" id="numero" />
							<span class="text-danger"><?php echo form_error('numero');?></span>
						</div>
					</div>
				</div>
				<div  class="panel panel-primary">
					<div class="panel-heading">Beneficiado</div>
					<div class="panel-body">
        				<div class="row clearfix">
        					<div class="col-md-6">
        						<label for="beneficiado" class="control-label">Atendimento preferencial</label>
        						<div class="form-group">
        							<div class="col-md-8">
                						<input type="radio" value="Até 1 ano e 11 meses" name="preferencial" <?php echo ($carta_pedido['atendimento_preferencial'] == 'Até 1 ano e 11 meses') ? ' checked' : "";?> /><label class="distancia">Até 1 ano e 11 meses</label>
                					    <input type="radio" value="Criança PNE" name="preferencial" <?php echo ($carta_pedido['atendimento_preferencial'] == 'Criança PNE') ? ' checked' : "";?>  /><label class="distancia">Criança PNE</label>
                					    <input type="radio" value="Gestante" name="preferencial"  <?php echo ($carta_pedido['atendimento_preferencial'] == 'Gestante') ? ' checked' : "";?> /><label class="distancia">Gestante</label>
        					    	</div>
        						</div>
        					</div>
        				</div>				
        				<div class="row clearfix">
        					<div class="col-md-4">
        						<label for="regiao_administrativa" class="control-label"><span class="text-danger">*</span>Comunidade</label>
        						<div class="form-group">
        							<select name="regiao_administrativa" class="form-control">
        								<option value=""></option>
        								<?php 
        									foreach($all_regioes as $regiao_administrativa) {
        										$selected = ($regiao_administrativa['id'] == $carta_pedido['regiao_administrativa']) ? ' selected="selected"' : "";
        
        										echo '<option value="'.$regiao_administrativa['id'].'" '.$selected.'>'.$regiao_administrativa['nome'].'</option>';
        									} 
        								?>
        							</select>
        							<span class="text-danger"><?php echo form_error('regiao_administrativa');?></span>
        						</div>
        					</div>
        				</div>
        				<div class="row clearfix">
        					<div class="col-md-4">
        						<label for="numero" class="control-label"><span class="text-danger">*</span>Nome da criança</label>
        						<div class="form-group">
        							<input type="text" name="nome" value="<?php echo $beneficiado['nome']; ?>" class="form-control" id="nome" />
	        						<span class="text-danger"><?php echo form_error('nome');?></span>
        						</div>
        					</div>
        					<div class="col-md-4">
        						<label for="numero" class="control-label"><span class="text-danger">*</span>Data de nascimento</label>
        						<div class="form-group">
        							<input type="text" name="dataNascimento" value="<?php echo $beneficiado['data_nascimento']; ?>" class="has-datepicker form-control" id="nome" />
        							<span class="text-danger"><?php echo form_error('data_nascimento');?></span>
        						</div>
        					</div>
        				</div>
        				<div class="row clearfix">
        					<div class="col-md-8">
        						<label for="numero" class="control-label"><span class="text-danger">*</span>Sexo</label>
        						<div class="form-group">
        							<input type="radio" name="sexo" value="M" <?php echo ($beneficiado['sexo'] == 'M') ? 'checked' : ''; ?>/><label class="distancia">Masculino</label>
        							<input type="radio" name="sexo" value="F" <?php echo ($beneficiado['sexo'] == 'F') ? 'checked' : ''; ?>/><label class="distancia">Feminino</label>
        						</div>
        						<span class="text-danger"><?php echo form_error('sexo');?></span>
        					</div>
        				</div>
        				<div class="row clearfix">
        					<div class="col-md-4">
        						<label for="numero" class="control-label">Em qual escola estuda?</label>
        						<div class="form-group">
        							<input type="text" name="escola" value="<?php echo $carta_pedido['escola']; ?>" class="form-control"/>
        						</div>
        					</div>
        					<div class="col-md-4">
        						<label for="numero" class="control-label">Qual ano?</label>
        						<div class="form-group">
        							<input type="radio" name="ano" value="0" <?php echo ($carta_pedido['ano'] == 0) ? 'checked' : ''; ?> /><label class="distancia">Pré</label>
        							<input type="radio" name="ano" value="1" <?php echo ($carta_pedido['ano'] == 1) ? 'checked' : ''; ?> /><label class="distancia">1ª</label>
        							<input type="radio" name="ano" value="2" <?php echo ($carta_pedido['ano'] == 2) ? 'checked' : ''; ?> /><label class="distancia">2ª</label>
        							<input type="radio" name="ano" value="3" <?php echo ($carta_pedido['ano'] == 3) ? 'checked' : ''; ?> /><label class="distancia">3ª</label>
        							<input type="radio" name="ano" value="4" <?php echo ($carta_pedido['ano'] == 4) ? 'checked' : ''; ?> /><label class="distancia">4ª</label>
        							<input type="radio" name="ano" value="5" <?php echo ($carta_pedido['ano'] == 5) ? 'checked' : ''; ?> /><label class="distancia">5ª</label>
        							<input type="radio" name="ano" value="6" <?php echo ($carta_pedido['ano'] == 6) ? 'checked' : ''; ?> /><label class="distancia">6ª</label>
        							<input type="radio" name="ano" value="7" <?php echo ($carta_pedido['ano'] == 7) ? 'checked' : ''; ?> /><label class="distancia">7ª</label>
        							<input type="radio" name="ano" value="8" <?php echo ($carta_pedido['ano'] == 8) ? 'checked' : ''; ?> /><label class="distancia">8ª</label>
        							<input type="radio" name="ano" value="9" <?php echo ($carta_pedido['ano'] == 9) ? 'checked' : ''; ?> /><label class="distancia">9ª</label>
        						</div>
        					</div>
        				</div>
        				<div class="row clearfix">
        					<div class="col-md-4">
        						<label for="numero" class="control-label">Anexar a foto da carta:</label>
        						<div class="form-group">
        							<input type="file" name="imagem" class="form-control"/>
        						</div>
        						<?php 
        						if ($carta_pedido['arquivo']) {
        						?>
        						<div class="form-group">
        							<a href="<?php echo site_url('uploads/'.$carta_pedido['arquivo']);?>" target="_blank">Visualizar imagem</a>
        						</div>
        						<?php
        						}
        						?>
        					</div>
        					<div class="col-md-6">
        						Um aplicativo muito prático para tirar as fotos das cartas é o CamScanner. Links para download:
        						<div>
            						<a href="https://play.google.com/store/apps/details?id=com.intsig.camscanner&hl=pt" target="_blank">
            							<img src="<?php echo site_url('resources/img/google-play-store-logo.png');?>" alt="download" style="width:25%;height:25%" >
            						</a>
            						<a href="https://itunes.apple.com/br/app/camscanner/id388627783?mt=8" target="_blank">
            							<img src="<?php echo site_url('resources/img/app-store-download.png');?>" alt="download" style="width:20%;height:20%" >
            						</a>
        						</div>
        					</div>
        				</div>
        			</div>
        		</div>
        		<div  class="panel panel-primary">
					<div class="panel-heading">Brinquedos</div>
					<div class="panel-body">
						<div class="row clearfix">
							<div class="col-md-8" style="color:red;">
								<label>Informe a descrição dos brinquedos conforme a carta:</label>
							</div>
						</div>
						<div class="row clearfix">
        					<div class="col-md-4">
        						<label for="numero" class="control-label"><span class="text-danger">*</span>1ª opção:</label>
        						<div class="form-group">
        							<input type="text" name="brinquedo1" value="<?php echo (array_key_exists(0,$brinquedos)) ? $brinquedos[0]['descricao'] : ""; ?>" class="form-control"/>
        							<input type="hidden" name="brinquedo1Id" value="<?php echo (array_key_exists(0,$brinquedos)) ? $brinquedos[0]['id'] : ""; ?>" class="form-control"/>
        							<span class="text-danger"><?php echo form_error('brinquedo1');?></span>
        						</div>
        					</div>
        					<div class="col-md-4">
        						<label for="numero" class="control-label"><span class="text-danger">*</span>Classificação:</label>
        						<div class="form-group">		
        							<select name="brinquedo1Tipo" class="form-control">
        								<option value="">selecione</option>
        								<?php 
        								    foreach($brinquedo_classificacoes as $classificacao) {
        								        $selected = (array_key_exists(0,$brinquedos) && $classificacao['id'] == $brinquedos[0]['classificacao']) ? ' selected="selected"' : "";
        
        										echo '<option value="'.$classificacao['id'].'" '.$selected.'>'.$classificacao['nome'].'</option>';
        									} 
        								?>
        							</select>
        							<span class="text-danger"><?php echo form_error('brinquedo1Tipo');?></span>
        						</div>
        						
        					</div>
        				</div>
        				<div class="row clearfix">
        					<div class="col-md-4">
        						<label for="numero" class="control-label">2ª opção:</label>
        						<div class="form-group">
        							<input type="text" name="brinquedo2" value="<?php echo (array_key_exists(1,$brinquedos)) ? $brinquedos[1]['descricao'] : ""; ?>" class="form-control"/>
        							<input type="hidden" name="brinquedo2Id" value="<?php echo (array_key_exists(1,$brinquedos)) ? $brinquedos[1]['id'] : ""; ?>" class="form-control"/>
        						</div>
        					</div>
        					<div class="col-md-4">
        						<label for="numero" class="control-label">Classificação:</label>
        						<div class="form-group">		
        							<select name="brinquedo2Tipo" class="form-control">
        								<option value="">selecione</option>
        								<?php 
        								    foreach($brinquedo_classificacoes as $classificacao)
        									{
        									    $selected = (array_key_exists(1,$brinquedos) && $classificacao['id'] == $brinquedos[1]['classificacao']) ? ' selected="selected"' : "";
        
        										echo '<option value="'.$classificacao['id'].'" '.$selected.'>'.$classificacao['nome'].'</option>';
        									} 
        								?>
        							</select>
        						</div>
        						
        					</div>
        				</div>
        				<div class="row clearfix">
        					<div class="col-md-4">
        						<label for="numero" class="control-label">3ª opção:</label>
        						<div class="form-group">
        							<input type="text" name="brinquedo3" value="<?php echo (array_key_exists(2,$brinquedos)) ? $brinquedos[2]['descricao'] : ""; ?>" class="form-control"/>
        							<input type="hidden" name="brinquedo3Id" value="<?php echo (array_key_exists(2,$brinquedos)) ? $brinquedos[2]['id'] : ""; ?>" class="form-control"/>
        						</div>
        					</div>
        					<div class="col-md-4">
        						<label for="numero" class="control-label">Classificação:</label>
        						<div class="form-group">		
        							<select name="brinquedo3Tipo" class="form-control">
        								<option value="">selecione</option>
        								<?php 
        								    foreach($brinquedo_classificacoes as $classificacao)
        									{
        									    $selected = (array_key_exists(2,$brinquedos) && $classificacao['id'] == $brinquedos[2]['classificacao']) ? ' selected="selected"' : "";
        
        										echo '<option value="'.$classificacao['id'].'" '.$selected.'>'.$classificacao['nome'].'</option>';
        									} 
        								?>
        							</select>
        						</div>
        						
        					</div>
        				</div>
					</div>
				</div>
				<div  class="panel panel-primary">
					<div class="panel-heading">Pai/Mãe/Responsável 1</div>
					<div class="panel-body">
        				<div class="row clearfix">
        					<div class="col-md-4">
        						<label for="responsavel1Nome" class="control-label">Nome:</label>
        						<div class="form-group">
        							<input type="text" name="responsavel1Nome" value="<?php echo $responsavel['nome']; ?>" class="form-control"/>
        						</div>
        					</div>
        					<div class="col-md-4">
        						<label for="responsavel1DataNascimento" class="control-label">Data de Nascimento:</label>
        						<div class="form-group">
        							<input type="text" name="responsavel1DataNascimento" value="<?php echo $responsavel['data_nascimento']; ?>" class="has-datepicker form-control" />
        						</div>
        					</div>
        				</div>
        				<div class="row clearfix">
        					<div class="col-md-4">
        						<label for="responsavel1NumeroDocumento" class="control-label">Número do documento:</label>
        						<div class="form-group">
        							<input type="text" name="responsavel1NumeroDocumento" value="<?php echo $responsavel['documento_numero']; ?>" class="form-control"/>
        						</div>
        					</div>
        					<div class="col-md-4">
        						<label for="responsavel1Documento" class="control-label">Documento:</label>
        						<div class="form-group">
        							<select name="responsavel1Documento" class="form-control">
        								<option value="">selecione</option>
        								<option value="CPF" <?php echo ($responsavel['documento_tipo'] == 'CPF') ? 'śelected' : ''; ?>>CPF</option>
        								<option value="RG" <?php echo ($responsavel['documento_tipo'] == 'RG') ? 'śelected' : ''; ?>>RG</option>
        								<option value="CNH" <?php echo ($responsavel['documento_tipo'] == 'CNH') ? 'śelected' : ''; ?>>CNH</option>
        								<option value="OUTRO" <?php echo ($responsavel['documento_tipo'] == 'OUTRO') ? 'śelected' : ''; ?>>OUTRO</option>
        							</select>
        						</div>
        					</div>
        				</div>
        				<div class="row clearfix">
        					<div class="col-md-4">
        						<label for="responsavel1Email" class="control-label">E-mail:</label>
        						<div class="form-group">
        							<input type="text" name="responsavel1Email" value="<?php echo $responsavel['email']; ?>" class="form-control"/>
        						</div>
        					</div>
        					<div class="col-md-6">
        						<label for="responsavel1Endereco" class="control-label">Endereço:</label>
        						<div class="form-group">
        							<input type="text" name="responsavel1Endereco" value="<?php echo $responsavel['endereco']; ?>" class="form-control"/>
        						</div>
        					</div>
        				</div>
        				<div class="row clearfix">
        					<div class="col-md-4">
        						<label for="responsavel1Telefone" class="control-label">Telefone:</label>
        						<div class="form-group">
        							<input type="text" name="responsavel1Telefone" value="<?php echo $responsavel['telefone']; ?>" class="form-control phones"/>
        						</div>
        					</div>
        					<div class="col-md-4">
        						<label for="responsavel1TelefoneOperadora" class="control-label">Operadora:</label>
        						<div class="form-group">
        							<select class="form-control" name="responsavel1TelefoneOperadora">
        								<option value="">selecione</option>
        								<option value="Claro" <?php echo ($responsavel['telefone_operadora'] == 'Claro') ? 'selected' : ''; ?>>Claro</option>
        								<option value="Oi" <?php echo ($responsavel['telefone_operadora'] == 'Oi') ? 'selected' : ''; ?>>Oi</option>
        								<option value="Nextel" <?php echo ($responsavel['telefone_operadora'] == 'Nextel') ? 'selected' : ''; ?>>Nextel</option>
        								<option value="Tim" <?php echo ($responsavel['telefone_operadora'] == 'Tim') ? 'selected' : ''; ?>>Tim</option>
        								<option value="Vivo" <?php echo ($responsavel['telefone_operadora'] == 'Vivo') ? 'selected' : ''; ?>>Vivo</option>
        							</select>
        						</div>
        					</div>
        					<div class="col-md-4">
        						<label for="responsavel1TelefoneWhatsapp" class="control-label">Whatsapp:</label>
        						<div class="form-group">
        							<input type="radio" name="responsavel1TelefoneWhatsapp" value="1" <?php echo ($responsavel['telefone_whatsapp']) ? 'checked':''; ?>/><label style="margin-left:5px;">Sim</label>
        							<input type="radio" name="responsavel1TelefoneWhatsapp" value="0" <?php echo (!$responsavel['telefone_whatsapp']) ? 'checked':''; ?>/><label style="margin-left:5px;">Não</label>
        						</div>
        					</div>
        				</div>
        				<div class="row clearfix">
        					<div class="col-md-8">
        						<label for="responsavel1Ocupacao" class="control-label">Ocupação principal:</label>
        						<div class="form-group">
        							<input type="text" name="responsavel1Ocupacao" value="<?php echo $responsavel['ocupacao']; ?>" class="form-control"/>
        						</div>
        					</div>
        				</div>
        				<div class="row clearfix">
        					<div class="col-md-8">
        						<label for="responsavel1Escolaridade" class="control-label">Escolaridade:</label>
        						<div class="form-group">
        							<select class="form-control" name="responsavel1Escolaridade">
        								<option value="">Selecione</option>
        								<option value="Analfabeto" <?php echo ($responsavel['escolaridade'] == 'Analfabeto') ? 'selected' : ''; ?>>Analfabeto</option>
        								<option value="Alfabetizado" <?php echo ($responsavel['escolaridade'] == 'Alfabetizado') ? 'selected' : ''; ?>>Alfabetizado</option>
        								<option value="1ª à 4ª serie" <?php echo ($responsavel['escolaridade'] == '1ª à 4ª serie') ? 'selected' : ''; ?>>1ª à 4ª serie</option>
        								<option value="5ª à 9ª série" <?php echo ($responsavel['escolaridade'] == '5ª à 9ª série') ? 'selected' : ''; ?>>5ª à 9ª série</option>
        								<option value="Ensino médio completo" <?php echo ($responsavel['escolaridade'] == 'Ensino médio completo') ? 'selected' : ''; ?>>Ensino médio completo</option>
        								<option value="Ensino médio incompleto" <?php echo ($responsavel['escolaridade'] == 'Ensino médio incompleto') ? 'selected' : ''; ?>>Ensino médio incompleto</option>
        								<option value="Ensino superior incompleto" <?php echo ($responsavel['escolaridade'] == 'Ensino superior incompleto') ? 'selected' : ''; ?>>Ensino superior incompleto</option>
        								<option value="Ensino superior completo" <?php echo ($responsavel['escolaridade'] == 'Ensino superior completo') ? 'selected' : ''; ?>>Ensino superior completo</option>
        							</select>
        						</div>
        					</div>
            			</div>
    				</div>
				</div>
				<div  class="panel panel-primary">
					<div class="panel-heading">Pai/Mãe/Responsável 2</div>
					<div class="panel-body">
        				<div class="row clearfix">
        					<div class="col-md-4">
        						<label for="responsavel2Nome" class="control-label">Nome:</label>
        						<div class="form-group">
        							<input type="text" name="responsavel2Nome" value="<?php echo $responsavel_adicional['nome']; ?>" class="form-control"/>
        						</div>
        					</div>
        					<div class="col-md-4">
        						<label for="responsavel2DataNascimento" class="control-label">Data de Nascimento:</label>
        						<div class="form-group">
        							<input type="text" name="responsavel2DataNascimento" value="<?php echo $responsavel_adicional['data_nascimento']; ?>" class="has-datepicker form-control" />
        						</div>
        					</div>
        				</div>
        				<div class="row clearfix">
        					<div class="col-md-4">
        						<label for="responsavel2NumeroDocumento" class="control-label">Número do documento:</label>
        						<div class="form-group">
        							<input type="text" name="responsavel2NumeroDocumento" value="<?php echo $responsavel_adicional['documento_numero']; ?>" class="form-control"/>
        						</div>
        					</div>
        					<div class="col-md-4">
        						<label for="responsavel2Documento" class="control-label">Documento:</label>
        						<div class="form-group">
        							<select name="responsavel2Documento" class="form-control">
        								<option value="">Selecione</option>
        								<option value="CPF" <?php echo ($responsavel_adicional['documento_tipo'] == 'CPF') ? 'śelected' : ''; ?>>CPF</option>
        								<option value="RG" <?php echo ($responsavel_adicional['documento_tipo'] == 'RG') ? 'śelected' : ''; ?>>RG</option>
        								<option value="CNH" <?php echo ($responsavel_adicional['documento_tipo'] == 'CNH') ? 'śelected' : ''; ?>>CNH</option>
        								<option value="OUTRO" <?php echo ($responsavel_adicional['documento_tipo'] == 'OUTRO') ? 'śelected' : ''; ?>>OUTRO</option>
        							</select>
        						</div>
        					</div>
        				</div>
        				<div class="row clearfix">
        					<div class="col-md-4">
        						<label for="responsavel2Email" class="control-label">E-mail:</label>
        						<div class="form-group">
        							<input type="text" name="responsavel2Email" value="<?php echo $responsavel_adicional['email']; ?>" class="form-control"/>
        						</div>
        					</div>
        					<div class="col-md-6">
        						<label for="responsavel2Endereco" class="control-label">Endereço:</label>
        						<div class="form-group">
        							<input type="text" name="responsavel2Endereco" value="<?php echo $responsavel_adicional['endereco']; ?>" class="form-control"/>
        						</div>
        					</div>
        				</div>
        				<div class="row clearfix">
        					<div class="col-md-4">
        						<label for="responsavel2Telefone" class="control-label">Telefone:</label>
        						<div class="form-group">
        							<input type="text" name="responsavel2Telefone" value="<?php echo $responsavel_adicional['telefone']; ?>" class="form-control phones"/>
        						</div>
        					</div>
        					<div class="col-md-4">
        						<label for="responsavel2TelefoneOperadora" class="control-label">Operadora:</label>
        						<div class="form-group">
        							<select class="form-control" name="responsavel2TelefoneOperadora">
        								<option value="">selecione</option>
        								<option value="Claro" <?php echo ($responsavel_adicional['telefone_operadora'] == 'Claro') ? 'selected' : ''; ?>>Claro</option>
        								<option value="Oi" <?php echo ($responsavel_adicional['telefone_operadora'] == 'Oi') ? 'selected' : ''; ?>>Oi</option>
        								<option value="Nextel" <?php echo ($responsavel_adicional['telefone_operadora'] == 'Nextel') ? 'selected' : ''; ?>>Nextel</option>
        								<option value="Tim" <?php echo ($responsavel_adicional['telefone_operadora'] == 'Tim') ? 'selected' : ''; ?>>Tim</option>
        								<option value="Vivo" <?php echo ($responsavel_adicional['telefone_operadora'] == 'Vivo') ? 'selected' : ''; ?>>Vivo</option>
        							</select>
        						</div>
        					</div>
        					<div class="col-md-4">
        						<label for="responsavel2TelefoneWhatsapp" class="control-label">Whatsapp:</label>
        						<div class="form-group">
        							<input type="radio" name="responsavel2TelefoneWhatsapp" value="1" <?php echo ($responsavel_adicional['telefone_whatsapp']) ? 'checked':''; ?>/><label style="margin-left:5px;">Sim</label>
        							<input type="radio" name="responsavel2TelefoneWhatsapp" value="0" <?php echo (!$responsavel_adicional['telefone_whatsapp']) ? 'checked':''; ?>/><label style="margin-left:5px;">Não</label>
        						</div>
        					</div>
        				</div>
        				<div class="row clearfix">
        					<div class="col-md-8">
        						<label for="responsavel2Ocupacao" class="control-label">Ocupação principal:</label>
        						<div class="form-group">
        							<input type="text" name="responsavel2Ocupacao" value="<?php echo $responsavel_adicional['ocupacao']; ?>" class="form-control"/>
        						</div>
        					</div>
        				</div>
        				<div class="row clearfix">
        					<div class="col-md-8">
        						<label for="responsavel2Escolaridade" class="control-label">Escolaridade:</label>
        						<div class="form-group">
        							<select class="form-control" name="responsavel2Escolaridade">
        								<option value="">Selecione</option>
        								<option value="Analfabeto" <?php echo ($responsavel_adicional['escolaridade'] == 'Analfabeto') ? 'selected' : ''; ?>>Analfabeto</option>
        								<option value="Alfabetizado" <?php echo ($responsavel_adicional['escolaridade'] == 'Alfabetizado') ? 'selected' : ''; ?>>Alfabetizado</option>
        								<option value="1ª à 4ª serie" <?php echo ($responsavel_adicional['escolaridade'] == '1ª à 4ª serie') ? 'selected' : ''; ?>>1ª à 4ª serie</option>
        								<option value="5ª à 9ª série" <?php echo ($responsavel_adicional['escolaridade'] == '5ª à 9ª série') ? 'selected' : ''; ?>>5ª à 9ª série</option>
        								<option value="Ensino médio completo" <?php echo ($responsavel_adicional['escolaridade'] == 'Ensino médio completo') ? 'selected' : ''; ?>>Ensino médio completo</option>
        								<option value="Ensino médio incompleto" <?php echo ($responsavel_adicional['escolaridade'] == 'Ensino médio incompleto') ? 'selected' : ''; ?>>Ensino médio incompleto</option>
        								<option value="Ensino superior incompleto" <?php echo ($responsavel_adicional['escolaridade'] == 'Ensino superior incompleto') ? 'selected' : ''; ?>>Ensino superior incompleto</option>
        								<option value="Ensino superior completo" <?php echo ($responsavel_adicional['escolaridade'] == 'Ensino superior completo') ? 'selected' : ''; ?>>Ensino superior completo</option>
        							</select>
        						</div>
        					</div>
            			</div>
    				</div>
				</div>
				<div  class="panel panel-primary">
					<div class="panel-heading">Informações sócio-econômicas</div>
					<div class="panel-body">
        				<div class="row clearfix">
        					<div class="col-md-4">
        						<label for="responsavel1" class="control-label">Quem mora com a criança?</label>
        						<div class="form-group">
            						<input type="checkbox" value="mãe" name="familia[]" <?php echo (!empty($familiares) && in_array('mãe', $familiares, true)) ? ' checked' : "";?> /><label class="distancia">Mãe</label>
            					    <input type="checkbox" value="pai" name="familia[]" <?php echo (!empty($familiares) && in_array('pai', $familiares, true)) ? ' checked' : "";?>  /><label class="distancia">Pai</label>
            					    <input type="checkbox" value="irmãos" name="familia[]"  <?php echo (!empty($familiares) && in_array('irmãos', $familiares, true)) ? ' checked' : "";?> /><label class="distancia">Irmãos</label>
            					    <input type="checkbox" value="tio" name="familia[]"  <?php echo (!empty($familiares) && in_array('tio', $familiares, true)) ? ' checked' : "";?> /><label class="distancia">Tio</label>
            					    <input type="checkbox" value="tia" name="familia[]"  <?php echo (!empty($familiares) && in_array('tia', $familiares, true)) ? ' checked' : "";?> /><label class="distancia">Tia</label>
            					    <input type="checkbox" value="primos" name="familia[]"  <?php echo (!empty($familiares) && in_array('primos', $familiares, true)) ? ' checked' : "";?> /><label class="distancia">Primos</label>
            					    <input type="checkbox" value="avô" name="familia[]"  <?php echo (!empty($familiares) && in_array('avô', $familiares, true)) ? ' checked' : "";?> /><label class="distancia">Avô</label>
            					    <input type="checkbox" value="avó" name="familia[]"  <?php echo (!empty($familiares) && in_array('avó', $familiares, true)) ? ' checked' : "";?> /><label class="distancia">Avó</label>
        						</div>
        					</div>
        					<div class="col-md-4">
        						<label for="responsavel2" class="control-label">Pais separados?</label>
        						<div class="form-group">
        							<input type="radio" name="paisSeparados" value="1" <?php echo ($beneficiado['pais_separados']) ? 'checked':''; ?>/>Sim
        							<input type="radio" name="paisSeparados" value="0" <?php echo (!$beneficiado['pais_separados']) ? 'checked':''; ?>/>Não
        						</div>
        					</div>
        				</div>
        				<div class="row clearfix">
        					<div class="col-md-8">
        						<label for="responsavel1" class="control-label">Renda familiar:</label>
        						<div class="form-group">
            						<input type="radio" value="Até 1 salário mínimo" name="renda" <?php echo ($carta_pedido['renda_familiar'] == 'Até 1 salário mínimo') ? ' checked' : "";?> /><label class="distancia">Até 1 salário mínimo</label>
            					    <input type="radio" value="Até 2 salários mínimos" name="renda" <?php echo ($carta_pedido['renda_familiar'] == 'Até 2 salários mínimos') ? ' checked' : "";?>  /><label class="distancia">Até 2 salários mínimos</label>
            					    <input type="radio" value="Mais de 3 salários mínimos" name="renda"  <?php echo ($carta_pedido['renda_familiar'] == 'Mais de 3 salários mínimos') ? ' checked' : "";?> /><label class="distancia">Mais de 3 salários mínimos</label>
        						</div>
        					</div>
        				</div>
        				<div class="row clearfix">
        					<div class="col-md-8">
        						<label for="responsavel1" class="control-label">Casa:</label>
        						<div class="form-group">
            						<input type="radio" value="Própria" name="moradia" <?php echo ($carta_pedido['moradia'] == 'Própria') ? ' checked' : "";?> /><label class="distancia">Própria</label>
            					    <input type="radio" value="Alugada" name="moradia" <?php echo ($carta_pedido['moradia'] == 'Alugada') ? ' checked' : "";?>  /><label class="distancia">Alugada</label>
            					    <input type="radio" value="Cedida" name="moradia"  <?php echo ($carta_pedido['moradia'] == 'Cedida') ? ' checked' : "";?> /><label class="distancia">Cedida</label>
        						</div>
        					</div>
        				</div>
        			</div>
        		</div>
        		<div  class="panel panel-primary">
					<div class="panel-heading">Programação</div>
					<div class="panel-body">
        				<div class="row clearfix">
        					<div class="col-md-8">
        						<label for="responsavel1" class="control-label">Selecione até 3 programações (mínimo 1 obrigatoriamente)</label>
        						<div class="form-group">
        							<div>
            							<input type="checkbox" value="Valorização da Educação" name="programacao[]" <?php echo (!empty($programacoes) && in_array('Valorização da Educação', $programacoes, true)) ? ' checked' : "";?> /><label class="distancia">Valorização da Educação</label>
            						</div>
            						<div>
            					    	<input type="checkbox" value="Financiamento de Imóveis" name="programacao[]" <?php echo (!empty($programacoes) && in_array('Financiamento de Imóveis', $programacoes, true)) ? ' checked' : "";?>  /><label class="distancia">Financiamento de Imóveis</label>
            					    </div>
            					    <div>
            					    	<input type="checkbox" value="Educação Financeira" name="programacao[]"  <?php echo (!empty($programacoes) && in_array('Educação Financeira', $programacoes, true)) ? ' checked' : "";?> /><label class="distancia">Educação Financeira</label>
            					    </div>
            					    <div>
            					    	<input type="checkbox" value="Saúde Mental" name="programacao[]"  <?php echo (!empty($programacoes) && in_array('Saúde Mental', $programacoes, true)) ? ' checked' : "";?> /><label class="distancia">Saúde Mental</label>
            					    </div>
            					    <div>
            					    	<input type="checkbox" value="Saúde Bucal" name="programacao[]"  <?php echo (!empty($programacoes) && in_array('Saúde Bucal', $programacoes, true)) ? ' checked' : "";?> /><label class="distancia">Saúde Bucal</label>
            					    </div>
            					    <div>
            					    	<input type="checkbox" value="Saúde e bem-estar" name="programacao[]"  <?php echo (!empty($programacoes) && in_array('Saúde e bem-estar', $programacoes, true)) ? ' checked' : "";?> /><label class="distancia">Saúde e bem-estar</label>
            					    </div>
            					    <div>
            					    	<input type="checkbox" value="Alcoólicos Anônimos" name="programacao[]"  <?php echo (!empty($programacoes) && in_array('Alcoólicos Anônimos', $programacoes, true)) ? ' checked' : "";?> /><label class="distancia">Alcoólicos Anônimos</label>
            					    </div>
            					    <div>
            					    	<input type="checkbox" value="Narcóticos Anônimos" name="programacao[]"  <?php echo (!empty($programacoes) && in_array('Narcóticos Anônimos', $programacoes, true)) ? ' checked' : "";?> /><label class="distancia">Narcóticos Anônimos</label>
            					    </div>
            					    <div>
            					    	<input type="checkbox" value="Outros" name="programacao[]"  <?php echo (!empty($programacoes) && in_array('Outros', $programacoes, true)) ? ' checked' : "";?> /><label class="distancia">Outros</label>
            					    </div>
        						</div>
        					</div>
        				</div>
        			</div>
        		</div>
			</div>		
			<div class="box-footer">
            	<button type="submit" class="btn btn-success">
					<i class="fa fa-check"></i> Salvar
				</button>			
			</div>	
			<?php echo form_close(); ?>
		</div>
    </div>
</div>
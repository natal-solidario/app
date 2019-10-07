<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title">Responsavel Edit</h3>
            </div>
			<?php echo form_open('responsavel/edit/'.$responsavel['id']); ?>
			<div class="box-body">
				<div class="row clearfix">
					<!--<div class="col-md-6">
						<div class="form-group">
							<input type="checkbox" name="removido" value="1" <?php echo ($responsavel['removido']==1 ? 'checked="checked"' : ''); ?> id='removido' />
							<label for="removido" class="control-label">Removido</label>
						</div>
					</div>-->
					<div class="col-md-6">
						<label for="documento_tipo" class="control-label">Documento Tipo</label>
						<div class="form-group">
							<select name="documento_tipo" class="form-control">
								<option value="">Selecione</option>
								<?php 
								$documento_tipo_values = array(
									'CPF'=>'CPF',
									'RG'=>'RG',
									'CNH'=>'CNH',
									'Outro'=>'Outro',
								);

								foreach($documento_tipo_values as $value => $display_text)
								{
									$selected = ($value == $responsavel['documento_tipo']) ? ' selected="selected"' : "";

									echo '<option value="'.$value.'" '.$selected.'>'.$display_text.'</option>';
								} 
								?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<label for="data_cadastro" class="control-label"><span class="text-danger">*</span>Data Cadastro</label>
						<div class="form-group">
							<input type="text" name="data_cadastro" value="<?php echo ($this->input->post('data_cadastro') ? $this->input->post('data_cadastro') : $responsavel['data_cadastro']); ?>" class="has-datetimepicker form-control" id="data_cadastro" />
							<span class="text-danger"><?php echo form_error('data_cadastro');?></span>
						</div>
					</div>
					<div class="col-md-6">
						<label for="nome" class="control-label"><span class="text-danger">*</span>Nome</label>
						<div class="form-group">
							<input type="text" name="nome" value="<?php echo ($this->input->post('nome') ? $this->input->post('nome') : $responsavel['nome']); ?>" class="form-control" id="nome" />
							<span class="text-danger"><?php echo form_error('nome');?></span>
						</div>
					</div>
					<div class="col-md-6">
						<label for="data_nascimento" class="control-label"><span class="text-danger">*</span>Data Nascimento</label>
						<div class="form-group">
							<input type="text" name="data_nascimento" value="<?php echo ($this->input->post('data_nascimento') ? $this->input->post('data_nascimento') : $responsavel['data_nascimento']); ?>" class="has-datepicker form-control" id="data_nascimento" />
							<span class="text-danger"><?php echo form_error('data_nascimento');?></span>
						</div>
					</div>
					<div class="col-md-6">
						<label for="endereco" class="control-label"><span class="text-danger">*</span>Endereco</label>
						<div class="form-group">
							<input type="text" name="endereco" value="<?php echo ($this->input->post('endereco') ? $this->input->post('endereco') : $responsavel['endereco']); ?>" class="form-control" id="endereco" />
							<span class="text-danger"><?php echo form_error('endereco');?></span>
						</div>
					</div>
					<div class="col-md-6">
						<label for="cidade" class="control-label"><span class="text-danger">*</span>Cidade</label>
						<div class="form-group">
							<input type="text" name="cidade" value="<?php echo ($this->input->post('cidade') ? $this->input->post('cidade') : $responsavel['cidade']); ?>" class="form-control" id="cidade" />
							<span class="text-danger"><?php echo form_error('cidade');?></span>
						</div>
					</div>
					<div class="col-md-6">
						<label for="uf" class="control-label"><span class="text-danger">*</span>Uf</label>
						<div class="form-group">
							<input type="text" name="uf" value="<?php echo ($this->input->post('uf') ? $this->input->post('uf') : $responsavel['uf']); ?>" class="form-control" id="uf" />
							<span class="text-danger"><?php echo form_error('uf');?></span>
						</div>
					</div>
					<div class="col-md-6">
						<label for="cep" class="control-label">Cep</label>
						<div class="form-group">
							<input type="text" name="cep" value="<?php echo ($this->input->post('cep') ? $this->input->post('cep') : $responsavel['cep']); ?>" class="form-control" id="cep" />
							<span class="text-danger"><?php echo form_error('cep');?></span>
						</div>
					</div>
				</div>
			</div>
			<div class="box-footer">
            	<button type="submit" class="btn btn-success">
					<i class="fa fa-check"></i> Save
				</button>
	        </div>				
			<?php echo form_close(); ?>
		</div>
    </div>
</div>
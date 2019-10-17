<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title">Editar Beneficiado</h3>
            </div>
			<?php echo form_open('beneficiado/edit/'.$beneficiado['id']); ?>
			<div class="box-body">
				<div class="row clearfix">
					<div class="col-md-4">
						<label for="nome" class="control-label"><span class="text-danger">*</span>Nome</label>
						<div class="form-group">
							<input type="text" name="nome" value="<?php echo ($this->input->post('nome') ? $this->input->post('nome') : $beneficiado['nome']); ?>" class="form-control" id="nome" />
							<span class="text-danger"><?php echo form_error('nome');?></span>
						</div>
					</div>
					<div class="col-md-2">
						<label for="data_nascimento" class="control-label"><span class="text-danger">*</span>Data Nascimento</label>
						<div class="form-group">
							<input type="text" name="data_nascimento" value="<?php echo ($this->input->post('data_nascimento') ? $this->input->post('data_nascimento') : date('d/m/Y', strtotime($beneficiado['data_nascimento']))); ?>" class="has-datepicker form-control" id="data_nascimento" />
							<span class="text-danger"><?php echo form_error('data_nascimento');?></span>
						</div>
					</div>
					<div class="col-md-3">
						<label for="responsavel" class="control-label"><span class="text-danger">*</span>Responsavel</label>
						<div class="form-group">
							<select name="responsavel" class="form-control">
								<option value=""></option>
								<?php
								foreach($all_responsaveis as $responsavel)
								{
									$selected = ($responsavel['id'] == $beneficiado['responsavel']) ? ' selected="selected"' : "";

									echo '<option value="'.$responsavel['id'].'" '.$selected.'>'.$responsavel['nome'].'</option>';
								} 
								?>
							</select>
							<span class="text-danger"><?php echo form_error('responsavel');?></span>
						</div>
					</div>
                    <div class="col-md-3">
                        <label for="sexo" class="control-label"><span class="text-danger">*</span>Sexo</label>
                        <div class="form-group">
                            <select name="sexo" class="form-control">
                                <option value=""></option>
                                <option value="F"<?php echo ($beneficiado['sexo'] == 'F' ? " selected" : ""); ?>>Feminino</option>
                                <option value="M"<?php echo ($beneficiado['sexo'] == 'M' ? " selected" : ""); ?>>Masculino</option>
                            </select>
                            <span class="text-danger"><?php echo form_error('sexo'); ?></span>
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
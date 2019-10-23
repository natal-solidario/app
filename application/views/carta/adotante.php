<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title">Cadastrar adotante</h3>
            </div>
            <?php echo form_open('carta/adotante/'.$carta_pedido['id']); ?>
          	<div class="box-body">
          		<div  class="panel panel-primary">
					<div class="panel-heading">Carta</div>
					<div class="panel-body">
                  		<div class="row clearfix">
        					<div class="col-md-2">
        						<label for="numero" class="control-label">Carta</label>
        						<div class="form-group">
        							<input disabled type="text" name="numero" value="<?php echo $carta_pedido['numero']; ?>" class="form-control" id="numero" />
        							<input type="hidden" name="acao" value="save" id="acao" />
        						</div>
        					</div>
        				</div>
        				<div class="row clearfix">
        					<div class="col-md-6">
        						<label for="numero" class="control-label">Beneficiado</label>
        						<div class="form-group">
        							<input disabled type="text" name="beneficiado" value="<?php echo $beneficiado['nome']; ?>" class="form-control" id="beneficiado" />
        						</div>
        					</div>
        				</div>
        			</div>
        		</div>
        		<div  class="panel panel-primary">
					<div class="panel-heading">Adotante</div>
					<div class="panel-body">
        				<div class="row clearfix">
        					<div class="col-md-4">
        						<label for="numero" class="control-label"><span class="text-danger">*</span>Nome</label>
        						<div class="form-group">
        							<input type="text" name="nome" value="<?php echo $adotante['nome']; ?>" class="form-control" id="nome" />
            						<span class="text-danger"><?php echo form_error('nome');?></span>
        						</div>
        					</div>
        					<div class="col-md-4">
        						<label for="numero" class="control-label"><span class="text-danger">*</span>Celular</label>
        						<div class="form-group">
        							<input type="text" name="celular" value="<?php echo $adotante['telefone']; ?>" class="phones form-control" id="celular" />
            						<span class="text-danger"><?php echo form_error('celular');?></span>
        						</div>
        					</div>        					
        				</div>
        				<div class="row clearfix">
        					<div class="col-md-6">
        						<label for="numero" class="control-label"><span class="text-danger">*</span>E-mail pessoal (não utilize o profissional)</label>
        						<div class="form-group">
        							<input type="text" name="email" value="<?php echo $adotante['email']; ?>" class="form-control" id="email" />
        							<span class="text-danger"><?php echo form_error('email');?></span>
        						</div>
        					</div>
        				</div>
        				<div class="row clearfix">
        					<div class="col-md-4">
        						<label for="numero" class="control-label">Local de trabalho</label>
        						<div class="form-group">
        							<input type="text" name="local_trabalho" value="<?php echo $adotante['local_trabalho']; ?>" class="form-control" id="localtrabalho" />
        							<span class="text-danger"><?php echo form_error('local_trabalho');?></span>
        						</div>
        					</div>
        					<div class="col-md-4">
        						<label for="numero" class="control-label">Telefone do trabalho</label>
        						<div class="form-group">
        							<input type="text" name="telefone_trabalho" value="<?php echo $adotante['telefone_trabalho']; ?>" class="phones form-control" id="telefone_trabalho" />
        							<span class="text-danger"><?php echo form_error('telefone_trabalho');?></span>
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
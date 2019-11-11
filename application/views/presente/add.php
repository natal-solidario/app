<div class="box-header with-border">
    <h3 class="box-title">Cadastro de presentes</h3>
</div>
<div class="row">
	<?php echo form_open('presente/add/'.$cartaSelecionada['id'], array('method'=>'post','id'=>'myform')); ?>
    <div class="col-md-12">
        <div class="box">
        	<div class="panel panel-primary">
            	<div class="panel-heading">Beneficiado</div>
           	</div>
           	<table class="table">
           		<tr>
           			<td style="width:80%">Nome: <span style="font-weight:bold;"><?php echo $cartaSelecionada['beneficiado_nome']; ?></span></td>
           			<td style="width:20%">Idade: <span style="font-weight:bold;"><?php echo ($idade == 0) ? "Menos de 1 ano" : (($idade == 1) ? '1 ano' : $idade . ' anos'); ?></span></td>
           		</tr>
           	</table>
        </div>
        <div class="box">
            <div class="panel panel-primary">
            	<div class="panel-heading">Informações do presente</div>
				<div class="panel-body">
					<div class="row clearfix">
                    	<div class="col-md-4">
                        	<label>* Qual o brinquedo que a criança irá receber?</label>
                            <input type="text" name="descricaoBrinquedo" value="<?php echo $descricaoPresente;?>" class="form-control"
                            	<?php echo ($situacao == 1) ? '' : 'disabled';?> />
            			</div>
            			<div class="col-md-4">
                        	<label>* Classificação do brinquedo</label>
                            <select name="classificacaoBrinquedo" class="form-control"
                            	<?php echo ($situacao == 1) ? '' : 'disabled';?>>
								<option value="">selecione</option>
								<?php 
								    foreach($brinquedo_classificacoes as $classificacao) {
								        $selected = ($classificacaoBrinquedo == $classificacao['id']) ? ' selected="selected"' : "";

										echo '<option value="'.$classificacao['id'].'" '.$selected.'>'.$classificacao['nome'].'</option>';
									} 
								?>
							</select>
            			</div>
            			<div class="col-md-4">
							<label>Valor do brinquedo (opcional) </label>
							
							<?php
							$faixas_valor = array(
								'Até 50,00',
								'51,00 a 100,00',
								'101,00 a 200,00',
								'201,00 a 300,00',
								'301,00 a 400,00',
								'401,00 a 500,00',
								'501,00 a 800,00',
								'801,00 a 1.000,00',
								'Acima de 1.000,00'
							);
							?>
							
                            <select name="valorBrinquedo" class="form-control"
                            	<?php echo ($situacao == 1) ? '' : 'disabled';?>>
								<option value="">Selecione</option>
								<?php 
								    foreach($faixas_valor as $valor) {
								        $selected = ($classificacaoBrinquedo == $classificacao['id']) ? ' selected="selected"' : "";

										echo '<option value="'.$classificacao['id'].'" '.$selected.'>'.$classificacao['nome'].'</option>';
									} 
								?>
							</select>

                            <input type="text" name="valorBrinquedo" value="<?php echo $valorBrinquedo;?>" class="form-control money"
                            	<?php echo ($situacao == 1) ? '' : 'disabled';?> />
                            <span style="font-style: italic;font-weight:bold;">* O valor do brinquedo é importante para os devidos cuidados com o seu armazenamento.</span>
            			</div>
            		</div>
				</div>
				
				<div class="panel-footer">
                	<button type="submit" class="btn btn-success" 
                            	<?php echo ($situacao == 1) ? '' : 'disabled';?>>
                		<i class="fa fa-check"></i> Salvar
                	</button>
				</div>
            </div>
		</div>
		<div class="box">
            <div class="panel panel-primary">
            	<div class="panel-heading">Orientações para embrulhar o presente</div>
				<div class="panel-body"><h4>A etiqueta será preenchida com as seguintes informações:</h4></div>
				<table class="table">
            		<tr>
            			<td style="width:20%">Número da carta</td> 
            			<td><?php echo $cartaSelecionada['numero'];?></td>
            		</tr>
            		<tr>
            			<td>Nome do responsável</td>
            			<td><?php echo $cartaSelecionada['responsavel_nome']; ?></td>
            		</tr>
            		<tr>
                        <td>Nome da criança</td>
                        <td><?php echo $cartaSelecionada['beneficiado_nome']; ?></td>
                    </tr>
				</table>
				<div class="panel-body">
					<h4>Após a impressão, favor colar a etiqueta preferencialmente em <b>dois lugares</b> de forma que fique <b>bem fixado</b> e <b>visível</b>.</h4>
				</div>
				<div class="panel-footer"><a href="<?php echo site_url('presente/gerarEtiqueta/'.$cartaSelecionada['numero']."/". $cartaSelecionada['responsavel_nome'] . "/" . $cartaSelecionada['beneficiado_nome']); ?>" class="btn btn-success" target="_blank">Visualizar etiqueta</a></div>
			</div>
		</div>
		<div class="box">
    		<?php 
    		foreach($locais_entrega as $local_entrega) {
		    ?>		
            <div class="panel <?php echo (strtotime(date('Y/m/d')) > strtotime($local_entrega['termino'])) ? 'panel-warning' : 'panel-primary';?>">
            	<div class="panel-heading">Local de entrega do presente para armazenamento <?php echo (strtotime(date('Y/m/d')) > strtotime($local_entrega['termino'])) ? ' - Prazo encerrado' : '';?></div>
            	<table class="table">
            		<tr>
            			<th style="width:20%;">Período</th>
            			<th>Nome</th>
            		</tr>
            		<tr>
            			<td><?php echo date("d/m/Y", strtotime($local_entrega['inicio']));?> - <?php echo date("d/m/Y", strtotime($local_entrega['termino']));?></td>
            			<td>
            				<?php echo $local_entrega['nomeLocalEntrega']?>
            				<?php echo ($local_entrega['entregaFamiliasLocalEntrega']) ? ' - <span style="color:red;font-weight:bold;">Local de entrega para as famílias</span>' : ''?>
            			</td> 
            		</tr>
            	</table>
            	<div class="panel-body">
            		<iframe src='<?php echo $local_entrega['mapsLocalEntrega'];?>' width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
            	</div>
            </div>
            <?php } ?>
       </div>
       <div class="box">
       		<div class="panel panel-primary">
            	<div class="panel-heading">Local de entrega para as famílias</div>
            	<table class="table">
            		<tr>
            			<th style="width:20%;">Dia</th>
            			<th>Nome</th>
            		</tr>
            		<tr>
            			<td><?php echo date("d/m/Y", strtotime($local_entrega_familia['inicio']));?></td>
            			<td><?php echo $local_entrega_familia['nomeLocalEntrega']?></td> 
            		</tr>
            	</table>
            	<?php 
            	if ($situacao == 1 && (strtotime(date('Y/m/d')) == strtotime($local_entrega_familia['termino']))) {
            	?>
            	<div class="panel-body">
            		<h4 style="color:red">O presente ainda não foi entregue. Se desejar entregar durante o evento para as famílias. Comunique os responsáveis pela organização na opção abaixo:</h4>
            		<div><button class="btn btn-danger">Avisar organização</button></div>
            	</div>
            	<?php } ?>
            	<div class="panel-body">
            		<iframe src='<?php echo $local_entrega_familia['mapsLocalEntrega'];?>' width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
            	</div>
            </div>
       </div>
    </div>
    <input type="hidden" value="<?php echo $origem; ?>" id="hdnOrigem" />
    <?php echo form_close(); ?>
</div>
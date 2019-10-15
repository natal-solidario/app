<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
            	<?php 
            	   $grupos_usuario = $this->session->userdata('grupos_usuario');
            	
            	   if($this->session->userdata('grupos_usuario'))
            	       if (in_array("admin", $grupos_usuario, true)):
            	?>
                <div  class="panel panel-primary">
					<div class="panel-heading">Total de cartas</div>
                    <table class="table">
                    	<thead>
                            <tr>
                              <th scope="col">Total</th>
                              <th scope="col"><?php echo $total_cartas;?></th>
                            </tr>
                      	</thead>
                    </table>
                </div>
                <div  class="panel panel-primary">
					<div class="panel-heading">Total de responsáveis por região</div>
                    <table class="table">
                    	<thead>
                            <tr>
                              <th scope="col">Região administrativa</th>
                              <th scope="col">Total</th>
                            </tr>
                      	</thead>
                      	<tbody>
                      		<?php 
                      		foreach($total_responsaveis as $item) {
                      		    echo '<tr><td>'.$item['regiao_administrativa'].'</td><td>'.$item['total'].'</tr>';
                            } 
                            ?>
    					</tbody>
    					<tfoot>
    						<tr>
    							<th>Total</th>
    							<th><?php echo $total_responsaveis_somatorio;?></th>
    						</tr>
    					</tfoot>
    				</table>
    			</div>
				<div  class="panel panel-primary">
					<div class="panel-heading">Total de cartas por carteiro</div>
                    <table class="table">
                    	<thead>
                            <tr>
                              <th scope="col">Carteiro</th>
                              <th scope="col">Total</th>
                            </tr>
                      	</thead>
                      	<tbody>
                      		<?php 
                      		foreach($total_por_carteiro as $item) {
                      		    echo '<tr><td>'.$item['nome'].'</td><td>'.$item['total'].'</tr>';
                            } 
                            ?>
    					</tbody>
    					<tfoot>
    						<tr>
    							<th>Total</th>
    							<th><?php echo $total_por_carteiro_somatorio;?></th>
    						</tr>
    					</tfoot>
    				</table>
    			</div>
				<div  class="panel panel-primary">
					<div class="panel-heading">Total de cartas por mobilizador</div>
                    <table class="table">
                    	<thead>
                            <tr>
                              <th scope="col">Mobilizador</th>
                              <th scope="col">Total</th>
                            </tr>
                      	</thead>
                      	<tbody>
                      		<?php 
                      		foreach($total_por_mobilizador as $item) {
                      		    echo '<tr><td>'.$item['nome'].'</td><td>'.$item['total'].'</tr>';
                            } 
                            ?>
    					</tbody>
    					<tfoot>
    						<tr>
    							<th>Total</th>
    							<th><?php echo $total_por_mobilizador_somatorio;?></th>
    						</tr>
    					</tfoot>
    				</table>
    			</div>
    			<div  class="panel panel-primary">
					<div class="panel-heading">Total de cartas adotadas por região</div>
                    <table class="table">
                    	<thead>
                            <tr>
                              <th scope="col">Região administrativa</th>
                              <th scope="col">Total</th>
                            </tr>
                      	</thead>
                      	<tbody>
                      		<?php 
                      		foreach($total_cartas_adotadas as $item) {
                      		    echo '<tr><td>'.$item['nome'].'</td><td>'.$item['total'].'</tr>';
                            } 
                            ?>
    					</tbody>
    					<tfoot>
    						<tr>
    							<th>Total</th>
    							<th><?php echo $total_cartas_adotadas_somatorio;?></th>
    						</tr>
    					</tfoot>
    				</table>
    			</div>
    			<div  class="panel panel-primary">
					<div class="panel-heading">Total de cartas aguardando adoção por região</div>
                    <table class="table">
                    	<thead>
                            <tr>
                              <th scope="col">Região administrativa</th>
                              <th scope="col">Total</th>
                            </tr>
                      	</thead>
                      	<tbody>
                      		<?php 
                      		foreach($total_cartas_aguardando_adocao as $item) {
                      		    echo '<tr><td>'.$item['nome'].'</td><td>'.$item['total'].'</tr>';
                            } 
                            ?>
    					</tbody>
    					<tfoot>
    						<tr>
    							<th>Total</th>
    							<th><?php echo $total_cartas_aguardando_adocao_somatorio;?></th>
    						</tr>
    					</tfoot>
    				</table>
    			</div>
    			<?php endif; ?>
            </div>
        </div>
    </div>
</div>
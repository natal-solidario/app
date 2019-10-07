<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Instituições</h3>
            	<div class="box-tools">
                    <a href="<?php echo site_url('instituicao/add'); ?>" class="btn btn-success btn-sm">Novo</a> 
                </div>
            </div>
            <div class="box-body">
                <table class="table table-striped">
                    <tr>
                        <th>CNPJ</th>
						<th>Nome</th>
						<th>Cidade</th>
						<th>UF</th>
						<th>Região Administrativa</th>
                        <th>Telefone</th>
						<th>Ações</th>
                    </tr>
                    <?php foreach($instituicoes as $i) { ?>
                    <tr>
                        <td><?php echo preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "$1.$2.$3/$4-$5", substr("00000000000000".$i['NU_CNPJ'], -14)); ?></td>
						<td><?php echo $i['NO_INSTITUICAO']; ?></td>
						<td><?php echo $i['NO_CIDADE']; ?></td>
						<td><?php echo $i['SG_UF']; ?></td>
						<td><?php echo $i['regiao_administrativa_nome']; ?></td>
						<td>(<?php echo $i['NU_DDD_TELEFONE']; ?>) <?php echo preg_replace("/(\d{4,5})(\d{4})/", "$1-$2", $i['NU_TELEFONE']); ?></td>
						<td>
                            <a href="<?php echo site_url('instituicao/edit/'.$i['NU_TBP01']); ?>" class="btn btn-info btn-xs"><span class="fa fa-pencil"></span> Editar</a>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Usuários</h3>
            	<div class="box-tools">
                    <a href="<?php echo site_url('usuario/add'); ?>" class="btn btn-success btn-sm">Novo</a> 
                </div>
            </div>
            <div class="box-body">
                <table class="table table-striped">
                    <tr>
						
						<th>Nome</th>
						<th>E-mail</th>
						<th>Área Abrangência</th>
						<th>Referência</th>
						<th>Telefone</th>
						<th>Ações</th>
                    </tr>
                    <?php foreach($usuarios as $u){ ?>
                    <tr>
						<td><?php echo mb_strtoupper($u['first_name']); ?></td>
						<td><?php echo mb_strtolower($u['email']); ?></td>
						<td><?php echo mb_strtoupper($u['area_abrangencia']); ?></td>
						<td><?php echo mb_strtoupper($u['referencia']); ?></td>
						<td><?php echo $u['phone']; ?></td>
						<td>
                            <a href="<?php echo site_url('usuario/edit/'.$u['id']); ?>" class="btn btn-info btn-xs"><span class="fa fa-pencil"></span> Editar</a>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
                                
            </div>
        </div>
    </div>
</div>

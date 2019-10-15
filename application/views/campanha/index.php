<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Campanhas</h3>
                <div class="box-tools">
                    <a href="<?php echo site_url('campanha/add'); ?>" class="btn btn-success btn-sm">Adicionar Nova</a>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-striped">
                    <tr>
                        <th width="15%">Ano</th>
                        <th>Nome</th>
                        <th width="15%">Ações</th>
                    </tr>
                    <?php foreach($campanhas as $c) { ?>
                    <tr>
                        <td><?php echo $c->AA_CAMPANHA; ?></td>
                        <td><?php echo $c->NO_CAMPANHA; ?></td>
                        <td>
                            <a href="<?php echo site_url('campanha/edit/'.$c->NU_TBC01); ?>"
                                class="btn btn-info btn-xs"><span class="fa fa-pencil"></span> Editar</a>
                            <a href="<?php echo site_url('campanha/instituicoes/'.$c->NU_TBC01); ?>"
                                class="btn btn-success btn-xs" style="margin-right:10px;"><span
                                    class="fa fa-bank"></span> Instituições</a>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>
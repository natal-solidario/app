<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Relação de Instituições</h3>
            </div>
            <div class="box-body">

                <div class="row clearfix">
                    <div class="col-md-8">
                        <label for="NO_CAMPANHA" class="control-label">Nome da
                            Campanha</label>
                        <div class="form-group">
                            <p class="form-control-static"><?php echo $campanha->NO_CAMPANHA; ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="AA_CAMPANHA" class="control-label">Ano da Campanha</label>
                        <div class="form-group">
                            <p class="form-control-static"><?php echo $campanha->AA_CAMPANHA; ?></p>
                        </div>
                    </div>
                    <?php if (sizeof($select_instituicoes) > 0) { ?>
                    <div class="col-md-6">

                        <label for="AA_CAMPANHA" class="control-label">Instituição</label>
                        <div class="form-group">
                            <select class="form-control" id="select-instituicao">
                                <option value=""></option>
                                <?php foreach ($select_instituicoes as $i) { ?>
                                <option value="<?php echo $campanha_id . "-" . $i['NU_TBP01']; ?>">
                                    <?php echo preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "$1.$2.$3/$4-$5", substr("00000000000000".$i['NU_CNPJ'], -14)) . " - " . $i['NO_INSTITUICAO']; ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>

                    </div>
                    
                    <div class="col-md-6">

                        <label for="AA_CAMPANHA" class="control-label">&nbsp;</label>
                        <div class="form-group">
                            <a src="" class="btn btn-success btn-sm" id="add-instituicao"><i class="fa fa-plus"></i></a>
                        </div>

                    </div>
                                <?php } ?>
                </div>

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
                    <?php if (sizeof($instituicoes) == 0) { ?>
                    <tr>
                        <td colspan="3">Ainda não existe instituição vinculada à essa campanha!</td>
                    </tr>
                    <?php } ?>
                    <?php foreach($instituicoes as $i) { ?>
                    <tr>
                        <td><?php echo preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "$1.$2.$3/$4-$5", substr("00000000000000".$i['NU_CNPJ'], -14)); ?>
                        </td>
                        <td><?php echo $i['NO_INSTITUICAO']; ?></td>
                        <td><?php echo $i['NO_CIDADE']; ?></td>
                        <td><?php echo $i['SG_UF']; ?></td>
                        <td><?php echo $i['regiao_administrativa_nome']; ?></td>
                            <td><?php echo ($i['NU_DDD'] != 0 && $i['NU_TELEFONE'] != 0 ? "(" . $i['NU_DDD'] . ") " . preg_replace("/(\d{4,5})(\d{4})/", "$1-$2", $i['NU_TELEFONE']) : ""); ?></td>
                        <td>
                            <a href="<?php echo site_url('campanha/del_instituicao/' . $campanha_id . "/" . $i['NU_TBC02']); ?>"
                                class="btn btn-danger btn-xs"><span class="fa fa-trash"></span> Excluir</a>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>
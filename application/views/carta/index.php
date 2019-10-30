<?php if($this->session->flashdata('numero_carta_criada')): ?>
<div class="alert alert-success" role="alert">
    <strong>Carta <?php echo $this->session->flashdata('numero_carta_criada'); ?> inserida com sucesso!</strong>
    <!-- <?php echo $this->session->flashdata('teste'); ?> -->
    <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<?php endif; ?>

<?php
$permissoes_usuario = $this->session->userdata('permissoes_usuario');
?>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Cartas</h3>
                <div class="box-tools">
                    <a href="<?php echo site_url('carta/new'); ?>" class="btn btn-success">Incluir Carta</a>
                </div>
            </div>
            <div class="box-body">
                <?php echo form_open('carta/index', array('method'=>'get','id'=>'myform')); ?>
                <div class="panel panel-primary">
                    <div class="panel-heading">Filtrar</div>
                    <div class="panel-body">
                        <input type="hidden" id="ordem" name="ordem" value="<?php echo $ordem ? $ordem : "carta.id"; ?>"
                            class="form-control" onblur="myform.submit();" />
                        <input type="hidden" id="direcao" name="direcao"
                            value="<?php echo $direcao ? $direcao : "desc"; ?>" class="form-control"
                            onblur="myform.submit();" />
                        <div class="row clearfix">
                            <div class="col-md-4">
                                <label for="numero">Número da carta</label>
                                <input type="text" id="numero" name="numero" value="<?php echo $numero;?>" class="form-control"
                                    onblur="myform.submit();" />
                            </div>
                            <div class="col-md-4">
                                <label for="nome_crianca">Nome da criança</label>
                                <input type="text" name="nome_crianca" value="<?php echo $nome_crianca;?>"
                                    class="form-control" onblur="myform.submit();" />
                            </div>
                            <div class="col-md-4">
                                <label>Nome do responsável</label>
                                <input type="text" name="nome_responsavel" value="<?php echo $nome_responsavel;?>"
                                    class="form-control" onblur="myform.submit();" />
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-md-4">
                                <label>Carteiro</label>
                                <select name="carteiro" class="form-control" onchange="myform.submit();">
                                    <option value="">Todos</option>
                                    <?php 
                                    foreach($carteiros as $carteiro) {
                                        $selected = ($carteiro['id'] == ''.$carteiro_selecionado) ? ' selected="selected"' : '';
                                        echo '<option value="'.$carteiro['id'].'" '.$selected.'>'.$carteiro['first_name'].'</option>';
                                    } 
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Mobilizador</label>
                                <select name="mobilizador" class="form-control" onchange="myform.submit();">
                                    <option value="">Todos</option>
                                    <?php 
                                    foreach($mobilizadores as $mobilizador) {
                                        $selected = ($mobilizador['id'] == ''.$mobilizador_selecionado) ? ' selected="selected"' : '';
                                        echo '<option value="'.$mobilizador['id'].'" '.$selected.'>'.$mobilizador['first_name'].'</option>';
                                    } 
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Região administrativa </label>
                                <select name="regiao_administrativa" class="form-control" onchange="myform.submit();">
                                    <option value="">Todas</option>
                                    <?php 
                    				foreach($all_regioes as $ra) {
                    				    $selected = ($ra['id'] == ''.$regiao_administrativa) ? ' selected' : '';
                    				    echo '<option value="'.$ra['id'].'" '.$selected.'>'.$ra['nome'].'</option>';
                    				}
                    				?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Situação </label>
                                <select name="situacao" class="form-control" onchange="myform.submit();">
                                    <option value="">Todas</option>
                                    <option value="SEM_CARTEIRO_VINCULADO"
                                        <?php echo ($situacao == 'SEM_CARTEIRO_VINCULADO') ? 'selected' : '' ?>>Sem
                                        carteiro vinculado</option>
                                    <option value="SEM_MOBILIZADOR_VINCULADO"
                                        <?php echo ($situacao == 'SEM_MOBILIZADOR_VINCULADO') ? 'selected' : '' ?>>Sem
                                        mobilizador vinculado</option>
                                    <option value="AGUARDANDO_ADOCAO"
                                        <?php echo ($situacao == 'AGUARDANDO_ADOCAO') ? 'selected' : '' ?>>Aguardando
                                        adoção</option>
                                </select>
                            </div>
                            <?php $isEditable = (($isRepComu && !$isAdmin) ? false : true); ?>
                            <div class="col-md-4">
                                <label>Campanha</label>
                                <select name="campanha" class="form-control" onchange="myform.submit();"
                                    <?php echo !$isEditable ? " readonly" : ""; ?>>
                                    <option value="">Todas</option>
                                    <?php 
                    				foreach($all_campanhas as $c) {
                    				    $selected = ($c->AA_CAMPANHA == ''.$campanha) ? ' selected' : '';
                    				    echo '<option value="'.$c->AA_CAMPANHA.'" '.$selected.'>'.$c->NO_CAMPANHA.'</option>';
                    				}
                    				?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Instituição</label>
                                <select name="instituicao" class="form-control" onchange="myform.submit();"
                                    <?php echo !$isEditable ? " readonly" : ""; ?>>
                                    <option value="">Todas</option>
                                    <?php 
                    				foreach($all_instituicoes as $i) {
                    				    $selected = ($i['NU_TBP01'] == ''.$instituicao) ? ' selected' : '';
                    				    echo '<option value="'.$i['NU_TBP01'].'" '.$selected.'>'.$i['NO_INSTITUICAO'].'</option>';
                    				}
                    				?>
                                </select>
                            </div>
                            <?php
                            if (array_key_exists("permite_excluir_carta", $permissoes_usuario)) {
                            ?>
                            <div class="col-md-4">
                                <label>Status</label>
                                <select name="removida" class="form-control" onchange="myform.submit();">
                                    <option value="0"<?php echo ($removida == "0" || is_null($removida) ? " selected" : ""); ?>>Ativas</option>
                                    <option value="1"<?php echo ($removida == "1" ? " selected" : ""); ?>>Excluídas</option>
                                </select>
                            </div>
                            <?php } ?>
                            <?php
                            if (array_key_exists("acesso_admin", $permissoes_usuario)) {
                            ?>
                            <div class="col-md-4">
                                <label for="limite">Quantidade de Registros</label>
                                <select id="limite" name="limite" class="form-control" onchange="myform.submit();">
                                    <option value="50"<?php echo ($limite == "50" || is_null($limite) ? " selected" : ""); ?>>50 registros</option>
                                    <option value="100"<?php echo ($limite == "100" ? " selected" : ""); ?>>100 registros</option>
                                    <option value="150"<?php echo ($limite == "150" ? " selected" : ""); ?>>150 registros</option>
                                    <option value="200"<?php echo ($limite == "200" ? " selected" : ""); ?>>200 registros</option>
                                    <option value="250"<?php echo ($limite == "250" ? " selected" : ""); ?>>250 registros</option>
                                </select>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
                <?php
                if (array_key_exists("permite_vincular_cartas_em_lote_carteiro", $permissoes_usuario) || array_key_exists("permite_vincular_cartas_em_lote_mobilizador", $permissoes_usuario)):
                ?>
                <div class="panel panel-primary">
                    <div class="panel-heading">Ação</div>
                    <div class="panel-body">
                        <div class="row clearfix">
                            <?php
                            if (array_key_exists("permite_vincular_cartas_em_lote_carteiro", $permissoes_usuario)) {
                            ?>
                            <div class="col-md-5">
                                <label>Carteiro</label>
                                <select id="carteiro" class="form-control acoes" disabled>
                                    <option value="">Selecione</option>
                                    <?php 
                                    foreach($carteiros as $carteiro) {
                                        echo '<option value="'.$carteiro['id'].'">'.$carteiro['first_name'].'</option>';
                                    } 
                                    ?>
                                </select>
                            </div>
                            <?php } ?>
                            <?php
                            if (array_key_exists("permite_vincular_cartas_em_lote_mobilizador", $permissoes_usuario)) {
                            ?>
                            <div class="col-md-5">
                                <label>Mobilizador</label>
                                <select id="mobilizador" class="form-control acoes" disabled>
                                    <option value="">Selecione</option>
                                    <?php 
                                    foreach($mobilizadores as $mobilizador) {
                                        echo '<option value="'.$mobilizador['id'].'">'.$mobilizador['first_name'].'</option>';
                                    } 
                                    ?>
                                </select>
                            </div>
                            <?php } ?>
                            <div class="col-md-2">
                                <button class="btn btn-primary acoes" style="margin-top:25px;" id="aplicar-acao"
                                    disabled>Aplicar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php 
                endif;
                ?>
            </div>
            <div class="box-body">
                <div style="font-weight: bold;">Total de cartas encontradas: <?php echo $total_registros;?></div>
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <?php if (isset($links)) { ?>
                        <?php echo $links ?>
                        <?php } ?>
                    </ul>
                </nav>
                <table class="table table-striped">
                    <tr>
                        <th width="1%"><input type="checkbox" class="selecionar-todas" /></th>
                        <th class="ordenar" style="cursor:pointer;" data-coluna="carta.numero"
                            data-direcao="<?php echo $ordem == "carta.numero" && $direcao == "asc" ? "desc" : "asc"; ?>">
                            Número
                            <?php echo (($ordem == "carta.numero" && $direcao == "asc") ? "&uparrow;" : (($ordem == "carta.numero" && $direcao == "desc") ? "&downarrow;" : "")); ?>
                        </th>
                        <th class="ordenar" style="cursor:pointer;" data-coluna="beneficiado.nome"
                            data-direcao="<?php echo $ordem == "beneficiado.nome" && $direcao == "asc" ? "desc" : "asc"; ?>">
                            Beneficiado
                            <?php echo (($ordem == "beneficiado.nome" && $direcao == "asc") ? "&uparrow;" : (($ordem == "beneficiado.nome" && $direcao == "desc") ? "&downarrow;" : "")); ?>
                        </th>
                        <th class="ordenar" style="cursor:pointer;" data-coluna="responsavel.nome"
                            data-direcao="<?php echo $ordem == "responsavel.nome" && $direcao == "asc" ? "desc" : "asc"; ?>">
                            Responsável
                            <?php echo (($ordem == "responsavel.nome" && $direcao == "asc") ? "&uparrow;" : (($ordem == "responsavel.nome" && $direcao == "desc") ? "&downarrow;" : "")); ?>
                        </th>
                        <th class="ordenar" style="cursor:pointer;" data-coluna="adotante.nome"
                            data-direcao="<?php echo $ordem == "adotante.nome" && $direcao == "asc" ? "desc" : "asc"; ?>">
                            Adotante
                            <?php echo (($ordem == "adotante.nome" && $direcao == "asc") ? "&uparrow;" : (($ordem == "adotante.nome" && $direcao == "desc") ? "&downarrow;" : "")); ?>
                        </th>
                        <th class="ordenar" style="cursor:pointer;" data-coluna="carta.data_cadastro"
                            data-direcao="<?php echo $ordem == "carta.data_cadastro" && $direcao == "asc" ? "desc" : "asc"; ?>">
                            Data Cadastro
                            <?php echo (($ordem == "carta.data_cadastro" && $direcao == "asc") ? "&uparrow;" : (($ordem == "carta.data_cadastro" && $direcao == "desc") ? "&downarrow;" : "")); ?>
                        </th>
                        <th class="ordenar" style="cursor:pointer;" data-coluna="carta.credenciado"
                            data-direcao="<?php echo $ordem == "carta.credenciado" && $direcao == "asc" ? "desc" : "asc"; ?>">
                            Credenciado
                            <?php echo (($ordem == "carta.credenciado" && $direcao == "asc") ? "&uparrow;" : (($ordem == "carta.credenciado" && $direcao == "desc") ? "&downarrow;" : "")); ?>
                        </th>
                        <th>Ação</th>
                    </tr>
                    <?php
                    if ($cartas) {
                    foreach ($cartas as $c) {
                    ?>
                    <tr>
                        <td><input type="checkbox" class="selecao" data-carta="<?php echo $c["id"]; ?>"
                                <?php echo ($c['carteiro_associado'] && $c['mobilizador'] ? " disabled" : ""); ?> />
                        </td>
                        <td><?php echo $c['numero']; ?></td>
                        <td><?php echo $c['beneficiado_nome']; ?></td>
                        <td><?php echo $c['responsavel_nome']; ?></td>
                        <td><?php echo $c['adotante_nome']; ?></td>
                        <td><?php echo date("d/m/Y", strtotime($c['data_cadastro'])); ?></td>
                        <td><?php echo ($c['credenciado']) ? 'Sim' : 'Não'; ?></td>
                        <td>
                            <div class="btn-group btn-group-toggle" role="group" aria-label="Grupo de Ações">
                                <?php                            
                                if (array_key_exists("permite_editar_carta", $permissoes_usuario)):
                                ?>
                                <a href="<?php echo site_url('carta/edit/'.$c['id']); ?>"
                                    class="btn btn-info btn-xs"><span class="fa fa-pencil"></span> Editar</a>
                                <?php 
                                endif;
                                
                                if (array_key_exists("permite_preencher_formulario_carta", $permissoes_usuario)):
                                ?>
                                <a href="<?php echo site_url('carta/formulario/'.$c['id']); ?>"
                                    class="btn btn-success btn-xs"><span class="fa fa-pencil"></span> Formulário</a>
                                <?php 
                                endif;
                                
                                if (array_key_exists("permite_vincular_adotante", $permissoes_usuario) || $this->session->userdata('usuario_logado_id') == $c['mobilizador']):
                                ?>
                                <a href="<?php echo site_url('carta/adotante/'.$c['id']); ?>"
                                    class="btn btn-warning btn-xs"><span class="fa fa-pencil"></span> Adotante</a>
                                <?php
                                endif;
                                ?>

                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="false" aria-expanded="false">
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <?php
                                        if (array_key_exists("permite_credenciar_carta", $permissoes_usuario) && !$c['credenciado']) {
                                        ?>
                                        <li>
                                            <a href="<?php echo site_url('carta/credenciar/'.$c['id']); ?>"
                                            onclick="return confirm('Confirma o credenciamento da carta <?php echo $c['numero'] . " - " . $c['beneficiado_nome']; ?>?');"><span
                                                class="fa fa-pencil"></span> Credenciar</a>
                                        </li>
                                        <?php
                                        }
                                        ?>
                                        <?php
                                        if (array_key_exists('permite_excluir_carta', $permissoes_usuario) && $c['adotante_nome'] == '') {
                                        ?>
                                        <li>
                                            <a href="<?php echo site_url('carta/excluir/'.$c['id']); ?>"
                                            onclick="return confirm('Confirma a exclusão da carta <?php echo $c['numero'] . " - " . $c['beneficiado_nome']; ?>?');"><span
                                                class="fa fa-times"></span> Excluir</a>
                                        </li>
                                        <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php }
                    } ?>
                </table>
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <?php if (isset($links)) { ?>
                        <?php echo $links ?>
                        <?php } ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
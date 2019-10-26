<div class="row">
    <div class="col-md-12">
	    <?php echo form_open('presente/receberPresente'); ?>
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Recebimento de Presentes</h3>
            </div>
            
            <div class="box-body">
                <div class="row clearfix">
                    <div class="col-md-4">
                        <label for="numeroCarta" class="control-label"><span class="text-danger">*</span>Número da Carta</label>
                        <div class="form-group">
                            <input type="text" name="numeroCarta" value="<?php echo $this->input->post('numeroCarta'); ?>" class="form-control" id="numeroCarta" />
                            <span class="text-danger"><?php echo form_error('numeroCarta');?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-check"></i> Buscar
                </button>
            </div>
        </div>
        <?php echo form_close(); ?>
        
        <?php if(isset($dados) && !is_null($dados['idPresente'])):?>
        <?php echo form_open('presente/receberPresente/'.$dados['numeroCarta']); ?>
            
            <div class="box">
                <div class="panel panel-primary">
                    <div class="panel-heading">Atualizar dados presente</div>
                    <table class="table">
                        <tr>
                            <td style="width:20%">Situação do presente</td> 
                            <td>
                                <div class="form-group">
                                    <select name="situacao_presente" class="form-control">
                                        <option value=""></option>
                                        <?php 
                                        foreach($allSituacoesPresente as $situacao)
                                        {
                                                $selected = ($situacao['id'] == $dados['situacaoPresente']) ? ' selected="selected"' : "";

                                                echo '<option value="'.$situacao['id'].'" '.$selected.'>'.$situacao['nome'].'</option>';

                                        } 
                                        ?>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td >Local de armazenamento</td> 
                            <td>
                                <div class="form-group">
                                    <select name="local_armazenamento" class="form-control">
                                        <option value=""></option>
                                        <?php 
                                        foreach($allLocaisArmazenamento as $local)
                                        {
                                                $selected = ($local['id'] == $dados['localArmazenamentoPresente']) ? ' selected="selected"' : "";

                                                echo '<option value="'.$local['id'].'" '.$selected.'>'.$local['nome'].'</option>';

                                        } 
                                        ?>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Local de entrega do presente</td> 
                            <td>
                                <div class="form-group">
                                    <select name="local_entrega" class="form-control">
                                        <option value=""></option>
                                        <?php 
                                        foreach($allLocaisEntrega as $local)
                                        {
                                                $selected = ($local['id'] == $dados['presente_local_entrega']) ? ' selected="selected"' : "";

                                                echo '<option value="'.$local['id'].'" '.$selected.'>'.$local['nomeLocalEntrega'].'</option>';

                                        } 
                                        ?>
                                    </select>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-check"></i> Atualizar
                        </button>
                    </div>
                </div>
            </div>
            

            <div class="box">
                <div class="panel panel-primary">
                    <div class="panel-heading">Dados do Presente</div>
                    <table class="table">
                        <tr>
                            <td style="width:20%">Número da carta</td> 
                            <td><?php echo $dados['numeroCarta'];?></td>
                        </tr>
                        <tr>
                            <td>Nome do adotante</td>
                            <td><?php echo $dados['nomeAdotante']; ?></td>
                        </tr>
                        <tr>
                            <td>Nome do responsável</td>
                            <td><?php echo $dados['responsavel_nome']; ?></td>
                        </tr>
                        <tr>
                            <td>Nome da criança</td>
                            <td><?php echo $dados['beneficiado_nome']; ?></td>
                        </tr>
                        <tr>
                            <td>Local de entrega</td>
                            <td><?php echo $dados['nomeLocalEntrega'] . " <br/> Sala: " . $dados['numeroSalaEntrega']; ?></td>
                        </tr>
                    </table>
                    <div class="panel-footer"><a href="<?php echo site_url('presente/gerarEtiqueta/'.$dados['numeroCarta']."/". $dados['responsavel_nome'] . "/" . $dados['beneficiado_nome'] . "/" . $dados['nomeLocalEntrega']. "/" . $dados['numeroSalaEntrega']); ?>" class="btn btn-success" target="_blank">Visualizar etiqueta</a></div>
                </div>
            </div>
        <?php echo form_close(); ?>
        <?php endif?>
        
        <?php if(isset($dados) && is_null($dados['idPresente'])): ?>
        <?php echo form_open('presente/receberPresente'); ?>
            <?php $this->session->set_userdata('origem', 'recebimentoPresente'); ?>
            <div class="panel-footer">
                <a href="<?php echo site_url('presente/add/'.$this->session->flashdata('idCarta')); ?>" class="btn btn-success">Cadastrar Presente</a>
            </div>
	    <?php echo form_close(); ?>
        <?php endif?>
    </div>
</div>
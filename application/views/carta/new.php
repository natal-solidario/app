<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Pré-Cadastro da Carta</h3>
            </div>
            <div class="box-body">
            <?php echo form_open('carta/new', array('id'=>'form-carta')); ?>
                <h4>Responsável</h4>
                <input type="hidden" id="responsavel_id" name="responsavel_id" value="" />
                <input type="hidden" id="metodo_busca" name="metodo_busca" value="" />
                <div class="row clearfix">
                    <div class="col-md-3">
                        <label for="documento_numero" class="control-label"><span
                                class="text-danger">*</span>CPF</label>
                        <div class="form-group">
                            <input type="text" name="documento_numero"
                                value="<?php echo $this->input->post('documento_numero'); ?>" class="form-control"
                                id="documento_numero" />
                            <span class="text-danger"><?php echo form_error('documento_numero');?></span>
                            <small id="enter-cpf">Após digitar o CPF aperte a tecla ENTER</small>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <label for="nome" class="control-label"><span class="text-danger">*</span>Nome</label>
                        <div class="form-group">
                            <input type="text" name="nome" value="<?php echo $this->input->post('nome'); ?>"
                                class="form-control segunda-validacao" id="nome" />
                            <span class="text-danger"><?php echo form_error('nome');?></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label for="data_nascimento" class="control-label"><span class="text-danger">*</span>Data de
                            Nascimento</label>
                        <div class="form-group">
                            <input type="text" name="data_nascimento"
                                value="<?php echo $this->input->post('data_nascimento'); ?>"
                                class="form-control segunda-validacao" id="data_nascimento" />
                            <span class="text-danger"><?php echo form_error('data_nascimento');?></span>
                            <small id="enter-data" style="display:none;">Após digitar os dados aperte ENTER</small>
                        </div>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-md-2">
                        <label for="cep" class="control-label">CEP</label>
                        <div class="form-group">
                            <input type="text" name="cep" value="<?php echo $this->input->post('cep'); ?>"
                                class="form-control demais-campos" id="cep" />
                            <span class="text-danger"><?php echo form_error('cep');?></span>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <label for="endereco" class="control-label"><span class="text-danger">*</span>Logradouro</label>
                        <div class="form-group">
                            <input type="text" name="endereco" value="<?php echo $this->input->post('endereco'); ?>"
                                class="form-control demais-campos" id="endereco" />
                            <span class="text-danger"><?php echo form_error('endereco');?></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label for="numero" class="control-label">Número</label>
                        <div class="form-group">
                            <input type="text" name="numero" value="<?php echo $this->input->post('numero'); ?>"
                                class="form-control demais-campos" id="numero" />
                            <span class="text-danger"><?php echo form_error('numero');?></span>
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-md-3">
                        <label for="complemento" class="control-label">Complemento</label>
                        <div class="form-group">
                            <input type="text" name="complemento"
                                value="<?php echo $this->input->post('complemento'); ?>"
                                class="form-control demais-campos" id="complemento" />
                            <span class="text-danger"><?php echo form_error('complemento');?></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="bairro" class="control-label"><span class="text-danger">*</span>Bairro</label>
                        <div class="form-group">
                            <input type="text" name="bairro" value="<?php echo $this->input->post('bairro'); ?>"
                                class="form-control demais-campos" id="bairro" />
                            <span class="text-danger"><?php echo form_error('bairro');?></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="cidade" class="control-label"><span class="text-danger">*</span>Cidade</label>
                        <div class="form-group">
                            <input type="text" name="cidade" value="<?php echo $this->input->post('cidade'); ?>"
                                class="form-control demais-campos" id="cidade" />
                            <span class="text-danger"><?php echo form_error('cidade');?></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="uf" class="control-label"><span class="text-danger">*</span>UF</label>
                        <div class="form-group">
                            <select name="uf" class="form-control demais-campos" id="uf" required>
                                <option value="">Selecione</option>
                                <option value="AC" <?php echo ($this->input->post('uf') == "AC" ? " selected" : ""); ?>>
                                    Acre</option>
                                <option value="AL" <?php echo ($this->input->post('uf') == "AL" ? " selected" : ""); ?>>
                                    Alagoas</option>
                                <option value="AP" <?php echo ($this->input->post('uf') == "AP" ? " selected" : ""); ?>>
                                    Amapá</option>
                                <option value="AM" <?php echo ($this->input->post('uf') == "AM" ? " selected" : ""); ?>>
                                    Amazonas</option>
                                <option value="BA" <?php echo ($this->input->post('uf') == "BA" ? " selected" : ""); ?>>
                                    Bahia</option>
                                <option value="CE" <?php echo ($this->input->post('uf') == "CE" ? " selected" : ""); ?>>
                                    Ceará</option>
                                <option value="DF" <?php echo ($this->input->post('uf') == "DF" ? " selected" : ""); ?>>
                                    Distrito Federal</option>
                                <option value="ES" <?php echo ($this->input->post('uf') == "ES" ? " selected" : ""); ?>>
                                    Espírito Santo</option>
                                <option value="GO" <?php echo ($this->input->post('uf') == "GO" ? " selected" : ""); ?>>
                                    Goiás</option>
                                <option value="MA" <?php echo ($this->input->post('uf') == "MA" ? " selected" : ""); ?>>
                                    Maranhão</option>
                                <option value="MT" <?php echo ($this->input->post('uf') == "MT" ? " selected" : ""); ?>>
                                    Mato Grosso</option>
                                <option value="MS" <?php echo ($this->input->post('uf') == "MS" ? " selected" : ""); ?>>
                                    Mato Grosso do Sul</option>
                                <option value="MG" <?php echo ($this->input->post('uf') == "MG" ? " selected" : ""); ?>>
                                    Minas Gerais</option>
                                <option value="PA" <?php echo ($this->input->post('uf') == "PA" ? " selected" : ""); ?>>
                                    Pará</option>
                                <option value="PB" <?php echo ($this->input->post('uf') == "PB" ? " selected" : ""); ?>>
                                    Paraíba</option>
                                <option value="PR" <?php echo ($this->input->post('uf') == "PR" ? " selected" : ""); ?>>
                                    Paraná</option>
                                <option value="PE" <?php echo ($this->input->post('uf') == "PE" ? " selected" : ""); ?>>
                                    Pernambuco</option>
                                <option value="PI" <?php echo ($this->input->post('uf') == "PI" ? " selected" : ""); ?>>
                                    Piauí</option>
                                <option value="RJ" <?php echo ($this->input->post('uf') == "RJ" ? " selected" : ""); ?>>
                                    Rio de Janeiro</option>
                                <option value="RN" <?php echo ($this->input->post('uf') == "RN" ? " selected" : ""); ?>>
                                    Rio Grande do Norte</option>
                                <option value="RS" <?php echo ($this->input->post('uf') == "RS" ? " selected" : ""); ?>>
                                    Rio Grande do Sul</option>
                                <option value="RO" <?php echo ($this->input->post('uf') == "RO" ? " selected" : ""); ?>>
                                    Rondônia</option>
                                <option value="RR" <?php echo ($this->input->post('uf') == "RR" ? " selected" : ""); ?>>
                                    Roraima</option>
                                <option value="SC" <?php echo ($this->input->post('uf') == "SC" ? " selected" : ""); ?>>
                                    Santa Catarina</option>
                                <option value="SP" <?php echo ($this->input->post('uf') == "SP" ? " selected" : ""); ?>>
                                    São Paulo</option>
                                <option value="SE" <?php echo ($this->input->post('uf') == "SE" ? " selected" : ""); ?>>
                                    Sergipe</option>
                                <option value="TO" <?php echo ($this->input->post('uf') == "TO" ? " selected" : ""); ?>>
                                    Tocantins</option>
                            </select>
                            <span class="text-danger"><?php echo form_error('uf');?></span>
                        </div>
                    </div>
                </div>
                <h4>Beneficiado</h4>
                <div class="row clearfix" id="select-beneficiado">
                    <div class="col-md-6">
                        <label for="select_beneficiado" class="control-label"><span
                                class="text-danger">*</span>Beneficiado</label>
                        <div class="form-group">
                            <select name="select_beneficiado" class="form-control demais-campos" id="select_beneficiado"
                                required>
                                <option value="">Selecione</option>
                                <option value="outro">Outro Beneficiado</option>
                            </select>
                            <span class="text-danger"><?php echo form_error('select_beneficiado');?></span>
                        </div>
                    </div>
                </div>

                <div class="row clearfix" id="form-add-beneficiado" style="display:none;">
                    <div class="col-md-6">
                        <label for="nome_beneficiado" class="control-label"><span
                                class="text-danger">*</span>Nome</label>
                        <div class="form-group">
                            <input type="text" name="nome_beneficiado"
                                value="<?php echo $this->input->post('nome_beneficiado'); ?>"
                                class="form-control demais-campos" id="nome_beneficiado" />
                            <span class="text-danger"><?php echo form_error('nome_beneficiado');?></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label for="data_nascimento_beneficiado" class="control-label"><span
                                class="text-danger">*</span>Data de
                            Nascimento</label>
                        <div class="form-group">
                            <input type="text" name="data_nascimento_beneficiado"
                                value="<?php echo $this->input->post('data_nascimento_beneficiado'); ?>"
                                class="form-control demais-campos" id="data_nascimento_beneficiado" />
                            <span class="text-danger"><?php echo form_error('data_nascimento_beneficiado');?></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label for="sexo_beneficiado" class="control-label"><span class="text-danger">*</span>Sexo</label>
                        <div class="form-group">
                            <select name="sexo_beneficiado" id="sexo_beneficiado" class="form-control">
                                <option value=""></option>
                                <option value="F">Feminino</option>
                                <option value="M">Masculino</option>
                            </select>
                            <span class="text-danger"><?php echo form_error('sexo_beneficiado'); ?></span>
                        </div>
                    </div>
                </div>

                <?php
                $grupos_usuario = $this->session->userdata('grupos_usuario');
                if ($grupos_usuario) {
                    $isAdmin = in_array("admin", $grupos_usuario, true);
                    $isRepresentanteComunidade = in_array("representante-comunidade", $grupos_usuario, true);
                ?>
                <h4>Instituição</h4>
                <div class="row clearfix" id="select-instituicao">
                    <div class="col-md-6">
                        <label for="representante" class="control-label"><span
                                class="text-danger">*</span>Instituição</label>
                        <div class="form-group">
                            <select name="representante" class="form-control<?php echo ($isRepresentanteComunidade && !$isAdmin ? "" : " demais-campos"); ?>" id="representante" required<?php echo ($isRepresentanteComunidade && !$isAdmin ? " disabled" : ""); ?>>

                            <?php if (sizeof($instituicoes) > 0) { ?>
                                <option value="">Selecione</option>
                                <?php foreach ($instituicoes as $i) { ?>
                                    <option value="<?php echo $i["NU_TBP01"]; ?>"<?php echo ($i["NU_TBP01"] == $instituicao_usuario["NU_TBP01"] ? " selected" : ""); ?>><?php echo $i["NO_INSTITUICAO"]; ?></option>
                                <?php
                                }
                            }
                            else {
                                echo "<option value=\"\">Não há instituição vinculada à campanha ".$campanha_atual["NO_CAMPANHA"]."</option>";
                            }
                                ?>
                            </select>
                            <span class="text-danger"><?php echo form_error('representante');?></span>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
            <?php echo form_close(); ?>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-success" id="salvar-carta">
                    <i class="fa fa-check"></i> Salvar
                </button>
            </div>
        </div>
    </div>
</div>
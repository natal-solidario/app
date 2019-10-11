<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Editar Instituição</h3>
            </div>
            <?php echo form_open('instituicao/edit/'.$instituicao['NU_TBP01']); ?>
            <div class="box-body">
                <input type="hidden" id="NU_TBC02" name="NU_TBC02" value="<?php echo $instituicao['ABRANGENCIA_ID'] ?>" />
                <div class="row clearfix">
                    <div class="col-md-3">
                        <label for="NU_CNPJ" class="control-label"><span class="text-danger">*</span>CNPJ</label>
                        <div class="form-group">
                            <input type="text" name="NU_CNPJ"
                                value="<?php echo ($this->input->post('NU_CNPJ') ? $this->input->post('NU_CNPJ') : substr(("00000000000000" . $instituicao["NU_CNPJ"]), -14)); ?>"
                                class="form-control cnpj" id="NU_CNPJ" required />
                            <span class="text-danger"><?php echo form_error('NU_CNPJ');?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="NO_INSTITUICAO" class="control-label"><span class="text-danger">*</span>Nome</label>
                        <div class="form-group">
                            <input type="text" name="NO_INSTITUICAO"
                                value="<?php echo ($this->input->post('NO_INSTITUICAO') ? $this->input->post('NO_INSTITUICAO') : $instituicao["NO_INSTITUICAO"]); ?>"
                                class="form-control" id="NO_INSTITUICAO" required />
                            <span class="text-danger"><?php echo form_error('NO_INSTITUICAO');?></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="DE_TELEFONE" class="control-label">Telefone</label>
                        <div class="form-group">
                            <input type="text" name="DE_TELEFONE"
                                value="<?php echo ($this->input->post('DE_TELEFONE') ? $this->input->post('DE_TELEFONE') : ($instituicao["NU_DDD"] . $instituicao["NU_TELEFONE"])); ?>"
                                class="form-control" id="DE_TELEFONE" />
                            <span class="text-danger"><?php echo form_error('DE_TELEFONE');?></span>
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-md-3">
                        <label for="NU_CEP" class="control-label">CEP</label>
                        <div class="form-group">
                            <input type="text" name="NU_CEP"
                                value="<?php echo ($this->input->post('NU_CEP') ? $this->input->post('NU_CEP') : $instituicao["NU_CEP"]); ?>"
                                class="form-control" id="NU_CEP" />
                            <span class="text-danger"><?php echo form_error('NU_CEP');?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="NO_LOGRADOURO" class="control-label"><span
                                class="text-danger">*</span>Logradouro</label>
                        <div class="form-group">
                            <input type="text" name="NO_LOGRADOURO"
                                value="<?php echo ($this->input->post('NO_LOGRADOURO') ? $this->input->post('NO_LOGRADOURO') : $instituicao["NO_LOGRADOURO"]); ?>"
                                class="form-control" id="NO_LOGRADOURO" required />
                            <span class="text-danger"><?php echo form_error('NO_LOGRADOURO');?></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="NU_ENDERECO" class="control-label">Número</label>
                        <div class="form-group">
                            <input type="text" name="NU_ENDERECO"
                                value="<?php echo ($this->input->post('NU_ENDERECO') ? $this->input->post('NU_ENDERECO') : $instituicao["NU_ENDERECO"]); ?>"
                                class="form-control" id="NU_ENDERECO" />
                            <span class="text-danger"><?php echo form_error('NU_ENDERECO');?></span>
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-md-3">
                        <label for="DE_COMPLEMENTO" class="control-label">Complemento</label>
                        <div class="form-group">
                            <input type="text" name="DE_COMPLEMENTO"
                                value="<?php echo ($this->input->post('DE_COMPLEMENTO') ? $this->input->post('DE_COMPLEMENTO') : $instituicao["DE_COMPLEMENTO"]); ?>"
                                class="form-control" id="DE_COMPLEMENTO" />
                            <span class="text-danger"><?php echo form_error('DE_COMPLEMENTO');?></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="NO_BAIRRO" class="control-label"><span class="text-danger">*</span>Bairro</label>
                        <div class="form-group">
                            <input type="text" name="NO_BAIRRO"
                                value="<?php echo ($this->input->post('NO_BAIRRO') ? $this->input->post('NO_BAIRRO') : $instituicao["NO_BAIRRO"]); ?>"
                                class="form-control" id="NO_BAIRRO" required />
                            <span class="text-danger"><?php echo form_error('NO_BAIRRO');?></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="NO_CIDADE" class="control-label"><span class="text-danger">*</span>Cidade</label>
                        <div class="form-group">
                            <input type="text" name="NO_CIDADE"
                                value="<?php echo ($this->input->post('NO_CIDADE') ? $this->input->post('NO_CIDADE') : $instituicao["NO_CIDADE"]); ?>"
                                class="form-control" id="NO_CIDADE" required />
                            <span class="text-danger"><?php echo form_error('NO_CIDADE');?></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="SG_UF" class="control-label"><span class="text-danger">*</span>UF</label>
                        <div class="form-group">
                            <select name="SG_UF" class="form-control" id="SG_UF" required>
                                <option value="">Selecione</option>
                                <option value="AC"
                                    <?php echo (($this->input->post('SG_UF') ? $this->input->post('SG_UF') : $instituicao["SG_UF"]) == "AC" ? " selected" : ""); ?>>
                                    Acre</option>
                                <option value="AL"
                                    <?php echo (($this->input->post('SG_UF') ? $this->input->post('SG_UF') : $instituicao["SG_UF"]) == "AL" ? " selected" : ""); ?>>
                                    Alagoas</option>
                                <option value="AP"
                                    <?php echo (($this->input->post('SG_UF') ? $this->input->post('SG_UF') : $instituicao["SG_UF"]) == "AP" ? " selected" : ""); ?>>
                                    Amapá</option>
                                <option value="AM"
                                    <?php echo (($this->input->post('SG_UF') ? $this->input->post('SG_UF') : $instituicao["SG_UF"]) == "AM" ? " selected" : ""); ?>>
                                    Amazonas</option>
                                <option value="BA"
                                    <?php echo (($this->input->post('SG_UF') ? $this->input->post('SG_UF') : $instituicao["SG_UF"]) == "BA" ? " selected" : ""); ?>>
                                    Bahia</option>
                                <option value="CE"
                                    <?php echo (($this->input->post('SG_UF') ? $this->input->post('SG_UF') : $instituicao["SG_UF"]) == "CE" ? " selected" : ""); ?>>
                                    Ceará</option>
                                <option value="DF"
                                    <?php echo (($this->input->post('SG_UF') ? $this->input->post('SG_UF') : $instituicao["SG_UF"]) == "DF" ? " selected" : ""); ?>>
                                    Distrito Federal</option>
                                <option value="ES"
                                    <?php echo (($this->input->post('SG_UF') ? $this->input->post('SG_UF') : $instituicao["SG_UF"]) == "ES" ? " selected" : ""); ?>>
                                    Espírito Santo</option>
                                <option value="GO"
                                    <?php echo (($this->input->post('SG_UF') ? $this->input->post('SG_UF') : $instituicao["SG_UF"]) == "GO" ? " selected" : ""); ?>>
                                    Goiás</option>
                                <option value="MA"
                                    <?php echo (($this->input->post('SG_UF') ? $this->input->post('SG_UF') : $instituicao["SG_UF"]) == "MA" ? " selected" : ""); ?>>
                                    Maranhão</option>
                                <option value="MT"
                                    <?php echo (($this->input->post('SG_UF') ? $this->input->post('SG_UF') : $instituicao["SG_UF"]) == "MT" ? " selected" : ""); ?>>
                                    Mato Grosso</option>
                                <option value="MS"
                                    <?php echo (($this->input->post('SG_UF') ? $this->input->post('SG_UF') : $instituicao["SG_UF"]) == "MS" ? " selected" : ""); ?>>
                                    Mato Grosso do Sul</option>
                                <option value="MG"
                                    <?php echo (($this->input->post('SG_UF') ? $this->input->post('SG_UF') : $instituicao["SG_UF"]) == "MG" ? " selected" : ""); ?>>
                                    Minas Gerais</option>
                                <option value="PA"
                                    <?php echo (($this->input->post('SG_UF') ? $this->input->post('SG_UF') : $instituicao["SG_UF"]) == "PA" ? " selected" : ""); ?>>
                                    Pará</option>
                                <option value="PB"
                                    <?php echo (($this->input->post('SG_UF') ? $this->input->post('SG_UF') : $instituicao["SG_UF"]) == "PB" ? " selected" : ""); ?>>
                                    Paraíba</option>
                                <option value="PR"
                                    <?php echo (($this->input->post('SG_UF') ? $this->input->post('SG_UF') : $instituicao["SG_UF"]) == "PR" ? " selected" : ""); ?>>
                                    Paraná</option>
                                <option value="PE"
                                    <?php echo (($this->input->post('SG_UF') ? $this->input->post('SG_UF') : $instituicao["SG_UF"]) == "PE" ? " selected" : ""); ?>>
                                    Pernambuco</option>
                                <option value="PI"
                                    <?php echo (($this->input->post('SG_UF') ? $this->input->post('SG_UF') : $instituicao["SG_UF"]) == "PI" ? " selected" : ""); ?>>
                                    Piauí</option>
                                <option value="RJ"
                                    <?php echo (($this->input->post('SG_UF') ? $this->input->post('SG_UF') : $instituicao["SG_UF"]) == "RJ" ? " selected" : ""); ?>>
                                    Rio de Janeiro</option>
                                <option value="RN"
                                    <?php echo (($this->input->post('SG_UF') ? $this->input->post('SG_UF') : $instituicao["SG_UF"]) == "RN" ? " selected" : ""); ?>>
                                    Rio Grande do Norte</option>
                                <option value="RS"
                                    <?php echo (($this->input->post('SG_UF') ? $this->input->post('SG_UF') : $instituicao["SG_UF"]) == "RS" ? " selected" : ""); ?>>
                                    Rio Grande do Sul</option>
                                <option value="RO"
                                    <?php echo (($this->input->post('SG_UF') ? $this->input->post('SG_UF') : $instituicao["SG_UF"]) == "RO" ? " selected" : ""); ?>>
                                    Rondônia</option>
                                <option value="RR"
                                    <?php echo (($this->input->post('SG_UF') ? $this->input->post('SG_UF') : $instituicao["SG_UF"]) == "RR" ? " selected" : ""); ?>>
                                    Roraima</option>
                                <option value="SC"
                                    <?php echo (($this->input->post('SG_UF') ? $this->input->post('SG_UF') : $instituicao["SG_UF"]) == "SC" ? " selected" : ""); ?>>
                                    Santa Catarina</option>
                                <option value="SP"
                                    <?php echo (($this->input->post('SG_UF') ? $this->input->post('SG_UF') : $instituicao["SG_UF"]) == "SP" ? " selected" : ""); ?>>
                                    São Paulo</option>
                                <option value="SE"
                                    <?php echo (($this->input->post('SG_UF') ? $this->input->post('SG_UF') : $instituicao["SG_UF"]) == "SE" ? " selected" : ""); ?>>
                                    Sergipe</option>
                                <option value="TO"
                                    <?php echo (($this->input->post('SG_UF') ? $this->input->post('SG_UF') : $instituicao["SG_UF"]) == "TO" ? " selected" : ""); ?>>
                                    Tocantins</option>
                            </select>
                            <span class="text-danger"><?php echo form_error('SG_UF');?></span>
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-md-6">
                        <label for="ID_REGIAO_ADMINISTRATIVA" class="control-label"><span
                                class="text-danger">*</span>Região Administrativa</label>
                        <div class="form-group">
                            <select class="form-control" name="ID_REGIAO_ADMINISTRATIVA" id="ID_REGIAO_ADMINISTRATIVA"
                                required>
                                <option value="">Selecione</option>
                                <?php 
                                    foreach($ras as $ra)
                                    {
                                        echo '<option value="' . $ra->id . '"' . (($this->input->post('ID_REGIAO_ADMINISTRATIVA') ? $this->input->post('ID_REGIAO_ADMINISTRATIVA') : $instituicao["ID_REGIAO_ADMINISTRATIVA"]) == $ra->id ? " selected" : "") . '>'
                                                . $ra->nome . 
                                                '</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="ID_USUARIO" class="control-label"><span class="text-danger">*</span>Usuário
                            Responsável</label>
                        <div class="form-group">
                            <select class="form-control" name="ID_USUARIO" id="ID_USUARIO" required>
                                <option value="">Selecione</option>
                                <?php 
                                    foreach($usuarios as $u)
                                    {
                                        echo '<option value="' . $u["id"] . '"' . (($this->input->post('ID_USUARIO') ? $this->input->post('ID_USUARIO') : $instituicao["ID_USUARIO"]) == $u["id"] ? " selected" : "") . '>'
                                                    . $u["first_name"] . 
                                                '</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="checkbox" value="1" name="vinculo-campanha-atual" id="vinculo-campanha-atual" <?php echo (($this->input->post('ID_USUARIO') ? $this->input->post('ID_USUARIO') : $instituicao['vinculo_campanha_atual']) ? ' checked' : '');?> /> <label for="vinculo-campanha-atual" class="control-label">Vincular com a campanha vigente</label>
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
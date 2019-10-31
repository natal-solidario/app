<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Upload em Lote das imagens das cartas</h3>
            </div>
            <div class="box-body">
                <?php echo form_open_multipart('carta/upload', array('id' => 'form-upload')); ?>

                <?php $permissoes_usuario = $this->session->userdata('permissoes_usuario'); ?>

                <?php if (array_key_exists("permite_categorizar_upload_lote", $permissoes_usuario)) { ?>
                <div class="row clearfix">
                    <div class="col-md-6">
                        <label for="categoria" class="control-label">Categoria</label>
                        <div class="form-group">
                            <select name="categoria" class="form-control" id="categoria">
                                <?php foreach ($categorias as $c) { ?>
                                <option value="<?php echo $c['id']; ?>"><?php echo $c['nome']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <span class="text-danger"><?php echo form_error('categoria');?></span>
                        </div>
                    </div>
                </div>
                <?php
                }
                else
                {
                ?>
                <input type="hidden" id="categoria" name="categoria" value="1" />
                <?php
                }
                ?>
                
                <div class="row clearfix">
                    <div class="col-md-6">
                        <label for="imagens" class="control-label">Anexar a(s) foto(s) da(s) carta(s):</label>
                        <div class="form-group">
                            <input type="file" id="imagens" name="imagens[]" multiple="multiple" class="form-control"
                                required />
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-success" id="salvar-upload">
                    <i class="fa fa-check"></i> Enviar
                </button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Cartas não localizadas</h3>
            </div>
            <div class="box-body">
                <div class="row clearfix">
                    <?php foreach ($galeria as $arquivo) { ?>
                    <div class="col-md-3">
                        <label class="control-label"><?php echo $arquivo['nome_arquivo']; ?></label>
                        <div class="form-group">
                            <img class="img-thumbnail rounded"
                                src="<?php echo base_url($arquivo['caminho'].'/'.$arquivo['nome_arquivo']); ?>" />
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
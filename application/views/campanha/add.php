<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Nova Campanha</h3>
            </div>
            <?php echo form_open('campanha/add'); ?>
            <div class="box-body">
                <div class="row clearfix">
                    <div class="col-md-8">
                        <label for="NO_CAMPANHA" class="control-label"><span class="text-danger">*</span>Nome da
                            Campanha</label>
                        <div class="form-group">
                            <input type="text" name="NO_CAMPANHA" value="<?php echo $this->input->post('NO_CAMPANHA'); ?>"
                                class="form-control" id="NO_CAMPANHA" />
                            <span class="text-danger"><?php echo form_error('NO_CAMPANHA');?></span>
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-md-4">
                        <label for="AA_CAMPANHA" class="control-label"><span class="text-danger">*</span>Ano da Campanha</label>
                        <div class="form-group">
                            <input type="text" name="AA_CAMPANHA" value="<?php echo $this->input->post('AA_CAMPANHA'); ?>"
                                class="form-control" id="AA_CAMPANHA" />
                            <span class="text-danger"><?php echo form_error('AA_CAMPANHA');?></span>
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